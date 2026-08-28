<?php

namespace Webkul\UTap\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webkul\Payment\Payment\Payment;

class UTap extends Payment
{
    protected $code = 'utap';

    protected const LIVE_ENDPOINTS = [
        'login' => 'https://gwlive.utapbyeand.com/MswipeGenericAPI/api/login',
        'payment_link' => 'https://gwlive.utapbyeand.com/IPG/IPGEpg/GetPaymentLink',
        'check_status' => 'https://gwlive.utapbyeand.com/IPG/IPGEpg/CheckStatus',
        'transaction_data' => 'https://gwlive.utapbyeand.com/IPG/IPGEpg/TransactionData',
    ];

    protected const UAT_ENDPOINTS = [
        'login' => 'https://gwuaeuat.mswipedemo.com:8112/MswipeGenericAPI/api/login',
        'payment_link' => 'https://gwuaeuat.mswipedemo.com:8112/IPG/IPGEpg/GetPaymentLink',
        'check_status' => 'https://gwuaeuat.mswipedemo.com:8112/IPG/IPGEpg/CheckStatus',
        'transaction_data' => 'https://gwuaeuat.mswipedemo.com:8112/IPG/IPGEpg/TransactionData',
    ];

    public function getRedirectUrl(): string
    {
        return route('utap.redirect');
    }

    public function isAvailable(): bool
    {
        return parent::isAvailable() && $this->hasValidCredentials();
    }

    public function getTitle(): string
    {
        return $this->getConfigData('title') ?? trans('utap::app.title');
    }

    public function getDescription(): string
    {
        return $this->getConfigData('description') ?? trans('utap::app.description');
    }

    public function getImage(): string
    {
        $url = $this->getConfigData('image');

        if ($url) {
            return Storage::url($url);
        }

        $svg = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" width="55" height="45" viewBox="0 0 55 45" fill="none">
  <rect width="55" height="45" rx="10" fill="#0F172A"/>
  <rect x="4" y="4" width="47" height="37" rx="8" fill="#111827"/>
  <path d="M17 15H22V28C22 30.7614 19.7614 33 17 33V15Z" fill="#22C55E"/>
  <path d="M24 15H29V33H24V15Z" fill="#38BDF8"/>
  <path d="M31 15H38C40.7614 15 43 17.2386 43 20V20C43 22.7614 40.7614 25 38 25H36V33H31V15ZM36 20V20.5H37.5C38.3284 20.5 39 19.8284 39 19V19C39 18.1716 38.3284 17.5 37.5 17.5H36V20Z" fill="#F8FAFC"/>
</svg>
SVG;

        return 'data:image/svg+xml,'.rawurlencode($svg);
    }

    public function getSupportedCurrencies(): array
    {
        $configured = array_filter(array_map(
            static fn ($value) => strtoupper(trim($value)),
            explode(',', (string) ($this->getConfigData('accepted_currencies') ?: 'AED'))
        ));

        return array_values($configured ?: ['AED']);
    }

    public function isCurrencySupported(string $currency): bool
    {
        return in_array(strtoupper($currency), $this->getSupportedCurrencies(), true);
    }

    public function getCurrency($cart): string
    {
        return strtoupper($cart->base_currency_code ?? core()->getBaseCurrencyCode());
    }

    public function hasValidCredentials(): bool
    {
        return ! empty($this->getUserName())
            && ! empty($this->getUserPassword())
            && ! empty($this->getEffectiveCustomerCode());
    }

