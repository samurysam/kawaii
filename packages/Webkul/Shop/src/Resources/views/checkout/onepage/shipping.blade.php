{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.before') !!}

<v-shipping-methods
    :methods="shippingMethods"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Shipping Method Shimmer Effect -->
    <x-shop::shimmer.checkout.onepage.shipping-method />
</v-shipping-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.shipping_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-shipping-methods-template"
    >
        <div>
            <template v-if="! methods">
                <!-- Shipping Method Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.shipping-method />
            </template>

            <template v-else>
                <!-- Step 2: Delivery Method Card -->
                <div class="kb-co-step-card active-step">
                    <!-- Step Header -->
                    <div class="kb-co-step-card-head">
                        <div class="kb-co-step-card-head-left">
                            <div class="kb-co-step-icon-box">🎁</div>
                            <div>
                                <h2 class="kb-co-step-title">
                                    @lang('shop::app.checkout.onepage.shipping.shipping-method')
                                </h2>
                                <p class="kb-co-step-sub">
                                    Choose how quickly the cuteness arrives.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="kb-co-step-btn-change"
                                @click="$emit('processing', 'shipping')"
                            >
                                Change
                            </button>
                        </div>
                    </div>

                    <!-- Methods Grid -->
                    <div class="kb-co-method-grid">
                        <template v-for="method in methods">
                            {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.before') !!}

                            <div
                                class="kb-co-method-card"
                                :class="{'selected': selectedMethod === rate.method}"
                                v-for="rate in method.rates"
                                :key="rate.method"
                                @click="selectAndStore(rate.method)"
                            >
                                <input 
                                    type="radio"
                                    name="shipping_method"
                                    :id="rate.method"
                                    :value="rate.method"
                                    v-model="selectedMethod"
                                    class="hidden"
                                    @change="store(rate.method)"
                                >

                                <div class="kb-co-radio-indicator"></div>

                                <div>
                                    <!-- Cute Category Icon -->
                                    <div class="text-xl mb-1.5">
                                        <span v-if="rate.method.includes('express')">✨</span>
                                        <span v-else-if="rate.method.includes('gift')">🎀</span>
                                        <span v-else>🌸</span>
                                    </div>

                                    <p class="text-sm font-bold text-[#3f2a2e]">
                                        @{{ rate.method_title }}
                                    </p>
                                    
                                    <p class="mt-0.5 text-xs font-semibold text-[#756166]" v-if="rate.method_description">
                                        @{{ rate.method_description }}
                                    </p>
                                </div>

                                <div class="mt-3 pt-2 border-t border-[#fae8ef]">
                                    <p class="kb-co-method-price-free" v-if="rate.price == 0 || rate.base_price == 0">
                                        FREE
                                    </p>
                                    <p class="text-sm font-extrabold text-[#3f2a2e]" v-else>
                                        @{{ rate.base_formatted_price }}
                                    </p>
                                </div>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.onepage.shipping_method.after') !!}
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-shipping-methods', {
            template: '#v-shipping-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['processing', 'processed'],

            data() {
                return {
                    selectedMethod: null,
                }
            },

            methods: {
                selectAndStore(method) {
                    this.selectedMethod = method;
                    this.store(method);
                },

                store(selectedMethod) {
                    this.$emit('processing', 'payment');

                    this.$axios.post("{{ route('shop.checkout.onepage.shipping_methods.store') }}", {    
                            shipping_method: selectedMethod,
                        })
                        .then(response => {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                this.$emit('processed', response.data.payment_methods);
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'shipping');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
