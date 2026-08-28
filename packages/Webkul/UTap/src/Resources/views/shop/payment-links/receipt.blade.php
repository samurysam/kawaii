@push('styles')
<style>
    .kb-pay-wrap {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px 16px 60px;
    }
    .kb-pay-card {
        width: 100%;
        max-width: 520px;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid #f6d1dd;
        border-radius: 28px;
        padding: 36px 32px 30px;
        box-shadow: 0 16px 45px rgba(226, 116, 157, 0.14);
        position: relative;
    }
    .kb-pay-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 800;
        color: #059669;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        margin-bottom: 12px;
    }
    .kb-pay-title {
        font-size: 30px;
        font-weight: 800;
        color: #2b1f24;
        margin: 0 0 4px;
        font-family: 'Fredoka', sans-serif;
        letter-spacing: -0.02em;
    }
    .kb-amount-box {
        background: linear-gradient(135deg, #fff7fa 0%, #fff0f5 100%);
        border: 2px dashed #f2becf;
        border-radius: 20px;
        padding: 22px 16px;
        text-align: center;
        margin: 20px 0;
    }
    .kb-amount-label {
        font-size: 11.5px;
        font-weight: 800;
        color: #926d7c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .kb-amount-val {
        font-size: 38px;
        font-weight: 900;
        color: #ed5287;
        margin: 0;
        line-height: 1.1;
    }
    .kb-details-box {
        background: #fffafc;
        border: 1px solid #f6d8e2;
        border-radius: 18px;
        padding: 16px;
        margin-bottom: 24px;
        font-size: 13px;
    }
    .kb-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 0;
        border-bottom: 1px solid #fcedf2;
    }
    .kb-detail-row:last-child {
        border-bottom: none;
    }
    .kb-detail-row.full {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }
    .kb-detail-label {
        color: #8c6f7b;
        font-weight: 600;
    }
    .kb-detail-val {
        color: #2e2327;
        font-weight: 700;
    }
    .kb-receipt-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .kb-btn-print {
        padding: 14px;
        border-radius: 14px;
        border: 1.5px solid #f5ccd9;
        background: #fff0f5;
        color: #826671;
        font-size: 13.5px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all .18s;
    }
    .kb-btn-print:hover {
        background: #ffe4ee;
        color: #4b3940;
    }
    .kb-btn-home {
        padding: 14px;
        border-radius: 14px;
        border: 0;
        background: linear-gradient(135deg, #f58aab 0%, #ed5287 100%);
        color: #fff;
        font-size: 13.5px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 8px 20px rgba(237, 82, 135, 0.28);
        transition: all .18s;
    }
    .kb-btn-home:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(237, 82, 135, 0.35);
    }
</style>
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Payment Receipt #{{ strtoupper($paymentLink->link_code) }} — Kawaii Blessings
    </x-slot>

    <div class="kb-pay-wrap">
        <div class="kb-pay-card" id="kbPrintArea">
            <div style="text-align:center;">
                <div style="width:60px;height:60px;border-radius:999px;background:#d1fae5;color:#10b981;font-size:28px;display:grid;place-items:center;margin:0 auto 12px;">
                    ✓
                </div>
                <span class="kb-pay-badge">
                    ✓ Payment Verified
                </span>
                <h1 class="kb-pay-title">Thank You, {{ $paymentLink->name }}! 💖</h1>
                <p style="font-size:12.5px;color:#826671;margin:0;">
                    A confirmation receipt has been emailed to <strong style="color:#ed5287;">{{ $paymentLink->email }}</strong>
                </p>
            </div>

            <div class="kb-amount-box">
                <div class="kb-amount-label">Amount Paid</div>
                <div class="kb-amount-val">AED {{ number_format((float) $paymentLink->amount, 2) }}</div>
            </div>

            <div class="kb-details-box">
                <div class="kb-detail-row">
                    <span class="kb-detail-label">Reference Code</span>
                    <span class="kb-detail-val font-mono" style="color:#ed5287;">#{{ strtoupper($paymentLink->link_code) }}</span>
                </div>
                @if($paymentLink->utap_txn_id)
                <div class="kb-detail-row">
                    <span class="kb-detail-label">Transaction ID</span>
                    <span class="kb-detail-val font-mono">{{ $paymentLink->utap_txn_id }}</span>
                </div>
                @endif
                <div class="kb-detail-row">
                    <span class="kb-detail-label">Date & Time</span>
                    <span class="kb-detail-val">{{ $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</span>
                </div>
                <div class="kb-detail-row">
                    <span class="kb-detail-label">Payment Gateway</span>
                    <span class="kb-detail-val">uTap by e&</span>
                </div>
                <div class="kb-detail-row">
                    <span class="kb-detail-label">Payer Email</span>
                    <span class="kb-detail-val">{{ $paymentLink->email }}</span>
                </div>
                @if($paymentLink->phone)
                <div class="kb-detail-row">
                    <span class="kb-detail-label">Payer Phone</span>
                    <span class="kb-detail-val">{{ $paymentLink->phone }}</span>
                </div>
                @endif
                <div class="kb-detail-row full">
                    <span class="kb-detail-label">Reason for Payment:</span>
                    <div class="kb-detail-val" style="width:100%;padding:10px 12px;background:#fff;border:1px solid #f6d8e2;border-radius:12px;box-sizing:border-box;">
                        {{ $paymentLink->reason }}
                    </div>
                </div>
            </div>

            <div class="kb-receipt-actions">
                <button type="button" onclick="window.print()" class="kb-btn-print">
                    🖨️ Print Receipt
                </button>
                <a href="{{ route('shop.home.index') }}" class="kb-btn-home">
                    🛍️ Return Home
                </a>
            </div>
        </div>
    </div>
</x-shop::layouts>
