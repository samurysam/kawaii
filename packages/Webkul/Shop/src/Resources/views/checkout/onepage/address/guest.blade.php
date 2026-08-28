{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.before') !!}

<!-- Guest Address Vue Component -->
<v-checkout-address-guest
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
></v-checkout-address-guest>

{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.after') !!}

@include('shop::checkout.onepage.address.form')

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-guest-template"
    >
        <!-- Address Form -->
        <x-shop::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form @submit="handleSubmit($event, addAddress)">
                <!-- Guest Billing Address -->
                <div class="mb-4">
                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.before') !!}

                    <!-- Billing Address Form -->
                    <v-checkout-address-form
                        control-name="billing"
                        :address="cart.billing_address || undefined"
                    ></v-checkout-address-form>

                    <!-- Use for Shipping Checkbox -->
                    <div class="mt-4 pt-3 border-t border-[#fae8ef]" v-if="cart.have_stockable_items">
                        <x-shop::form.control-group class="!mb-0 flex items-center gap-2">
                            <x-shop::form.control-group.control
                                type="checkbox"
                                name="billing.use_for_shipping"
                                id="use_for_shipping"
                                for="use_for_shipping"
                                value="1"
                                @change="useBillingAddressForShipping = ! useBillingAddressForShipping"
                                ::checked="!! useBillingAddressForShipping"
                            />

                            <label
                                class="cursor-pointer select-none text-xs font-semibold text-[#756166]"
                                for="use_for_shipping"
                            >
                                Use this address for delivery too
                            </label>
                        </x-shop::form.control-group>
                    </div>

                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.after') !!}
                </div>

                <!-- Guest Shipping Address -->
                <template v-if="cart.have_stockable_items">
                    <div
                        class="mt-6 pt-4 border-t border-[#fae8ef]"
                        v-if="! useBillingAddressForShipping"
                    >
                        {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.before') !!}

                        <!-- Shipping Address Header -->
                        <h3 class="text-sm font-bold text-[#3f2a2e] mb-3">
                            @lang('shop::app.checkout.onepage.address.shipping-address')
                        </h3>
                    
                        <!-- Shipping Address Form -->
                        <v-checkout-address-form
                            control-name="shipping"
                            :address="cart.shipping_address || undefined"
                        ></v-checkout-address-form>

                        {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.after') !!}
                    </div>
                </template>

                <!-- Proceed Button -->
                <div class="mt-5 flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-gradient-to-r from-[#dfb76c] to-[#c49a45] text-white text-xs font-extrabold shadow-md hover:brightness-105 transition-all"
                        :disabled="isStoring"
                    >
                        <span v-if="isStoring" class="animate-spin">⏳</span>
                        <span>Continue to Delivery ✨</span>
                    </button>
                </div>
            </form>
        </x-shop::form>
    </script>

    <script type="module">
        app.component('v-checkout-address-guest', {
            template: '#v-checkout-address-guest-template',

            props: ['cart'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    useBillingAddressForShipping: true,
                    isStoring: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            methods: {
                addAddress(params, { setErrors }) {
                    this.isStoring = true;
                    params['billing']['use_for_shipping'] = this.useBillingAddressForShipping;

                    this.moveToNextStep();

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            if (response.data.data.redirect_url) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                if (this.cart.have_stockable_items) {
                                    this.$emit('processed', response.data.data.shippingMethods);
                                } else {
                                    this.$emit('processed', response.data.data.payment_methods);
                                }
                            }
                        })
                        .catch(error => {
                            this.isStoring = false;
                            this.$emit('processing', 'address');

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },

                moveToNextStep() {
                    if (this.cart.have_stockable_items) {
                        this.$emit('processing', 'shipping');
                    } else {
                        this.$emit('processing', 'payment');
                    }
                }
            }
        });
    </script>
@endPushOnce