<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Payment Link #{{ strtoupper($paymentLink->link_code) }} (uTap by e&)
    </x-slot>

    <!-- Header Actions -->
    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap mb-6">
        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.sales.payment_links.index') }}"
                class="p-2 rounded-xl border border-gray-200 dark:border-gray-800 text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800 transition"
            >
                ← Back
            </a>

            <div>
                <p class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <span>Payment Link #{{ strtoupper($paymentLink->link_code) }}</span>
                    @if($paymentLink->status === 'completed')
                        <span class="badge badge-sm badge-success">✓ Completed</span>
                    @elseif($paymentLink->status === 'expired')
                        <span class="badge badge-sm badge-danger">Expired</span>
                    @else
                        <span class="badge badge-sm badge-warning">⏳ Pending</span>
                    @endif
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Created on {{ $paymentLink->created_at->format('d M Y, h:i A') }} • Powered by uTap by e&
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('payment_link.checkout', ['linkCode' => $paymentLink->link_code]) }}"
                target="_blank"
                class="secondary-button"
            >
                ↗ Open Payment Page
            </a>

            <button
                type="button"
                class="primary-button"
                onclick="navigator.clipboard.writeText('{{ route('payment_link.checkout', ['linkCode' => $paymentLink->link_code]) }}'); alert('Payment link copied to clipboard! 📋');"
            >
                📋 Copy Shareable Link
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-3 gap-6 max-lg:grid-cols-1">
        <!-- Left: Payment & Payer Details (2 Cols) -->
        <div class="col-span-2 space-y-6">
            <!-- Payment Amount Highlight -->
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">
                        Total Amount
                    </span>
                    <div class="text-3xl font-extrabold text-pink-600">
                        AED {{ number_format((float) $paymentLink->amount, 2) }}
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">
                        Payment Type
                    </span>
                    <span class="font-bold text-sm text-gray-800 dark:text-gray-200">
                        {{ $paymentLink->type === 'public_qr' ? '📱 Public QR Link' : '🔗 Admin Generated' }}
                    </span>
                </div>
            </div>

            <!-- Customer & Transaction Breakdown Card -->
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">
                    Customer & Transaction Details
                </h3>

                <div class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Customer Name</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ $paymentLink->name }}</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Customer Email</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ $paymentLink->email }}</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Phone Number</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ $paymentLink->phone ?: 'N/A' }}</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Payment Gateway</span>
                        <span class="text-gray-900 dark:text-white font-bold">uTap by e&</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">uTap Transaction ID</span>
                        <span class="text-gray-900 dark:text-white font-mono font-bold">{{ $paymentLink->utap_txn_id ?: 'Pending Settlement' }}</span>
                    </div>

                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Paid Timestamp</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : 'Pending' }}</span>
                    </div>

                    @if($paymentLink->expires_at)
                    <div class="flex justify-between py-2.5">
                        <span class="text-gray-500 font-semibold">Expires At</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ $paymentLink->expires_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>

                <div class="pt-3">
                    <span class="text-xs text-gray-500 font-semibold block mb-1">Reason for Payment:</span>
                    <div class="p-3.5 rounded-xl bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700">
                        {{ $paymentLink->reason }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Scannable QR Code & Sharing Card (1 Col) -->
        <div class="space-y-6">
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm text-center">
                <h3 class="text-base font-bold text-gray-800 dark:text-white mb-4">
                    QR Code for In-Person Payment
                </h3>

                @php
                    $url = route('payment_link.checkout', ['linkCode' => $paymentLink->link_code]);
                    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($url);
                @endphp

                <div class="p-3 rounded-2xl bg-pink-50/50 border border-pink-200 inline-block mb-4">
                    <img
                        src="{{ $qrCodeUrl }}"
                        alt="QR Code"
                        class="w-48 h-48 rounded-xl shadow-sm bg-white p-2 border border-pink-100"
                    />
                </div>

                <p class="text-xs text-gray-500 mb-4">
                    Scan with any smartphone camera to open the instant payment page.
                </p>

                <div class="space-y-2">
                    <a
                        href="{{ $qrCodeUrl }}"
                        download="kawaii_payment_qr_{{ $paymentLink->link_code }}.png"
                        target="_blank"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-pink-600 bg-pink-50 border border-pink-200 hover:bg-pink-100 transition flex items-center justify-center gap-2"
                    >
                        ⬇️ Download QR Image
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>
