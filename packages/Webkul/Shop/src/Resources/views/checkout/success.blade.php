<x-shop::layouts
    :has-header="true"
    :has-feature="false"
    :has-footer="true"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.success.thanks')
    </x-slot>

    <!-- Ambient Container -->
    <div class="kb-co-shell !py-12 !min-h-[85vh]">
        <div class="container px-4 sm:px-8 mx-auto">
            <!-- Central Luxury Card -->
            <div class="kb-succ-card">
                <!-- Corner Accents -->
                <div class="absolute top-6 left-6 text-xl text-[#f58fb0] select-none" aria-hidden="true">🌸</div>
                <div class="absolute top-6 right-6 text-xl text-[#d8b46b] select-none" aria-hidden="true">✨</div>

                <!-- Hero Badge -->
                <div class="kb-succ-hero-badge">
                    <span class="sparkle">✨</span>
                    <span>🎁</span>
                </div>

                <!-- Kicker & Title -->
                <p class="kb-succ-kicker">
                    ORDER CONFIRMED
                </p>

                <h1 class="kb-succ-title">
                    Your kawaii goodies are officially on the way <span class="text-[#d95882] font-normal">♡</span>
                </h1>

                <p class="kb-succ-sub">
                    Thank you, {{ $order->customer_first_name }}! We've received your order and our little packing team is getting everything ready with extra care, sparkles and love.
                </p>

                <!-- Order ID Pill -->
                <div class="kb-succ-order-pill">
                    <span>Order</span>
                    <span class="order-id">#{{ $order->increment_id }}</span>
                    <span>·</span>
                    <span>Confirmation sent to {{ $order->customer_email }}</span>
                </div>

                <!-- 4-Step Order Tracker Timeline -->
                <div class="kb-succ-timeline">
                    <!-- Step 1: Placed -->
                    <div class="kb-succ-tl-item completed">
                        <div class="kb-succ-tl-circle">✓</div>
                        <p class="kb-succ-tl-title">Order placed</p>
                        <p class="kb-succ-tl-sub">Today, {{ $order->created_at->format('g:i A') }}</p>
                    </div>

                    <!-- Step 2: Preparing -->
                    <div class="kb-succ-tl-item active">
                        <div class="kb-succ-tl-circle">2</div>
                        <p class="kb-succ-tl-title">Preparing</p>
                        <p class="kb-succ-tl-sub">Next up</p>
                    </div>

                    <!-- Step 3: On the way -->
                    <div class="kb-succ-tl-item upcoming">
                        <div class="kb-succ-tl-circle">3</div>
                        <p class="kb-succ-tl-title">On the way</p>
                        <p class="kb-succ-tl-sub">Tracking soon</p>
                    </div>

                    <!-- Step 4: Delivered -->
                    <div class="kb-succ-tl-item upcoming">
                        <div class="kb-succ-tl-circle">4</div>
                        <p class="kb-succ-tl-title">Delivered</p>
                        <p class="kb-succ-tl-sub">Happy unboxing</p>
                    </div>
                </div>

                <!-- 2-Column Split Details -->
                <div class="kb-succ-grid">
                    <!-- Left: What you ordered -->
                    <div class="kb-succ-box">
                        <h2 class="kb-succ-box-title">What you ordered</h2>

                        <div class="flex flex-col gap-3">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between gap-3 pb-3 border-b border-[#fae8ef] last:border-b-0 last:pb-0">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-11 h-11 rounded-xl bg-[#fff4f7] border border-[#f9cad8] flex items-center justify-center text-xl shrink-0 overflow-hidden">
                                            @if ($item->product && $item->product->base_image_url)
                                                <img
                                                    src="{{ $item->product->base_image_url }}"
                                                    alt="{{ $item->name }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @else
                                                <span>🌸</span>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-[#3f2a2e] truncate" title="{{ $item->name }}">
                                                {{ $item->name }}
                                            </p>
                                            <p class="text-[11px] font-semibold text-[#9b898d]">
                                                Qty {{ $item->qty_ordered }}
                                                @if (! empty($item->additional['attributes']))
                                                    · @foreach ($item->additional['attributes'] as $attr)
                                                        {{ $attr['option_label'] ?? '' }}
                                                    @endforeach
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <span class="text-xs font-extrabold text-[#3f2a2e] whitespace-nowrap">
                                        {{ core()->formatPrice($item->total, $order->order_currency_code) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right: Order summary -->
                    <div class="kb-succ-box">
                        <h2 class="kb-succ-box-title">Order summary</h2>

                        <div class="flex flex-col gap-2 text-xs font-semibold text-[#756166]">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-bold text-[#3f2a2e]">{{ core()->formatPrice($order->sub_total, $order->order_currency_code) }}</span>
                            </div>

                            @if ($order->discount_amount > 0)
                                <div class="flex justify-between text-[#ef759d] font-bold">
                                    <span>Welcome discount</span>
                                    <span>- {{ core()->formatPrice($order->discount_amount, $order->order_currency_code) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span>Delivery</span>
                                @if ($order->shipping_amount == 0)
                                    <span class="font-bold text-[#22583e]">FREE</span>
                                @else
                                    <span class="font-bold text-[#3f2a2e]">+ {{ core()->formatPrice($order->shipping_amount, $order->order_currency_code) }}</span>
                                @endif
                            </div>

                            @if ($order->tax_amount > 0)
                                <div class="flex justify-between">
                                    <span>VAT</span>
                                    <span class="font-bold text-[#3f2a2e]">+ {{ core()->formatPrice($order->tax_amount, $order->order_currency_code) }}</span>
                                </div>
                            @endif

                            <div class="my-2 h-[1px] bg-[#fae8ef]"></div>

                            <div class="flex justify-between items-baseline">
                                <span class="text-sm font-bold text-[#3f2a2e]">Total paid</span>
                                <span class="text-lg font-extrabold text-[#3f2a2e]">{{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}</span>
                            </div>

                            <!-- Delivery to Address Summary -->
                            @if ($order->shipping_address)
                                <div class="mt-3 pt-3 border-t border-[#fae8ef]">
                                    <p class="text-[11px] font-bold text-[#3f2a2e] uppercase tracking-wider mb-1">
                                        Delivering to
                                    </p>
                                    <p class="text-[11px] leading-relaxed text-[#756166]">
                                        {{ $order->shipping_address->first_name }} {{ $order->shipping_address->last_name }} · 
                                        {{ $order->shipping_address->city }}, {{ $order->shipping_address->country }}
                                    </p>
                                    <p class="text-[11px] font-bold text-[#22583e] mt-1">
                                        Estimated arrival: 1–3 business days
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="kb-succ-btn-row">
                    @if (auth()->guard('customer')->user())
                        <a
                            href="{{ route('shop.customers.account.orders.view', $order->id) }}"
                            class="kb-succ-btn-secondary"
                        >
                            View Order
                        </a>
                    @endif

                    <a
                        href="{{ route('shop.home.index') }}"
                        class="kb-succ-btn-primary"
                    >
                        Continue Shopping ✨
                    </a>
                </div>

                <!-- Trust Guarantee Line -->
                <div class="kb-succ-trust-line">
                    <span class="text-[#ef759d]">🌸</span>
                    <span class="text-[#d95882] font-bold">100% Authentic Products Guaranteed</span>
                    <span>·</span>
                    <span>secure payment</span>
                    <span>·</span>
                    <span>packed with care</span>
                    <span>·</span>
                    <span>easy returns</span>
                    <span class="text-[#ef759d]">🌸</span>
                </div>
            </div>

            <!-- Bottom Sweet Appreciation Note -->
            <p class="text-center text-xs font-semibold text-[#9b898d] mt-6">
                Thank you for being part of Kawaii Blessings. You make our world sweeter! ♡
            </p>
        </div>
    </div>
</x-shop::layouts>
