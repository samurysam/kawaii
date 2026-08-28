<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.cart.index.cart')"/>

    <meta name="keywords" content="@lang('shop::app.checkout.cart.index.cart')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.cart.index.cart')
    </x-slot>

    <div class="kb-co-shell">
        {!! view_render_event('bagisto.shop.checkout.cart.header.before') !!}

        <!-- Luxury Header -->
        <header class="kb-co-header">
            <div class="kb-co-header-inner">
                <div class="flex items-center gap-4">
                    {!! view_render_event('bagisto.shop.checkout.cart.logo.before') !!}

                    <a
                        href="{{ route('shop.home.index') }}"
                        class="flex min-h-[30px]"
                        aria-label="@lang('shop::app.checkout.cart.index.bagisto')"
                    >
                        <img
                            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                            alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                            width="140"
                            height="34"
                            class="h-auto max-h-[38px] w-auto object-contain"
                        >
                    </a>

                    {!! view_render_event('bagisto.shop.checkout.cart.logo.after') !!}
                </div>

                <div class="flex items-center gap-3">
                    <div class="kb-co-secure-badge max-sm:hidden">
                        <span>🔒</span>
                        <span>Safe & Encrypted Bag</span>
                    </div>

                    <a
                        href="{{ route('shop.home.index') }}"
                        class="kb-co-back-link text-xs sm:text-sm"
                    >
                        <span>←</span>
                        <span>Back to Store</span>
                    </a>
                </div>
            </div>
        </header>

        {!! view_render_event('bagisto.shop.checkout.cart.header.after') !!}

        <!-- Main Cart Container -->
        <main class="kb-co-container">
            {!! view_render_event('bagisto.shop.checkout.cart.breadcrumbs.before') !!}

            <!-- Breadcrumbs -->
            <nav class="kb-co-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('shop.home.index') }}">Home</a>
                <span class="sep">›</span>
                <span class="current">Shopping Bag</span>
            </nav>

            {!! view_render_event('bagisto.shop.checkout.cart.breadcrumbs.after') !!}

            <!-- Hero Section -->
            <div class="kb-co-hero">
                <div>
                    <h1 class="kb-co-hero-title">
                        Your Shopping Bag <span class="heart">♡</span>
                    </h1>
                    <p class="kb-co-hero-sub">
                        Review your chosen kawaii treasures before taking them home.
                    </p>
                </div>

                <div class="kb-co-hero-badge max-md:mt-2">
                    <span class="sparkle">✨</span>
                    <span>Free UAE shipping on orders AED 299+</span>
                </div>
            </div>

            @php
                $errors = \Webkul\Checkout\Facades\Cart::getErrors();
            @endphp

            @if (! empty($errors) && $errors['error_code'] === 'MINIMUM_ORDER_AMOUNT')
                <div class="mb-6 rounded-[20px] border border-[#f3cfdb] bg-[#fff0f5] px-5 py-3 text-sm font-semibold text-[#8c3b58]">
                    ⚠️ {{ $errors['message'] }}: {{ $errors['amount'] }}
                </div>
            @endif

            <v-cart ref="vCart">
                <!-- Cart Shimmer Effect -->
                <x-shop::shimmer.checkout.cart :count="3" />
            </v-cart>
        </main>
    </div>

    @if (core()->getConfigData('sales.checkout.shopping_cart.cross_sell'))
        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.before') !!}

        <!-- Cross-sell Product Carousal -->
        <div class="container px-[60px] pb-12 max-lg:px-8 max-md:px-4">
            <x-shop::products.carousel
                :title="trans('shop::app.checkout.cart.index.cross-sell.title')"
                :src="route('shop.api.checkout.cart.cross-sell.index')"
            />
        </div>

        {!! view_render_event('bagisto.shop.checkout.cart.cross_sell_carousel.after') !!}
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-cart-template"
        >
            <div>
                <!-- Cart Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::shimmer.checkout.cart :count="3" />
                </template>

                <!-- Cart Information -->
                <template v-else>
                    <div
                        class="grid grid-cols-1 items-start gap-8 pb-12 lg:grid-cols-[1fr_420px]"
                        v-if="cart?.items?.length"
                    >
                        <!-- Left Column: Item List & Controls -->
                        <div class="flex flex-col gap-6">

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.before') !!}

                            <!-- Mass Action Bar -->
                            <div class="kb-cart-mass-card flex items-center justify-between">
                                <div class="flex select-none items-center gap-3">
                                    <input
                                        type="checkbox"
                                        id="select-all"
                                        class="kb-cart-checkbox peer hidden"
                                        v-model="allSelected"
                                        @change="selectAll"
                                    >

                                    <label
                                        class="kb-cart-checkbox-label"
                                        for="select-all"
                                        tabindex="0"
                                        aria-label="@lang('shop::app.checkout.cart.index.select-all')"
                                    ></label>

                                    <span class="text-sm font-bold text-[#3f2a2e] sm:text-base">
                                        @{{ "@lang('shop::app.checkout.cart.index.items-selected')".replace(':count', selectedItemsCount) }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3" v-if="selectedItemsCount">
                                    <button
                                        type="button"
                                        class="text-xs font-bold text-[#d95882] hover:text-[#b03d63] transition-all sm:text-sm"
                                        @click="removeSelectedItems"
                                    >
                                        🗑️ @lang('shop::app.checkout.cart.index.remove')
                                    </button>

                                    @if (auth()->guard('customer')->check())
                                        <span class="h-3 w-[1px] bg-[#f0dfe2]"></span>

                                        <button
                                            type="button"
                                            class="text-xs font-bold text-[#756166] hover:text-[#d95882] transition-all sm:text-sm"
                                            @click="moveToWishlistSelectedItems"
                                        >
                                            🤍 @lang('shop::app.checkout.cart.index.move-to-wishlist')
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.cart_mass_actions.after') !!}

                            {!! view_render_event('bagisto.shop.checkout.cart.item.listing.before') !!}

                            <!-- Cart Item Cards -->
                            <div class="flex flex-col gap-4">
                                <div
                                    class="kb-cart-item-card flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                                    v-for="item in cart?.items"
                                    :key="item.id"
                                >
                                    <div class="flex items-start gap-3 sm:items-center sm:gap-4">
                                        <!-- Item Select Checkbox -->
                                        <div class="mt-1 sm:mt-0">
                                            <input
                                                type="checkbox"
                                                :id="'item_' + item.id"
                                                class="kb-cart-checkbox peer hidden"
                                                v-model="item.selected"
                                                @change="updateAllSelected"
                                            >

                                            <label
                                                class="kb-cart-checkbox-label"
                                                :for="'item_' + item.id"
                                                tabindex="0"
                                                aria-label="@lang('shop::app.checkout.cart.index.select-cart-item')"
                                            ></label>
                                        </div>

                                        {!! view_render_event('bagisto.shop.checkout.cart.item_image.before') !!}

                                        <!-- Product Thumbnail -->
                                        <a
                                            :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)"
                                            class="shrink-0 overflow-hidden rounded-[16px] border border-[#f3cfdb] bg-[#fffdfc]"
                                        >
                                            <x-shop::media.images.lazy
                                                class="h-[84px] w-[84px] object-cover sm:h-[96px] sm:w-[96px]"
                                                ::src="item.base_image.small_image_url"
                                                ::alt="item.base_image.alt"
                                                width="96"
                                                height="96"
                                                ::key="item.id"
                                                ::index="item.id"
                                            />
                                        </a>

                                        {!! view_render_event('bagisto.shop.checkout.cart.item_image.after') !!}

                                        <!-- Product Info -->
                                        <div class="flex flex-col gap-1.5">
                                            {!! view_render_event('bagisto.shop.checkout.cart.item_name.before') !!}

                                            <a :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', item.product_url_key)">
                                                <h3 class="text-sm font-bold text-[#3f2a2e] hover:text-[#d95882] transition-colors sm:text-base">
                                                    @{{ item.name }}
                                                </h3>
                                            </a>

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_name.after') !!}

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_details.before') !!}

                                            <!-- Attributes / Options -->
                                            <div
                                                class="flex flex-wrap gap-1.5 text-xs text-[#756166]"
                                                v-if="item.options?.length"
                                            >
                                                <span
                                                    v-for="attribute in item.options"
                                                    class="inline-flex items-center gap-1 rounded-full bg-[#fff0f5] px-2.5 py-0.5 font-medium text-[#9c4d6a]"
                                                >
                                                    <span>@{{ attribute.attribute_name }}:</span>
                                                    <span class="font-bold">@{{ attribute.option_label || attribute.file_name }}</span>
                                                </span>
                                            </div>

                                            {!! view_render_event('bagisto.shop.checkout.cart.item_details.after') !!}

                                            <!-- Mobile Price & Remove Row -->
                                            <div class="flex items-center justify-between pt-1 sm:hidden">
                                                <span class="font-serif text-base font-bold text-[#3f2a2e]">
                                                    @{{ item.formatted_total }}
                                                </span>

                                                <button
                                                    type="button"
                                                    class="text-xs font-bold text-[#d95882] hover:text-[#b03d63]"
                                                    @click="removeItem(item.id)"
                                                >
                                                    @lang('shop::app.checkout.cart.index.remove')
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Desktop Right Controls: Quantity & Price -->
                                    <div class="flex items-center justify-between gap-6 sm:justify-end">
                                        {!! view_render_event('bagisto.shop.checkout.cart.quantity_changer.before') !!}

                                        <!-- Quantity Changer -->
                                        <x-shop::quantity-changer
                                            v-if="item.can_change_qty"
                                            ::key="'qty-' + item.id + '-' + refreshKey"
                                            class="flex max-w-max items-center gap-x-2.5 rounded-full border border-[#f3cfdb] bg-[#fff8fa] px-3.5 py-1 text-sm font-bold text-[#3f2a2e]"
                                            name="quantity"
                                            ::value="item?.quantity"
                                            :removable="true"
                                            @change="setItemQuantity(item.id, $event)"
                                            @remove="removeItem(item.id)"
                                        />

                                        {!! view_render_event('bagisto.shop.checkout.cart.quantity_changer.after') !!}

                                        <div class="text-right max-sm:hidden">
                                            {!! view_render_event('bagisto.shop.checkout.cart.total.before') !!}

                                            <p class="font-serif text-lg font-bold text-[#3f2a2e]">
                                                @{{ item.formatted_total }}
                                            </p>

                                            {!! view_render_event('bagisto.shop.checkout.cart.total.after') !!}

                                            {!! view_render_event('bagisto.shop.checkout.cart.remove_button.before') !!}

                                            <button
                                                type="button"
                                                class="mt-1 text-xs font-bold text-[#d95882] hover:text-[#b03d63] transition-colors"
                                                @click="removeItem(item.id)"
                                            >
                                                @lang('shop::app.checkout.cart.index.remove')
                                            </button>

                                            {!! view_render_event('bagisto.shop.checkout.cart.remove_button.after') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.item.listing.after') !!}

                            {!! view_render_event('bagisto.shop.checkout.cart.controls.before') !!}

                            <!-- Cart Actions Bar -->
                            <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
                                {!! view_render_event('bagisto.shop.checkout.cart.continue_shopping.before') !!}

                                <a
                                    class="kb-cart-btn-continue"
                                    href="{{ route('shop.home.index') }}"
                                >
                                    <span>←</span>
                                    <span>@lang('shop::app.checkout.cart.index.continue-shopping')</span>
                                </a>

                                {!! view_render_event('bagisto.shop.checkout.cart.continue_shopping.after') !!}

                                {!! view_render_event('bagisto.shop.checkout.cart.update_cart.before') !!}

                                <button
                                    type="button"
                                    class="kb-cart-btn-update"
                                    :disabled="isStoring"
                                    @click="update()"
                                >
                                    <span>🔄</span>
                                    <span>@lang('shop::app.checkout.cart.index.update-cart')</span>
                                </button>

                                {!! view_render_event('bagisto.shop.checkout.cart.update_cart.after') !!}
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.cart.controls.after') !!}
                        </div>

                        <!-- Right Column: Sticky Summary -->
                        {!! view_render_event('bagisto.shop.checkout.cart.summary.before') !!}

                        @include('shop::checkout.cart.summary')

                        {!! view_render_event('bagisto.shop.checkout.cart.summary.after') !!}
                    </div>

                    <!-- Empty Cart View -->
                    <div
                        class="kb-succ-card my-12 text-center"
                        v-else
                    >
                        <span class="kb-succ-accent-flower">🌸</span>
                        <span class="kb-succ-accent-sparkle">✨</span>

                        <div class="kb-succ-badge-wrap">
                            <div class="kb-succ-badge">
                                🛍️
                            </div>
                        </div>

                        <p class="kb-succ-kicker">YOUR BAG IS EMPTY</p>

                        <h2 class="kb-succ-title">
                            Your kawaii bag is waiting for treasures <span class="heart">♡</span>
                        </h2>

                        <p class="kb-succ-sub">
                            Looks like you haven't added any lovely items yet. Let's find something magical for you!
                        </p>

                        <div class="mt-8 flex justify-center">
                            <a
                                href="{{ route('shop.home.index') }}"
                                class="kb-succ-btn-primary"
                            >
                                Start Shopping ✨
                            </a>
                        </div>

                        <div class="kb-succ-trust-line mt-8">
                            <span>🌸 100% Authentic Products Guaranteed · secure checkout · packed with care 🌸</span>
                        </div>
                    </div>
                </template>
            </div>
        </script>

        <script type="module">
            app.component("v-cart", {
                template: '#v-cart-template',

                data() {
                    return  {
                        refreshKey: 0,

                        cart: [],

                        allSelected: false,

                        applied: {
                            quantity: {},
                        },

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",

                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",

                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isLoading: true,

                        isStoring: false,
                    };
                },

                mounted() {
                    this.getCart();
                },

                computed: {
                    selectedItemsCount() {
                        return this.cart?.items ? this.cart.items.filter(item => item.selected).length : 0;
                    },
                },

                methods: {
                    getCart() {
                        this.$axios.get('{{ route('shop.api.checkout.cart.index') }}')
                            .then(response => {
                                this.cart = response.data.data;

                                this.isLoading = false;

                                if (response.data.message) {
                                    this.$emitter.emit('add-flash', { type: 'info', message: response.data.message });
                                }
                            })
                            .catch(error => {
                                this.isLoading = false;
                            });
                    },

                    setCart(cart) {
                        this.cart = cart;
                    },

                    selectAll() {
                        if (! this.cart?.items) return;
                        for (let item of this.cart.items) {
                            item.selected = this.allSelected;
                        }
                    },

                    updateAllSelected() {
                        if (! this.cart?.items) return;
                        this.allSelected = this.cart.items.every(item => item.selected);
                    },

                    update() {
                        this.isStoring = true;

                        this.$axios.put('{{ route('shop.api.checkout.cart.update') }}', { qty: this.applied.quantity })
                            .then(response => {
                                if (response.data.data?.items !== undefined) {
                                    this.cart = response.data.data;

                                    this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                } else {
                                    this.$emitter.emit('add-flash', {
                                        type: 'warning',
                                        message: response.data.data?.message || response.data.message,
                                    });
                                }

                                this.isStoring = false;
                                this.applied.quantity = {};
                                this.refreshKey++;
                            })
                            .catch(error => {
                                this.isStoring = false;
                                this.applied.quantity = {};
                                this.refreshKey++;
                            });
                    },

                    setItemQuantity(itemId, quantity) {
                        this.applied.quantity[itemId] = quantity;
                    },

                    removeItem(itemId) {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy') }}', {
                                        '_method': 'DELETE',
                                        'cart_item_id': itemId,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    removeSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items.flatMap(item => item.selected ? item.id : []);

                                this.$axios.post('{{ route('shop.api.checkout.cart.destroy_selected') }}', {
                                        '_method': 'DELETE',
                                        'ids': selectedItemsIds,
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                    })
                                    .catch(error => {});
                            }
                        });
                    },

                    moveToWishlistSelectedItems() {
                        this.$emitter.emit('open-confirm-modal', {
                            agree: () => {
                                const selectedItemsIds = this.cart.items.flatMap(item => item.selected ? item.id : []);

                                const selectedItemsQty = this.cart.items.filter(item => item.selected).map(item => this.applied.quantity[item.id] ?? item.quantity);

                                this.$axios.post('{{ route('shop.api.checkout.cart.move_to_wishlist') }}', {
                                        'ids': selectedItemsIds,
                                        'qty': selectedItemsQty
                                    })
                                    .then(response => {
                                        this.cart = response.data.data;

                                        this.$emitter.emit('update-mini-cart', response.data.data );

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                    })
                                    .catch(error => {});
                            }
                        });
                    },
                }
            });
        </script>
    @endpushOnce
</x-shop::layouts>
