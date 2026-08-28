{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.before') !!}

<v-payment-methods
    :methods="paymentMethods"
    @payment-method-selected="setSelectedPaymentMethod"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <x-shop::shimmer.checkout.onepage.payment-method />
</v-payment-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-payment-methods-template"
    >
        <div>
            <template v-if="! methods">
                <!-- Payment Method shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.payment-method />
            </template>
    
            <template v-else>
                <!-- Step 3: Payment Method Card -->
                <div class="kb-co-step-card active-step">
                    {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.before') !!}

                    <!-- Step Header -->
                    <div class="kb-co-step-card-head">
                        <div class="kb-co-step-card-head-left">
                            <div class="kb-co-step-icon-box">💳</div>
                            <div>
                                <h2 class="kb-co-step-title">
                                    @lang('shop::app.checkout.onepage.payment.payment-method')
                                </h2>
                                <p class="kb-co-step-sub">
                                    Safe, secure and protected from checkout to delivery.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="kb-co-step-badge">
                                🔒 SECURE
                            </span>
                        </div>
                    </div>

                    <!-- Payment Gateways Grid -->
                    <div class="kb-co-method-grid">
                        <div 
                            class="kb-co-method-card"
                            :class="{'selected': selectedMethod === payment.method}"
                            v-for="(payment, index) in methods"
                            :key="payment.method"
                            @click="selectAndStore(payment)"
                        >
                            {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                            <input 
                                type="radio" 
                                name="payment[method]" 
                                :value="payment.payment"
                                :id="payment.method"
                                v-model="selectedMethod"
                                class="hidden"
                                @change="store(payment)"
                            >

                            <div class="kb-co-radio-indicator"></div>

                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <img
                                        class="h-6 w-auto object-contain"
                                        :src="payment.image"
                                        :alt="payment.method_title"
                                        :title="payment.method_title"
                                        v-if="payment.image"
                                    />
                                    <span class="text-xl" v-else>💳</span>

                                    <p class="text-sm font-bold text-[#3f2a2e]">
                                        @{{ payment.method_title }}
                                    </p>
                                </div>
                                
                                <p class="text-xs font-semibold text-[#756166]" v-if="payment.description">
                                    @{{ payment.description }}
                                </p>
                            </div>

                            {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}
                        </div>
                    </div>

                    <!-- Trust Strip -->
                    <div class="kb-co-card-trust-strip">
                        <span>🔒 Encrypted payment</span>
                        <span>·</span>
                        <span>🛡️ Buyer protection</span>
                        <span>·</span>
                        <span>🌸 100% authentic products guaranteed</span>
                        <span>·</span>
                        <span>↩ Easy returns</span>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.after') !!}
                </div>
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-payment-methods', {
            template: '#v-payment-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['payment-method-selected', 'processing', 'processed'],

            data() {
                return {
                    selectedMethod: null,
                }
            },

            methods: {
                selectAndStore(payment) {
                    this.selectedMethod = payment.method;
                    this.store(payment);
                },

                store(selectedMethod) {
                    this.$emit('payment-method-selected', selectedMethod.method);
                    this.$emit('processing', 'review');

                    this.$axios.post("{{ route('shop.checkout.onepage.payment_methods.store') }}", {
                            payment: selectedMethod
                        })
                        .then(response => {
                            this.$emit('processed', response.data.cart);

                            if (window.innerWidth <= 768) {
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'payment');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },
            },
        });
    </script>
@endPushOnce
