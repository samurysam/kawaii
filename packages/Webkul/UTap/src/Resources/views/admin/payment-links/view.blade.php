<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Payment Link #{{ strtoupper($paymentLink->link_code) }} (uTap by e&)
    </x-slot>

    <!-- Header Section -->
    <div class="grid">
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.sales.payment_links.index') }}"
                    class="transparent-button px-2 py-1.5 hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                >
                    <span class="text-xl font-bold">←</span> Back
                </a>

                <div class="flex items-center gap-2.5">
                    <p class="text-xl font-bold leading-6 text-gray-800 dark:text-white">
                        Payment Link #{{ strtoupper($paymentLink->link_code) }}
                    </p>

                    <!-- Status Badge -->
                    @if($paymentLink->status === 'completed')
                        <span class="label-completed text-sm mx-1.5 font-bold">
                            ✓ Completed
                        </span>
                    @elseif($paymentLink->status === 'expired')
                        <span class="label-canceled text-sm mx-1.5 font-bold">
                            Expired
                        </span>
                    @else
                        <span class="label-pending text-sm mx-1.5 font-bold">
                            ⏳ Pending
                        </span>
                    @endif
                </div>
            </div>

            <!-- Page Action Buttons -->
            <div class="flex items-center gap-2 max-sm:flex-wrap">
                <!-- Open Public Checkout Page -->
                <a
                    href="{{ $url }}"
                    target="_blank"
                    class="secondary-button"
                >
                    ↗ Open Customer Page
                </a>

                <!-- Copy Shareable Link -->
                <button
                    type="button"
                    class="secondary-button"
                    onclick="navigator.clipboard.writeText('{{ $url }}'); this.innerText = 'Copied! 📋'; setTimeout(() => this.innerText = '📋 Copy Link', 2000);"
                >
                    📋 Copy Link
                </button>

                <!-- Resend Email Receipt (if paid) -->
                @if($paymentLink->isPaid())
                    <form action="{{ route('admin.sales.payment_links.resend_receipt', $paymentLink->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="secondary-button">
                            📧 Resend Receipt Email
                        </button>
                    </form>
                @endif

                <!-- Mark as Paid Manually (if pending) -->
                @if(!$paymentLink->isPaid())
                    <form action="{{ route('admin.sales.payment_links.mark_paid', $paymentLink->id) }}" method="POST" class="inline">
                        @csrf
                        <button
                            type="submit"
                            class="primary-button"
                            onclick="return confirm('Are you sure you want to mark this payment as Completed and send the customer an automated receipt email?');"
                        >
                            ✓ Mark as Completed
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Layout (Matching Orders View: 2 Columns) -->
    <div class="mt-5 flex gap-6 max-lg:flex-col">
        <!-- Left Component: Main Details (2/3 width) -->
        <div class="flex flex-1 flex-col gap-6">
            <!-- Amount & Key Stats Box -->
            <div class="box-shadow rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4 mb-4">
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">
                            Payable Amount
                        </span>
                        <div class="text-3xl font-extrabold text-pink-600">
                            AED {{ number_format((float) $paymentLink->amount, 2) }}
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">
                            Collection Method
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-pink-50 text-pink-700 border border-pink-200">
                            {{ $paymentLink->type === 'public_qr' ? '📱 Public Store QR' : '🔗 Admin Payment Request' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-xs max-sm:grid-cols-1">
                    <div>
                        <span class="text-gray-500 font-semibold block mb-0.5">Created Date</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $paymentLink->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 font-semibold block mb-0.5">Paid Date</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : 'Pending Customer Payment' }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 font-semibold block mb-0.5">Link Expiry</span>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $paymentLink->expires_at ? $paymentLink->expires_at->format('d M Y, h:i A') : '30 Days Validity' }}</span>
                    </div>
                </div>
            </div>

            <!-- Reason / Payment Description Box -->
            <div class="box-shadow rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800 space-y-3">
                <p class="text-base font-bold text-gray-800 dark:text-white">
                    Reason for Payment / Description
                </p>

                <div class="p-4 rounded-xl bg-pink-50/40 border border-pink-100 text-sm font-semibold text-gray-800 dark:text-gray-200">
                    {{ $paymentLink->reason }}
                </div>
            </div>

            <!-- uTap by e& Gateway Integration & Settlement Details -->
            <div class="box-shadow rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                    <p class="text-base font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <span>uTap by e& Gateway Details</span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-green-100 text-green-700">
                            Enterprise IPG
                        </span>
                    </p>

                    <span class="text-xs font-mono text-gray-400">
                        REF: #{{ strtoupper($paymentLink->link_code) }}
                    </span>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Payment Gateway</span>
                        <span class="font-bold text-gray-900 dark:text-white">uTap by e& (UAE)</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">uTap Invoice Reference</span>
                        <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $paymentLink->utap_invoice_id ?: 'Generated upon checkout' }}</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">uTap Transaction ID (TransID)</span>
                        <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $paymentLink->utap_txn_id ?: 'Pending Settlement' }}</span>
                    </div>

                    @if($paymentLink->utap_ipg_id)
                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">uTap IPG Session ID</span>
                        <span class="font-mono font-bold text-gray-900 dark:text-white">{{ $paymentLink->utap_ipg_id }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Gateway Settlement Status</span>
                        @if($paymentLink->isPaid())
                            <span class="font-bold text-green-600">✓ Settled & Verified</span>
                        @else
                            <span class="font-bold text-amber-500">⏳ Awaiting Payer Completion</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Shareable URL Box -->
            <div class="box-shadow rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800 space-y-3">
                <p class="text-base font-bold text-gray-800 dark:text-white">
                    Direct Payment Link URL
                </p>

                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        value="{{ $url }}"
                        readonly
                        class="w-full text-xs font-mono px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-800 dark:text-gray-200"
                    />

                    <button
                        type="button"
                        class="primary-button whitespace-nowrap"
                        onclick="navigator.clipboard.writeText('{{ $url }}'); this.innerText = 'Copied! 📋'; setTimeout(() => this.innerText = 'Copy Link', 2000);"
                    >
                        Copy Link
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Component: Customer & QR Code (1/3 width) -->
        <div class="flex w-[380px] max-w-full flex-col gap-6 max-lg:w-full">
            <!-- Customer / Payer Information Card -->
            <div class="box-shadow rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800 space-y-4">
                <p class="text-base font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">
                    Customer Details
                </p>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-gray-500 font-semibold block mb-0.5">Customer Name</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white block">{{ $paymentLink->name }}</span>
                    </div>

                    <div>
                        <span class="text-gray-500 font-semibold block mb-0.5">Email Address</span>
                        <a
                            href="mailto:{{ $paymentLink->email }}"
                            class="text-sm font-bold text-pink-600 hover:underline block"
                        >
                            {{ $paymentLink->email }}
                        </a>
                    </div>

                    @if($paymentLink->phone)
                    <div>
                        <span class="text-gray-500 font-semibold block mb-0.5">Phone Number</span>
                        <div class="flex items-center gap-2">
                            <a
                                href="tel:{{ $paymentLink->phone }}"
                                class="text-sm font-bold text-gray-900 dark:text-white hover:text-pink-600"
                            >
                                {{ $paymentLink->phone }}
                            </a>
                            <a
                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $paymentLink->phone) }}"
                                target="_blank"
                                class="text-xs px-2 py-0.5 rounded-full font-bold bg-green-100 text-green-700 hover:bg-green-200 transition"
                            >
                                WhatsApp 💬
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- In-Person QR Code Poster Card -->
            <div class="box-shadow rounded-2xl bg-white dark:bg-gray-900 p-6 border border-gray-100 dark:border-gray-800 space-y-4 text-center">
                <p class="text-base font-bold text-gray-800 dark:text-white">
                    In-Person Scannable QR Code
                </p>

                <div class="p-4 rounded-2xl bg-pink-50/50 border border-pink-200 inline-block shadow-inner">
                    <img
                        src="{{ $qrCodeUrl }}"
                        alt="QR Code"
                        class="w-48 h-48 mx-auto rounded-xl shadow bg-white p-2 border border-pink-100"
                    />
                </div>

                <p class="text-xs text-gray-500">
                    Scan with any smartphone camera to launch the instant checkout portal.
                </p>

                <div class="space-y-2">
                    <a
                        href="{{ $qrCodeUrl }}"
                        download="kawaii_payment_qr_{{ $paymentLink->link_code }}.png"
                        target="_blank"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-pink-600 bg-pink-50 border border-pink-200 hover:bg-pink-100 transition flex items-center justify-center gap-2"
                    >
                        ⬇️ Download QR PNG
                    </a>

                    <button
                        type="button"
                        onclick="window.print()"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-gray-700 bg-gray-50 border border-gray-200 hover:bg-gray-100 transition flex items-center justify-center gap-2"
                    >
                        🖨️ Print Counter Flyer
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>
