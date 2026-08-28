<?php

namespace Webkul\UTap\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Sales\Contracts\Order as OrderContract;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\UTap\Payment\UTap;

class UTapController extends Controller
{
    public const PAYMENT_SUCCESS = 'success';

    public function __construct(
        protected CartRepository $cartRepository,
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected InvoiceRepository $invoiceRepository,
        protected UTap $uTap,
    ) {}

    public function redirect(): RedirectResponse
    {
        if (! $this->uTap->hasValidCredentials()) {
            session()->flash('error', trans('utap::app.response.provide-credentials'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $cart = Cart::getCart();

        if (! $cart) {
            session()->flash('error', trans('utap::app.response.cart-not-found'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $currency = $this->uTap->getCurrency($cart);

        if (! $this->uTap->isCurrencySupported($currency)) {
            session()->flash('error', trans('utap::app.response.supported-currency-error', [
                'currency' => $currency,
                'supportedCurrencies' => implode(', ', $this->uTap->getSupportedCurrencies()),
            ]));

            return redirect()->route('shop.checkout.cart.index');
        }

        $response = $this->uTap->createPaymentLink($cart);

        if (! ($response['ok'] ?? false) || empty($response['link'])) {
            session()->flash('error', $response['message'] ?? trans('utap::app.response.payment-failed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        Cache::put(
            $this->uTap->getIntentCacheKey((int) $cart->id),
            [
                'invoice_id' => $response['invoice_id'] ?? null,
                'txn_id' => $response['txn_id'] ?? null,
                'ipg_id' => $response['ipg_id'] ?? null,
                'request_id' => $response['request_id'] ?? null,
            ],
            now()->addDay()
        );

        return redirect()->away($response['link']);
    }

    public function callback(?int $cartId = null): RedirectResponse
    {
        $payload = request()->all();

        $resolvedCartId = $cartId
            ?: $this->uTap->parseCartId(
                $this->value($payload, ['InvoiceID', 'invoice_id'])
            );

        try {
            $this->settle($resolvedCartId, $payload);
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('utap.success', array_filter([
            'cartId' => $resolvedCartId,
        ]));
    }

    public function success(): RedirectResponse
    {
        $cartId = request()->integer('cartId') ?: Cart::getCart()?->id;

        $order = $cartId
            ? $this->orderRepository->findOneWhere(['cart_id' => $cartId])
            : null;

        if (! $order) {
            session()->flash('error', trans('utap::app.response.payment-failed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        session()->flash('order_id', $order->id);
        session()->flash('success', trans('utap::app.response.payment-success'));

        return redirect()->route('shop.checkout.onepage.success');
    }

    protected function settle(?int $cartId, array $payload): ?OrderContract
    {
        if (! $cartId) {
            return null;
        }

        if ($order = $this->orderRepository->findOneWhere(['cart_id' => $cartId])) {
            return $order;
        }

        $cart = $this->cartRepository->find($cartId);

        if (! $cart || ! $cart->is_active) {
            return null;
        }

        $intent = Cache::get($this->uTap->getIntentCacheKey($cartId), []);

        $ipgId = $this->value($payload, ['En_Ipg_ID', 'en_ipg_id'])
            ?: ($intent['ipg_id'] ?? null);

        if (! $ipgId) {
            return null;
        }

        $status = $this->uTap->checkPaymentStatus($ipgId);

        if (! ($status['paid'] ?? false)) {
            return null;
        }

        $txnId = $this->value($payload, ['TransID', 'trans_id'])
            ?: ($intent['txn_id'] ?? null);

        $transactionData = null;

        if ($txnId) {
            try {
                $transactionData = $this->uTap->getTransactionData($txnId);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return DB::transaction(function () use ($cart, $cartId, $payload, $status, $transactionData, $txnId, $ipgId, $intent) {
            Cart::setCart($cart);
            Cart::collectTotals();

            $freshCart = Cart::getCart();

            if (! $freshCart) {
                return null;
            }

            $data = (new OrderResource($freshCart))->jsonSerialize();

            $data['payment']['additional'] = [
                'utap_invoice_id' => $this->value($payload, ['InvoiceID', 'invoice_id']) ?: ($intent['invoice_id'] ?? null),
                'utap_txn_id' => $txnId,
                'utap_payment_id' => $this->value($payload, ['PaymentID', 'payment_id']),
                'utap_gateway_order_id' => $status['order_id'] ?? $this->value($payload, ['OrderID', 'order_id']),
                'utap_ipg_id' => $ipgId,
                'utap_status' => $status['status_code'] ?? $this->value($payload, ['Status', 'status']),
            ];

            $order = $this->orderRepository->create($data);

            $this->orderRepository->update(['status' => Order::STATUS_PROCESSING], $order->id);

            if ($order->canInvoice()) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

                $this->orderTransactionRepository->create([
                    'transaction_id' => $txnId ?: (string) ($status['order_id'] ?? $order->id),
                    'status' => self::PAYMENT_SUCCESS,
                    'type' => $order->payment->method,
                    'payment_method' => $order->payment->method,
                    'order_id' => $order->id,
                    'invoice_id' => $invoice->id,
                    'amount' => $order->base_grand_total,
                    'data' => json_encode([
                        'callback' => $payload,
                        'status' => $status['raw'] ?? null,
                        'transaction' => $transactionData,
                    ]),
                ]);
            }

            Cart::deActivateCart();
            Cache::forget($this->uTap->getIntentCacheKey($cartId));

            return $order;
        });
    }

    protected function prepareInvoiceData(OrderContract $order): array
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    protected function value(array $payload, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $payload[$key] ?? null;

            if ($value !== null && $value !== '') {
                return (string) $value;
            }
        }

        return null;
    }
}
