<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.wishlist.page-title')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Wishlist Vue Component -->
        <v-wishlist-products>
            <!-- Wishlist Shimmer Effect -->
            <x-shop::shimmer.customers.account.wishlist :count="4" />
        </v-wishlist-products>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-wishlist-products-template"
        >
            <div>
                <!-- Wishlist Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::shimmer.customers.account.wishlist :count="4" />
                </template>

                {!! view_render_event('bagisto.shop.customers.account.wishlist.list.before') !!}

                <!-- Wishlist Information -->
                <template v-else>
                    <div class="kb-dash-card-head">
                        <div class="kb-dash-card-head-left">
                            <div class="kb-dash-card-icon-box">
                                <span>🤍</span>
                            </div>
                            <div>
                                <h1 class="kb-dash-card-title">
                                    @lang('shop::app.customers.account.wishlist.page-title')
                                </h1>
                                <p class="kb-dash-card-subtitle">
                                    Your saved kawaii favorites and gift ideas
                                </p>
                            </div>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.account.wishlist.delete_all.before') !!}

                        <button
                            type="button"
                            class="kb-dash-danger-btn"
                            @click="removeAll"
                            v-if="wishlistItems.length"
                        >
                            <span>🗑️</span>
                            <span>@lang('shop::app.customers.account.wishlist.delete-all')</span>
                        </button>

                        {!! view_render_event('bagisto.shop.customers.account.wishlist.delete_all.after') !!}
                    </div>

                    <!-- Wishlist Items -->
                    <template v-if="wishlistItems.length">
                        <div class="grid gap-4">
                            <v-wishlist-products-item
                                v-for="(wishlist, index) in wishlistItems"
                                :wishlist="wishlist"
                                :key="wishlist.id"
                                @wishlist-items="(items) => wishlistItems = items"
                            >
                                <x-shop::shimmer.customers.account.wishlist />
                            </v-wishlist-products-item>
                        </div>
                    </template>

                    <!-- Empty Wishlist -->
                    <template v-else>
                        <div class="m-auto grid w-full place-content-center items-center justify-items-center py-16 text-center">
                            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[#fff0f5] border border-[#f2d7df] shadow-inner mb-4">
                                <span class="text-4xl">🤍</span>
                            </div>

                            <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#3f2b2d] mb-1">
                                @lang('shop::app.customers.account.wishlist.empty')
                            </h2>

                            <p class="text-sm font-semibold text-[#7c6770] mb-6 max-w-sm">
                                Explore our collection and click the heart icon on items you adore!
                            </p>

                            <a
                                href="{{ route('shop.home.index') }}"
                                class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent px-8 py-3 text-sm shadow-md"
                            >
                                <span>♥</span>
                                <span>Start Exploring</span>
                            </a>
                        </div>
                    </template>
                </template>

                {!! view_render_event('bagisto.shop.customers.account.wishlist.list.after') !!}
            </div>
        </script>

        <script
            type="text/x-template"
            id="v-wishlist-products-item-template"
        >
            <div class="rounded-[22px] border-[1.5px] border-[#f2d7df] bg-white p-5 shadow-[0_6px_20px_rgba(237,110,152,0.04)] transition-all hover:border-[#e7cf9a] hover:shadow-[0_10px_28px_rgba(237,110,152,0.1)]">
                <div class="flex items-center justify-between gap-5 max-md:flex-col max-md:items-start">
                    <div class="flex items-center gap-5 max-md:w-full">
                        {!! view_render_event('bagisto.shop.customers.account.wishlist.image.before') !!}

                        <a
                            :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', wishlist.product.url_key)"
                            class="shrink-0"
                        >
                            <img
                                class="h-24 w-24 rounded-[16px] border border-[#fae8ef] object-cover max-md:h-20 max-md:w-20 shadow-sm"
                                :src="wishlist.product.base_image.small_image_url"
                                :alt="wishlist.product.base_image.alt"
                            />
                        </a>

                        {!! view_render_event('bagisto.shop.customers.account.wishlist.image.after') !!}

                        <div class="grid gap-1">
                            <a
                                :href="'{{ route('shop.product_or_category.index', ':slug') }}'.replace(':slug', wishlist.product.url_key)"
                                class="font-['Playfair_Display'] text-[17px] font-bold text-[#3f2b2d] hover:text-[#d95d86] transition-colors"
                            >
                                @{{ wishlist.product.name }}
                            </a>

                            <!-- Wishlist Item Price -->
                            <div
                                class="font-['Plus_Jakarta_Sans'] text-base font-extrabold text-[#d95d86]"
                                v-html="wishlist.product.price_html"
                            ></div>

                            <!-- Options dropdown if any -->
                            <div
                                class="mt-1"
                                v-if="wishlist.options?.attributes"
                            >
                                <p
                                    class="flex cursor-pointer items-center gap-1.5 text-xs font-bold text-[#7c6770] hover:text-[#d95d86]"
                                    @click="wishlist.option_show = ! wishlist.option_show"
                                >
                                    @lang('shop::app.customers.account.wishlist.see-details')
                                    <span>@{{ wishlist.option_show ? '▲' : '▼' }}</span>
                                </p>

                                <div
                                    class="mt-2 rounded-xl bg-[#fff8fb] p-3 text-xs"
                                    v-show="wishlist.option_show"
                                >
                                    <div
                                        v-for="option in wishlist.options?.attributes"
                                        class="flex gap-2 py-0.5"
                                    >
                                        <span class="font-bold text-[#3f2b2d]">@{{ option.attribute_name }}:</span>
                                        <span class="text-[#7c6770]">@{{ option.option_label }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Strip -->
                    <div class="flex items-center gap-4 max-md:w-full max-md:justify-between border-t max-md:pt-3 max-md:border-[#fae8ef] md:border-t-0">
                        {!! view_render_event('bagisto.shop.customers.account.wishlist.perform_actions.before') !!}

                        <div class="flex items-center gap-3">
                            <x-shop::quantity-changer
                                name="quantity"
                                ::value="wishlist.options.quantity ?? 1"
                                class="flex h-10 items-center gap-x-2 rounded-full border border-[#f2d7df] bg-white px-3 py-1 text-xs font-bold text-[#3f2b2d]"
                                :removable="true"
                                @change="(qty) => wishlist.quantity = qty"
                                @remove="remove"
                            />

                            @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                                <button
                                    type="button"
                                    class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent h-10 px-5 text-xs shadow-md"
                                    :disabled="movingToCart"
                                    @click="moveToCart"
                                >
                                    <span>🛍️</span>
                                    <span>@lang('shop::app.customers.account.wishlist.move-to-cart')</span>
                                </button>
                            @endif
                        </div>

                        {!! view_render_event('bagisto.shop.customers.account.wishlist.perform_actions.after') !!}

                        <!-- Remove from Wishlist -->
                        <button
                            type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-[#fff0f4] text-[#d95d86] border border-[#f2d7df] hover:bg-[#ffe0e8] transition-colors cursor-pointer"
                            title="Remove"
                            @click="remove"
                        >
                            <span class="icon-bin text-base"></span>
                        </button>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component("v-wishlist-products", {
                template: '#v-wishlist-products-template',

                data() {
                    return {
                        isLoading: true,

                        wishlistItems: [],
                    };
                },

                mounted() {
                    this.get();
                },

                methods: {
                    get() {
                        this.$axios.get("{{ route('shop.api.customers.account.wishlist.index') }}")
                            .then(response => {
                                this.isLoading = false;

                                this.wishlistItems = response.data.data;
                            })
                            .catch(error => {});
                    },

                    removeAll() {
                        this.$emitter.emit('open-confirm-modal', {
                            message: 'Are you sure you want to remove all items from your wishlist?',
                            agree: () => {
                                this.$axios.post("{{ route('shop.api.customers.account.wishlist.destroy_all') }}", {
                                        '_method': 'DELETE',
                                    })
                                    .then(response => {
                                        this.wishlistItems = [];

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                                    })
                                    .catch(error => {});
                            },
                        });
                    },
                },
            });

            app.component('v-wishlist-products-item', {
                template: '#v-wishlist-products-item-template',

                props: ['wishlist'],

                emits: ['wishlist-items'],

                data() {
                    return {
                        movingToCart: false,
                    };
                },

                methods: {
                    remove() {
                        this.$emitter.emit('open-confirm-modal', {
                            message: 'Remove this item from your wishlist?',
                            agree: () => {
                                this.$axios
                                    .delete('{{ route('shop.api.customers.account.wishlist.destroy', ':id') }}'.replace(':id', this.wishlist.id))
                                    .then(response => {
                                        this.$emit('wishlist-items', response.data.data);

                                        this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                    })
                                    .catch(error => {});
                            },
                        });
                    },

                    moveToCart() {
                        this.movingToCart = true;

                        const endpoint = `{{ route('shop.api.customers.account.wishlist.move_to_cart', ':wishlistId:') }}`.replace(':wishlistId:', this.wishlist.id);

                        this.$axios.post(endpoint, {
                                quantity: (this.wishlist.quantity ?? this.wishlist.options.quantity) ?? 1,
                                product_id: this.wishlist.product.id,
                            })
                            .then(response => {
                                if (response.data?.redirect) {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: response.data.message });

                                    window.location.href = response.data.data;

                                    return;
                                }

                                this.$emit('wishlist-items', response.data.data?.wishlist);

                                this.$emitter.emit('update-mini-cart', response.data.data.cart);

                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                this.movingToCart = false;
                            })
                            .catch(error => {
                                this.movingToCart = false;

                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                            });
                    },
                },
            });
        </script>
    @endpushOnce
</x-shop::layouts.account>
