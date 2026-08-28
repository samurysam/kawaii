<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
    <meta name="keywords" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.onepage.index.checkout')
    </x-slot>

    <div class="kb-co-shell">
        {!! view_render_event('bagisto.shop.checkout.onepage.header.before') !!}

        <!-- Premium Checkout Header -->
        <header class="kb-co-header">
            <div class="kb-co-header-inner">
                <div class="flex items-center gap-6">
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="flex items-center"
                        aria-label="Kawaii Blessings"
                    >
                        <img
                            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                            alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                            width="140"
                            height="34"
                            class="h-9 w-auto object-contain"
                        >
                    </a>
                </div>

                <div class="flex items-center gap-5">
                    <span class="kb-co-secure-badge max-sm:hidden">
                        <span>🔒</span>
                        <span>Safe &amp; Encrypted Checkout</span>
                    </span>

                    <a
                        href="{{ route('shop.home.index') }}"
                        class="kb-co-back-link"
                    >
                        <span>&larr;</span>
                        <span>Back to Store</span>
                    </a>

                    @guest('customer')
                        @include('shop::checkout.login')
                    @endguest
                </div>
            </div>
        </header>

        {!! view_render_event('bagisto.shop.checkout.onepage.header.after') !!}

        <!-- Main Container -->
        <main class="kb-co-container">
            {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.before') !!}

            <!-- Breadcrumbs -->
            <div class="kb-co-breadcrumbs">
                <a href="{{ route('shop.home.index') }}">Home</a>
                <span class="sep">&gt;</span>
                <a href="{{ route('shop.checkout.cart.index') }}">Shopping Bag</a>
                <span class="sep">&gt;</span>
                <span class="current">Checkout</span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.after') !!}

            <!-- Hero Title -->
            <div class="kb-co-hero max-md:flex-col max-md:items-start">
                <div>
                    <h1 class="kb-co-hero-title">
                        Almost yours, sweetie <span class="heart">♡</span>
                    </h1>
                    <p class="kb-co-hero-sub">
                        Just a few little details and your kawaii goodies will be on their way.
                    </p>
                </div>

                <div class="kb-co-free-shipping-tag">
                    <span>✨</span>
                    <span>Free UAE shipping on orders AED 299+</span>
                </div>
            </div>

            <!-- Checkout Vue Component -->
            <v-checkout>
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </v-checkout>
        </main>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-checkout-template"
        >
            <template v-if="! cart">
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </template>

            <template v-else>
                <!-- Progress Stepper -->
                <div class="kb-co-stepper">
                    <!-- Step 1: Address -->
                    <div
                        class="kb-co-step-item"
                        :class="getStepClass('address')"
                    >
                        <div class="kb-co-step-circle">
                            <span v-if="isStepCompleted('address')">✓</span>
                            <span v-else>1</span>
                        </div>
                        <span class="kb-co-step-name">Address</span>
                    </div>

                    <!-- Step 2: Delivery -->
                    <div
                        class="kb-co-step-item"
                        :class="getStepClass('shipping')"
                    >
                        <div class="kb-co-step-circle">
                            <span v-if="isStepCompleted('shipping')">✓</span>
                            <span v-else>2</span>
                        </div>
                        <span class="kb-co-step-name">Delivery</span>
                    </div>

                    <!-- Step 3: Payment -->
                    <div
                        class="kb-co-step-item"
                        :class="getStepClass('payment')"
                    >
                        <div class="kb-co-step-circle">
                            <span v-if="isStepCompleted('payment')">✓</span>
                            <span v-else>3</span>
                        </div>
                        <span class="kb-co-step-name">Payment</span>
                    </div>

                    <!-- Step 4: Review -->
                    <div
                        class="kb-co-step-item"
                        :class="getStepClass('review')"
                    >
                        <div class="kb-co-step-circle">
                            <span v-if="isStepCompleted('review')">✓</span>
                            <span v-else>4</span>
                        </div>
                        <span class="kb-co-step-name">Review</span>
                    </div>
                </div>

                <!-- Main 2-Column Grid -->
                <div class="kb-co-layout">
                    <!-- Mobile Summary Card (collapsible/visible above on mobile) -->
                    <div class="hidden max-lg:block">
                        @include('shop::checkout.onepage.summary')
                    </div>

                    <!-- Left: Checkout Steps Container -->
                    <div
                        class="overflow-y-auto"
                        id="steps-container"
                    >
                        <!-- Included Addresses Blade File -->
                        <template v-if="['address', 'shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.address')
                        </template>

                        <!-- Included Shipping Methods Blade File -->
                        <template v-if="cart.have_stockable_items && ['shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.shipping')
                        </template>

                        <!-- Included Payment Methods Blade File -->
                        <template v-if="['payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.payment')
                        </template>

                        <!-- Bottom Sweet Appreciation Note -->
                        <div class="kb-co-bottom-note">
                            <span>🎀</span>
                            <span>A little happiness is almost on its way to you.</span>
                            <span>✨</span>
                        </div>
                    </div>

                    <!-- Right: Desktop Sticky Order Summary Card -->
                    <div class="sticky top-6 block max-lg:hidden">
                        @include('shop::checkout.onepage.summary')
                    </div>
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: null,

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",
                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",
                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isPlacingOrder: false,
                        currentStep: 'address',
                        shippingMethods: null,
                        paymentMethods: null,
                        selectedPaymentMethod: null,
                        canPlaceOrder: false,
                    }
                },

                mounted() {
                    this.getCart();
                },

                methods: {
                    getCart() {
                        this.$axios.get("{{ route('shop.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;
                                this.scrollToCurrentStep();
                            })
                            .catch(error => {});
                    },

                    stepForward(step) {
                        this.currentStep = step;

                        if (step == 'review') {
                            this.canPlaceOrder = true;
                            return;
                        }

                        this.canPlaceOrder = false;

                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = null;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = null;
                        }
                    },

                    stepProcessed(data) {
                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = data;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = data;
                        }

                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        let container = document.getElementById('steps-container');

                        if (! container) {
                            return;
                        }

                        container.scrollIntoView({
                            behavior: 'smooth',
                            block: 'end'
                        });
                    },

                    setSelectedPaymentMethod(method) {
                        this.selectedPaymentMethod = method;
                    },

                    getStepClass(step) {
                        const stepOrder = ['address', 'shipping', 'payment', 'review'];
                        const currentIndex = stepOrder.indexOf(this.currentStep);
                        const targetIndex = stepOrder.indexOf(step);

                        if (targetIndex < currentIndex) {
                            return 'completed';
                        } else if (targetIndex === currentIndex) {
                            return 'active';
                        } else {
                            return 'upcoming';
                        }
                    },

                    isStepCompleted(step) {
                        const stepOrder = ['address', 'shipping', 'payment', 'review'];
                        const currentIndex = stepOrder.indexOf(this.currentStep);
                        const targetIndex = stepOrder.indexOf(step);

                        return targetIndex < currentIndex;
                    },

                    placeOrder() {
                        if ((this.selectedPaymentMethod || this.cart.payment_method) == 'paypal_smart_button') {
                            return;
                        }

                        this.isPlacingOrder = true;

                        this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}')
                            .then(response => {
                                if (response.data.data.redirect) {
                                    window.location.href = response.data.data.redirect_url;
                                } else {
                                    window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                                }

                                this.isPlacingOrder = false;
                            })
                            .catch(error => {
                                this.isPlacingOrder = false;
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