    public function createPaymentLink($cart): array
    {
        $invoiceId = $this->generateInvoiceId((int) $cart->id);
        $requestId = $this->generateRequestId();
        $login = $this->login();

        if (! ($login['token'] ?? null)) {
            return [
                'ok' => false,
                'message' => $login['message'] ?? trans('utap::app.response.payment-failed'),
                'invoice_id' => $invoiceId,
                'request_id' => $requestId,
            ];
        }

        $payload = [
            'versionNo' => 'VER4.0.0',
            'invoice_id' => $invoiceId,
            'refid' => $this->getReferenceId() ?: $this->getUserName(),
            'SessionToken' => $login['token'],
            'sessiontoken' => $login['token'],
            'mobileNo' => $this->normalizePhone($cart->billing_address->phone ?? $cart->customer_phone ?? ''),
            'amount' => number_format((float) $cart->base_grand_total, 2, '.', ''),
            'custCode' => $this->getEffectiveCustomerCode(),
            'Cust_GroupCustCode' => $this->getCustomerGroupCode() ?: $this->getEffectiveCustomerCode(),
            'emailId' => $cart->customer_email ?? '',
            'addlNote1' => 'Cart #'.$cart->id,
            'addlNote2' => trim((string) $cart->customer_full_name),
            'addlNote3' => config('app.name'),
            'addlNote4' => config('app.url'),
            'callBackUrl' => route('utap.callback', ['cartId' => $cart->id]),
            'requestId' => $requestId,
            'linkValidity' => (string) ((int) ($this->getConfigData('link_validity') ?: 30)),
            'Client_Code' => $this->getClientCode(),
            'UserId' => $this->getUserName(),
        ];

        $response = Http::asJson()
            ->acceptJson()
            ->timeout(20)
            ->post($this->endpoints()['payment_link'], $payload);

        $json = $this->decodeJsonResponse($response->body());

        $link = $json['SMSLink'] ?? null;
        $txnId = $json['Txn_ID'] ?? null;
        $ipgId = $this->extractIpgId($link);
        $message = $json['ResponseMessage'] ?? ($link ? 'Success' : trans('utap::app.response.payment-failed'));

        return [
            'ok' => $response->successful() && ! empty($link),
            'message' => $message,
            'invoice_id' => $invoiceId,
            'request_id' => $requestId,
            'txn_id' => $txnId,
            'ipg_id' => $ipgId,
            'link' => $link,
            'raw' => $json,
            'login' => $login['raw'] ?? null,
        ];
    }

    public function createPaymentLinkForPaymentModel($paymentLink): array
    {
        $invoiceId = 'UTAP-PL-'.$paymentLink->id.'-'.Str::upper(Str::random(6));
        $requestId = $this->generateRequestId();
        $login = $this->login();

        if (! ($login['token'] ?? null)) {
            return [
                'ok' => false,
                'message' => $login['message'] ?? trans('utap::app.response.payment-failed'),
                'invoice_id' => $invoiceId,
                'request_id' => $requestId,
            ];
        }

        $payload = [
            'versionNo' => 'VER4.0.0',
            'invoice_id' => $invoiceId,
            'refid' => $this->getReferenceId() ?: $this->getUserName(),
            'SessionToken' => $login['token'],
            'sessiontoken' => $login['token'],
            'mobileNo' => $this->normalizePhone($paymentLink->phone),
            'amount' => number_format((float) $paymentLink->amount, 2, '.', ''),
            'custCode' => $this->getEffectiveCustomerCode(),
            'Cust_GroupCustCode' => $this->getCustomerGroupCode() ?: $this->getEffectiveCustomerCode(),
            'emailId' => $paymentLink->email ?? '',
            'addlNote1' => 'Payment #'.$paymentLink->link_code,
            'addlNote2' => substr(trim((string) $paymentLink->name), 0, 50),
            'addlNote3' => substr(trim((string) $paymentLink->reason), 0, 50),
            'addlNote4' => config('app.name'),
            'callBackUrl' => route('payment_link.callback', ['linkCode' => $paymentLink->link_code]),
            'requestId' => $requestId,
            'linkValidity' => (string) ((int) ($this->getConfigData('link_validity') ?: 30)),
            'Client_Code' => $this->getClientCode(),
            'UserId' => $this->getUserName(),
        ];

        $response = Http::asJson()
            ->acceptJson()
            ->timeout(20)
            ->post($this->endpoints()['payment_link'], $payload);

        $json = $this->decodeJsonResponse($response->body());

        $link = $json['SMSLink'] ?? null;
        $txnId = $json['Txn_ID'] ?? null;
        $ipgId = $this->extractIpgId($link);
        $message = $json['ResponseMessage'] ?? ($link ? 'Success' : trans('utap::app.response.payment-failed'));

        return [
            'ok' => $response->successful() && ! empty($link),
            'message' => $message,
            'invoice_id' => $invoiceId,
            'request_id' => $requestId,
            'txn_id' => $txnId,
            'ipg_id' => $ipgId,
            'link' => $link,
            'raw' => $json,
            'login' => $login['raw'] ?? null,
        ];
    }

