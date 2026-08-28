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
        color: #ed5287;
        background: #fff0f5;
        border: 1px solid #f6ccd9;
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
        margin: 24px 0 20px;
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
    .kb-pay-submit {
        width: 100%;
        padding: 16px;
        border: 0;
        border-radius: 18px;
        background: linear-gradient(135deg, #f58aab 0%, #ed5287 100%);
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(237, 82, 135, 0.30);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: transform .2s, box-shadow .2s;
    }
    .kb-pay-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(237, 82, 135, 0.38);
    }
    .kb-pay-submit:active {
        transform: translateY(0);
    }
    .kb-trust-bar {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #f6dce4;
        display: flex;
        align-items: center;
        justify-content: space-around;
        font-size: 11px;
        font-weight: 700;
        color: #927782;
    }
</style>
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Payment Request #{{ strtoupper($paymentLink->link_code) }} — Kawaii Blessings
    </x-slot>

    <div class="kb-pay-wrap">
        <div class="kb-pay-card">
            @if($paymentLink->isPaid())
                <div style="text-align:center;padding:16px 0;">
                    <div style="width:64px;height:64px;border-radius:999px;background:#d1fae5;color:#10b981;font-size:32px;display:grid;place-items:center;margin:0 auto 16px;">
                        ✓
                    </div>
                    <h1 class="kb-pay-title">Payment Completed! 💖</h1>
                    <p style="font-size:14px;color:#6b7280;margin:0 0 24px;">
                        This payment of <strong style="color:#1f2937;">AED {{ number_format((float) $paymentLink->amount, 2) }}</strong> was completed on {{ $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : '' }}.
                    </p>
                    <a
                        href="{{ route('payment_link.receipt', ['linkCode' => $paymentLink->link_code]) }}"
                        class="kb-pay-submit"
                        style="text-decoration:none;"
                    >
                        View Official Receipt 📄
                    </a>
                </div>
            @elseif($paymentLink->isExpired())
                <div style="text-align:center;padding:16px 0;">
                    <div style="width:64px;height:64px;border-radius:999px;background:#f3f4f6;color:#9ca3af;font-size:30px;display:grid;place-items:center;margin:0 auto 16px;">
                        ⏱️
                    </div>
                    <h1 class="kb-pay-title">Payment Link Expired</h1>
                    <p style="font-size:14px;color:#6b7280;margin:0 0 24px;">
                        This payment link is no longer active. Please contact Kawaii Blessings for a new link.
                    </p>
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="kb-pay-submit"
                        style="text-decoration:none;background:#f3f4f6;color:#374151;border:1px solid #d1d5db;box-shadow:none;"
                    >
                        Return to Store 🛍️
                    </a>
                </div>
            @else
                <div style="text-align:center;">
                    <span class="kb-pay-badge">
                        <span style="color:#d9a84f;">✦</span> Kawaii Blessings Payment Request
                    </span>
                    <h1 class="kb-pay-title">Payment Summary 💖</h1>
                    <p style="font-size:12px;color:#9ca3af;margin:0;">
                        Reference: #{{ strtoupper($paymentLink->link_code) }}
                    </p>
                </div>

                @if(session('error'))
                    <div style="margin-top:16px;padding:12px 16px;border-radius:14px;background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;font-size:12.5px;font-weight:700;">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                <div class="kb-amount-box">
                    <div class="kb-amount-label">Total Payable Amount</div>
                    <div class="kb-amount-val">AED {{ number_format((float) $paymentLink->amount, 2) }}</div>
                </div>

                <div class="kb-details-box">
                    <div class="kb-detail-row">
                        <span class="kb-detail-label">Payer Name</span>
                        <span class="kb-detail-val">{{ $paymentLink->name }}</span>
                    </div>
                    <div class="kb-detail-row">
                        <span class="kb-detail-label">Email Address</span>
                        <span class="kb-detail-val">{{ $paymentLink->email }}</span>
                    </div>
                    @if($paymentLink->phone)
                    <div class="kb-detail-row">
                        <span class="kb-detail-label">Phone Number</span>
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

                <form action="{{ route('payment_link.process', ['linkCode' => $paymentLink->link_code]) }}" method="POST">
                    @csrf
                    <button type="submit" class="kb-pay-submit">
                        <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        <span>Pay AED {{ number_format((float) $paymentLink->amount, 2) }} with uTap by e&</span>
                    </button>
                </form>

                <div class="kb-trust-bar">
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg style="width:14px;height:14px;color:#10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Instant Verification
                    </span>
                    <span>📧 Automatic Email Receipt</span>
                </div>
            @endif
        </div>
    </div>
</x-shop::layouts>
