<?php

namespace Webkul\UTap\Http\Controllers\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\UTap\Mail\PaymentLinkReceiptMail;
use Webkul\UTap\Models\PaymentLink;
use Webkul\UTap\Payment\UTap;
use Webkul\UTap\Repositories\PaymentLinkRepository;

class PublicPaymentLinkController extends Controller
{
    public function __construct(
        protected PaymentLinkRepository $paymentLinkRepository,
        protected UTap $uTap,
    ) {}

    public function openPay(): View
    {
        return view('utap::shop.payment-links.open-pay');
    }

    public function submitOpenPay(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'reason' => 'required|string|max:1000',
        ]);

        $paymentLink = $this->paymentLinkRepository->createPaymentLink([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'amount' => (float) $validated['amount'],
            'currency' => 'AED',
            'reason' => $validated['reason'],
            'type' => PaymentLink::TYPE_PUBLIC_QR,
            'status' => PaymentLink::STATUS_PENDING,
        ]);

        return $this->process($paymentLink->link_code);
    }

    public function checkout(string $linkCode): View
    {
        $paymentLink = $this->paymentLinkRepository->findByCode($linkCode);

        if (! $paymentLink) {
            abort(404, 'Payment link not found');
        }

        return view('utap::shop.payment-links.checkout', compact('paymentLink'));
    }

    public function process(string $linkCode): RedirectResponse
    {
        $paymentLink = $this->paymentLinkRepository->findByCode($linkCode);

        if (! $paymentLink) {
            abort(404, 'Payment link not found');
        }

        if ($paymentLink->isPaid()) {
            return redirect()->route('payment_link.receipt', ['linkCode' => $linkCode]);
        }

        if (! $this->uTap->hasValidCredentials()) {
            session()->flash('error', trans('utap::app.response.provide-credentials'));

            return redirect()->route('payment_link.checkout', ['linkCode' => $linkCode]);
        }

        $response = $this->uTap->createPaymentLinkForPaymentModel($paymentLink);

        if (! ($response['ok'] ?? false) || empty($response['link'])) {
            session()->flash('error', $response['message'] ?? 'Unable to connect with uTap gateway. Please try again.');

            return redirect()->route('payment_link.checkout', ['linkCode' => $linkCode]);
        }

        $this->paymentLinkRepository->update([
            'utap_invoice_id' => $response['invoice_id'] ?? null,
            'utap_ipg_id' => $response['ipg_id'] ?? null,
            'utap_txn_id' => $response['txn_id'] ?? null,
            'utap_payment_link' => $response['link'] ?? null,
        ], $paymentLink->id);

        Cache::put(
            'utap.pl.intent.'.$paymentLink->link_code,
            [
                'invoice_id' => $response['invoice_id'] ?? null,
                'txn_id' => $response['txn_id'] ?? null,
                'ipg_id' => $response['ipg_id'] ?? null,
            ],
            now()->addDay()
        );

        return redirect()->away($response['link']);
    }

    public function callback(string $linkCode): RedirectResponse
    {
        $paymentLink = $this->paymentLinkRepository->findByCode($linkCode);

        if (! $paymentLink) {
            abort(404, 'Payment link not found');
        }

        $payload = request()->all();
        $intent = Cache::get('utap.pl.intent.'.$paymentLink->link_code, []);

        $ipgId = $payload['En_Ipg_ID'] ?? $payload['en_ipg_id'] ?? $intent['ipg_id'] ?? $paymentLink->utap_ipg_id;
        $txnId = $payload['TransID'] ?? $payload['trans_id'] ?? $intent['txn_id'] ?? $paymentLink->utap_txn_id;

        $isPaid = false;

        if ($ipgId) {
            try {
                $status = $this->uTap->checkPaymentStatus($ipgId);
                $isPaid = ($status['paid'] ?? false);
            } catch (\Throwable $e) {
                Log::error('uTap payment link checkStatus error: '.$e->getMessage());
            }
        }

        if ($isPaid || ($payload['Status'] ?? null) === '0') {
            $this->paymentLinkRepository->update([
                'status' => PaymentLink::STATUS_COMPLETED,
                'paid_at' => now(),
                'utap_txn_id' => $txnId ?: ($paymentLink->utap_txn_id ?? 'UTAP-'.time()),
            ], $paymentLink->id);

            $freshPayment = $this->paymentLinkRepository->find($paymentLink->id);

            try {
                Mail::send(new PaymentLinkReceiptMail($freshPayment));
            } catch (\Throwable $e) {
                Log::error('Failed to send Payment Link email receipt: '.$e->getMessage());
            }

            Cache::forget('utap.pl.intent.'.$paymentLink->link_code);

            return redirect()->route('payment_link.receipt', ['linkCode' => $linkCode]);
        }

        session()->flash('error', 'Payment could not be confirmed. Please check with your bank or try again.');

        return redirect()->route('payment_link.checkout', ['linkCode' => $linkCode]);
    }

    public function receipt(string $linkCode): View
    {
        $paymentLink = $this->paymentLinkRepository->findByCode($linkCode);

        if (! $paymentLink) {
            abort(404, 'Payment link not found');
        }

        return view('utap::shop.payment-links.receipt', compact('paymentLink'));
    }
}