    public function checkPaymentStatus(string $ipgId): array
    {
        $login = $this->login();

        if (! ($login['token'] ?? null)) {
            return [
                'paid' => false,
                'status_code' => null,
                'description' => $login['message'] ?? 'uTap login failed',
                'order_id' => null,
                'raw' => $login['raw'] ?? null,
            ];
        }

        $response = Http::asJson()
            ->acceptJson()
            ->timeout(20)
            ->post($this->endpoints()['check_status'], [
                'refid' => $this->getReferenceId() ?: $this->getUserName(),
                'sessiontoken' => $login['token'],
                'ipgid' => $ipgId,
                'Client_Code' => $this->getClientCode(),
            ]);

        $json = $this->decodeJsonResponse($response->body());
        $payload = is_array($json['Payload'] ?? null) ? $json['Payload'] : [];
        $statusCode = isset($payload['Status']) ? (string) $payload['Status'] : null;

        return [
            'paid' => $statusCode === '0',
            'status_code' => $statusCode,
            'description' => $payload['StatusDesc'] ?? $json['Message'] ?? null,
            'order_id' => $payload['OrderID'] ?? null,
            'raw' => $json,
        ];
    }

    public function getTransactionData(string $transactionId): ?array
    {
        $response = Http::asJson()
            ->acceptJson()
            ->timeout(20)
            ->post($this->endpoints()['transaction_data'], [
                'tranID' => $transactionId,
            ]);

        return $this->decodeJsonResponse($response->body());
    }

    public function getIntentCacheKey(int $cartId): string
    {
        return 'utap.intent.'.$cartId;
    }

    public function parseCartId(?string $invoiceId): ?int
    {
        if (! preg_match('/^UTAP-(\d+)-/i', (string) $invoiceId, $matches)) {
            return null;
        }

        return (int) $matches[1];
    }

    protected function generateInvoiceId(int $cartId): string
    {
        return 'UTAP-'.$cartId.'-'.Str::upper(Str::random(8));
    }

    protected function generateRequestId(): string
    {
        return now()->format('YmdHis').random_int(100, 999);
    }

    protected function login(): array
    {
        $payload = array_filter([
            'user_name' => $this->getUserName(),
            'user_pwd' => $this->getUserPassword(),
            'Client_Code' => $this->getClientCode(),
            'UserId' => $this->getUserName(),
            'UserPwd' => $this->getUserPassword(),
        ], static fn ($value) => $value !== null && $value !== '');

        $response = Http::asJson()
            ->acceptJson()
            ->timeout(20)
            ->post($this->endpoints()['login'], $payload);

        $json = $this->decodeJsonResponse($response->body());
        $token = $json['token'] ?? null;

        return [
            'token' => $response->successful() ? $token : null,
            'message' => $json['response_message'] ?? ($token ? 'login successful' : 'uTap login failed'),
            'raw' => $json,
        ];
    }

    protected function endpoints(): array
    {
        return $this->isSandbox()
            ? self::UAT_ENDPOINTS
            : self::LIVE_ENDPOINTS;
    }

    protected function isSandbox(): bool
    {
        return (bool) $this->getConfigData('sandbox');
    }

    protected function getClientCode(): ?string
    {
        return $this->getConfigData('client_code');
    }

    protected function getUserName(): ?string
    {
        return $this->getConfigData('user_name');
    }

    protected function getUserPassword(): ?string
    {
        return $this->getConfigData('user_pwd');
    }

    protected function getCustomerCode(): ?string
    {
        return $this->getConfigData('cust_code');
    }

    protected function getCustomerGroupCode(): ?string
    {
        return $this->getConfigData('cust_group_cust_code');
    }

    protected function getEffectiveCustomerCode(): ?string
    {
        return $this->getCustomerCode() ?: $this->getCustomerGroupCode();
    }

    protected function getReferenceId(): ?string
    {
        return $this->getConfigData('ref_id');
    }

    protected function extractIpgId(?string $link): ?string
    {
        if (! $link || ! preg_match('/[?&]TransID=([^&]+)/i', $link, $matches)) {
            return null;
        }

        return urldecode($matches[1]);
    }

    protected function decodeJsonResponse(string $body): array
    {
        $decoded = json_decode($body, true);

        if (is_array($decoded)) {
            return $decoded;
        }

        return ['raw' => $body];
    }

    protected function normalizePhone(?string $phone): string
    {
        return preg_replace('/\D+/', '', (string) $phone) ?: '';
    }
}
