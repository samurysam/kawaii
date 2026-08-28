<!-- Coupon Vue Component -->
<v-coupon 
    :cart="cart"
    @coupon-applied="getCart"
    @coupon-removed="getCart"
>
</v-coupon>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-coupon-template"
    >
        <div class="kb-co-coupon-wrap">
            {!! view_render_event('bagisto.shop.checkout.cart.coupon.before') !!}

            <!-- If Coupon is Applied -->
            <div
                class="kb-co-coupon-applied-badge"
                v-if="cart.coupon_code"
            >
                <div class="flex items-center gap-2">
                    <span>✨</span>
                    <span>@{{ cart.coupon_code }}</span>
                    <span class="text-xs font-normal opacity-90">(Applied ✓)</span>
                </div>

                <button
                    type="button"
                    class="text-sm font-bold text-red-500 hover:text-red-700 transition-colors p-1"
                    title="@lang('shop::app.checkout.coupon.remove')"
                    @click="destroyCoupon"
                >
                    ✕
                </button>
            </div>

            <!-- If No Coupon Applied: Inline Luxury Form -->
            <x-shop::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
                v-else
            >
                <form @submit="handleSubmit($event, applyCoupon)">
                    {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.before') !!}

                    <div class="kb-co-coupon-bar">
                        <x-shop::form.control-group class="!mb-0 flex-1">
                            <x-shop::form.control-group.control
                                type="text"
                                class="kb-co-coupon-input"
                                name="code"
                                rules="required"
                                placeholder="Enter coupon code"
                            />
                        </x-shop::form.control-group>

                        <button
                            type="submit"
                            class="kb-co-coupon-btn"
                            :disabled="isStoring"
                        >
                            <span v-if="isStoring" class="animate-spin">⏳</span>
                            <span v-else>Apply</span>
                        </button>
                    </div>

                    <x-shop::form.control-group.error
                        class="mt-1 text-xs text-red-500"
                        control-name="code"
                    />

                    {!! view_render_event('bagisto.shop.checkout.cart.coupon.coupon_form_controls.after') !!}
                </form>
            </x-shop::form>

            {!! view_render_event('bagisto.shop.checkout.cart.coupon.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-coupon', {
            template: '#v-coupon-template',
            
            props: ['cart'],

            data() {
                return {
                    isStoring: false,
                }
            },

            methods: {
                applyCoupon(params, { resetForm }) {
                    this.isStoring = true;

                    this.$axios.post("{{ route('shop.api.checkout.cart.coupon.apply') }}", params)
                        .then((response) => {
                            this.isStoring = false;
                            this.$emit('coupon-applied');
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                            resetForm();
                        })
                        .catch((error) => {
                            this.isStoring = false;

                            if ([400, 422].includes(error.response?.request?.status || error.response?.status)) {
                                this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                                resetForm();
                                return;
                            }

                            this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message || 'Failed to apply coupon' });
                        });
                },

                destroyCoupon() {
                    this.$axios.delete("{{ route('shop.api.checkout.cart.coupon.remove') }}", {
                            '_token': "{{ csrf_token() }}"
                        })
                        .then((response) => {
                            this.$emit('coupon-removed');
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(error => console.log(error));
                },
            }
        })
    </script>
@endPushOnce