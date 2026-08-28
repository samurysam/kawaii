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
        font-size: 32px;
        font-weight: 800;
        color: #2b1f24;
        margin: 0 0 6px;
        font-family: 'Fredoka', sans-serif;
        letter-spacing: -0.02em;
    }
    .kb-pay-subtitle {
        font-size: 13.5px;
        color: #826671;
        margin: 0 0 24px;
        line-height: 1.5;
    }
    .kb-amount-chips {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 10px;
    }
    .kb-chip-btn {
        padding: 9px 0;
        font-size: 12.5px;
        font-weight: 800;
        border-radius: 12px;
        border: 1px solid #f5ccd9;
        background: #fffafc;
        color: #d85483;
        cursor: pointer;
        transition: all .18s ease;
    }
    .kb-chip-btn:hover, .kb-chip-btn:active {
        background: #ffe6ef;
        border-color: #ed5287;
        transform: translateY(-1px);
    }
    .kb-input-wrap {
        position: relative;
        margin-bottom: 16px;
    }
    .kb-input-prefix {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        font-weight: 800;
        color: #ed5287;
        pointer-events: none;
    }
    .kb-pay-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 14px;
        border: 1.5px solid #f2cbd7;
        background: #fffafc;
        font-size: 14px;
        font-weight: 600;
        color: #33282c;
        box-sizing: border-box;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .kb-pay-input.with-prefix {
        padding-left: 58px;
        font-size: 18px;
        font-weight: 800;
    }
    .kb-pay-input:focus {
        border-color: #ed5287;
        box-shadow: 0 0 0 4px rgba(237, 82, 135, 0.12);
        background: #fff;
    }
    .kb-pay-label {
        display: block;
        font-size: 11.5px;
        font-weight: 800;
        color: #614852;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
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
        Quick Pay — Kawaii Blessings
    </x-slot>

    <div class="kb-pay-wrap">
        <div class="kb-pay-card">
            <div style="text-align:center;">
                <span class="kb-pay-badge">
                    <span style="color:#d9a84f;">✦</span> Kawaii Blessings Quick Pay
                </span>
                <h1 class="kb-pay-title">Make a Payment 💖</h1>
                <p class="kb-pay-subtitle">
                    Enter the amount and details below to complete your payment securely with uTap by e&.
                </p>
            </div>

            @if(session('error'))
                <div style="margin-bottom:18px;padding:12px 16px;border-radius:14px;background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;font-size:12.5px;font-weight:700;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('payment_link.open_pay.submit') }}" method="POST">
                @csrf

                <!-- Amount in AED -->
                <div style="margin-bottom:18px;">
                    <label for="amount" class="kb-pay-label">
                        Amount to Pay (AED) <span style="color:#ed5287;">*</span>
                    </label>

                    <div class="kb-amount-chips">
                        @foreach([25, 50, 100, 250] as $preset)
                            <button
                                type="button"
                                class="kb-chip-btn"
                                onclick="document.getElementById('amount').value = '{{ $preset }}';"
                            >
                                AED {{ $preset }}
                            </button>
                        @endforeach
                    </div>

                    <div class="kb-input-wrap">
                        <span class="kb-input-prefix">AED</span>
                        <input
                            type="number"
                            step="0.01"
                            min="1"
                            max="50000"
                            id="amount"
                            name="amount"
                            value="{{ old('amount') }}"
                            placeholder="0.00"
                            required
                            class="kb-pay-input with-prefix"
                        >
                    </div>
                    @error('amount')
                        <p style="color:#dc2626;font-size:12px;font-weight:700;margin-top:-10px;margin-bottom:10px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Name -->
                <div style="margin-bottom:16px;">
                    <label for="name" class="kb-pay-label">
                        Your Full Name <span style="color:#ed5287;">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Samer Khan"
                        required
                        class="kb-pay-input"
                    >
                    @error('name')
                        <p style="color:#dc2626;font-size:12px;font-weight:700;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email ID -->
                <div style="margin-bottom:16px;">
                    <label for="email" class="kb-pay-label">
                        Email Address (for Receipt) <span style="color:#ed5287;">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        required
                        class="kb-pay-input"
                    >
                    @error('email')
                        <p style="color:#dc2626;font-size:12px;font-weight:700;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div style="margin-bottom:16px;">
                    <label for="phone" class="kb-pay-label">
                        Phone Number (UAE Mobile)
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="05X XXX XXXX"
                        class="kb-pay-input"
                    >
                    @error('phone')
                        <p style="color:#dc2626;font-size:12px;font-weight:700;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason for payment -->
                <div style="margin-bottom:22px;">
                    <label for="reason" class="kb-pay-label">
                        Purpose / Reason for Payment <span style="color:#ed5287;">*</span>
                    </label>
                    <textarea
                        id="reason"
                        name="reason"
                        rows="2"
                        placeholder="e.g. In-store purchase, Custom order, Express gift packaging..."
                        required
                        class="kb-pay-input"
                        style="resize:vertical;"
                    >{{ old('reason') }}</textarea>
                    @error('reason')
                        <p style="color:#dc2626;font-size:12px;font-weight:700;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="kb-pay-submit">
                    <svg style="width:20px;height:20px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    <span>Proceed to Pay with uTap by e&</span>
                </button>

                <!-- Trust Bar -->
                <div class="kb-trust-bar">
                    <span style="display:flex;align-items:center;gap:4px;">
                        <svg style="width:14px;height:14px;color:#10b981;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        100% Secure Gateway
                    </span>
                    <span style="display:flex;align-items:center;gap:4px;">
                        <span style="color:#d9a84f;">✦</span> UAE Licensed Store
                    </span>
                    <span>💳 Powered by e&</span>
                </div>
            </form>
        </div>
    </div>
</x-shop::layouts>
