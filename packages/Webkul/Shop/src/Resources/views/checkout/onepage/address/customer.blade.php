{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.before') !!}

<!-- Customer Address Vue Component -->
<v-checkout-address-customer
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Billing Address Shimmer -->
    <x-shop::shimmer.checkout.onepage.address />
</v-checkout-address-customer>

{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-customer-template"
    >
        <template v-if="isLoading">
            <!-- Billing Address Shimmer -->
            <x-shop::shimmer.checkout.onepage.address />
        </template>

        <template v-else>
            <!-- Saved Addresses View -->
            <template v-if="! activeAddressForm && customerSavedAddresses.billing.length">
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, addAddressToCart)">
                        <!-- Saved Customer Addresses Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="kb-co-address-card"
                                :class="{'selected': selectedAddresses.billing_address_id == address.id}"
                                v-for="address in customerSavedAddresses.billing"
                                :key="address.id"
                            >
                                <!-- Top Bar: Radio & Edit Button -->
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <x-shop::form.control-group class="!mb-0 flex items-center">
                                            <x-shop::form.control-group.control
                                                type="radio"
                                                name="billing.id"
                                                ::id="`billing_address_id_${address.id}`"
                                                ::for="`billing_address_id_${address.id}`"
                                                ::value="address.id"
                                                v-model="selectedAddresses.billing_address_id"
                                                rules="required"
                                                label="{{ trans('shop::app.checkout.onepage.address.billing-address') }}"
                                            />
                                        </x-shop::form.control-group>

                                        <p class="text-sm font-bold text-[#3f2a2e]">
                                            @{{ address.first_name + ' ' + address.last_name }}
                                        </p>

                                        <span
                                            class="kb-co-address-badge-default"
                                            v-if="address.default_address"
                                        >
                                            DEFAULT
                                        </span>
                                    </div>

                                    <!-- Edit Button -->
                                    <button
                                        type="button"
                                        class="kb-co-address-btn-edit"
                                        @click="
                                            selectedAddressForEdit = address;
                                            activeAddressForm = 'billing';
                                            saveAddress = address.address_type == 'customer'
                                        "
                                    >
                                        <span>✏️</span>
                                        <span>Edit</span>
                                    </button>
                                </div>

                                <!-- Address Details -->
                                <label
                                    class="block cursor-pointer pl-6 text-xs leading-relaxed text-[#756166]"
                                    :for="`billing_address_id_${address.id}`"
                                >
                                    <p v-if="address.address">
                                        @{{ address.address.join(', ') }}
                                    </p>

                                    <p>
                                        @{{ address.city }}<template v-if="address.state">, @{{ address.state }}</template>, @{{ address.country }}<template v-if="address.postcode"> · @{{ address.postcode }}</template>
                                    </p>

                                    <p v-if="address.phone" class="mt-1 font-semibold text-[#3f2a2e]">
                                        📞 @{{ address.phone }}
                                    </p>
                                </label>
                            </div>

                            <!-- Add New Address Button Card -->
                            <div
                                class="kb-co-add-address-card"
                                @click="activeAddressForm = 'billing'"
                                v-if="! cart.billing_address"
                            >
                                <span class="text-xl font-bold">+</span>
                                <span>@lang('shop::app.checkout.onepage.address.add-new-address')</span>
                            </div>
                        </div>

                        <!-- Error Message Block -->
                        <x-shop::form.control-group.error name="billing.id" />

                        <!-- Shipping Address Block if have stockable items -->
                        <template v-if="cart.have_stockable_items">
                            <!-- Use for Shipping Checkbox -->
                            <div class="mt-4 pt-3 border-t border-[#fae8ef]">
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

                            <!-- Customer Separate Shipping Address -->
                            <div
                                class="mt-6 pt-4 border-t border-[#fae8ef]"
                                v-if="! useBillingAddressForShipping"
                            >
                                <h3 class="text-sm font-bold text-[#3f2a2e] mb-3">
                                    @lang('shop::app.checkout.onepage.address.shipping-address')
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div
                                        class="kb-co-address-card"
                                        :class="{'selected': selectedAddresses.shipping_address_id == address.id}"
                                        v-for="address in customerSavedAddresses.shipping"
                                        :key="address.id"
                                    >
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <x-shop::form.control-group class="!mb-0 flex items-center">
                                                    <x-shop::form.control-group.control
                                                        type="radio"
                                                        name="shipping.id"
                                                        ::id="`shipping_address_id_${address.id}`"
                                                        ::for="`shipping_address_id_${address.id}`"
                                                        ::value="address.id"
                                                        v-model="selectedAddresses.shipping_address_id"
                                                        rules="required"
                                                        label="{{ trans('shop::app.checkout.onepage.address.shipping-address') }}"
                                                    />
                                                </x-shop::form.control-group>

                                                <p class="text-sm font-bold text-[#3f2a2e]">
                                                    @{{ address.first_name + ' ' + address.last_name }}
                                                </p>
                                            </div>

                                            <button
                                                type="button"
                                                class="kb-co-address-btn-edit"
                                                @click="
                                                    selectedAddressForEdit = address;
                                                    activeAddressForm = 'shipping';
                                                    saveAddress = address.address_type == 'customer'
                                                "
                                            >
                                                <span>✏️</span>
                                                <span>Edit</span>
                                            </button>
                                        </div>

                                        <label
                                            class="block cursor-pointer pl-6 text-xs leading-relaxed text-[#756166]"
                                            :for="`shipping_address_id_${address.id}`"
                                        >
                                            <p v-if="address.address">
                                                @{{ address.address.join(', ') }}
                                            </p>

                                            <p>
                                                @{{ address.city }}<template v-if="address.state">, @{{ address.state }}</template>, @{{ address.country }}<template v-if="address.postcode"> · @{{ address.postcode }}</template>
                                            </p>
                                        </label>
                                    </div>

                                    <!-- Add New Address Card -->
                                    <div
                                        class="kb-co-add-address-card"
                                        @click="selectedAddressForEdit = null; activeAddressForm = 'shipping'"
                                        v-if="! cart.shipping_address"
                                    >
                                        <span class="text-xl font-bold">+</span>
                                        <span>@lang('shop::app.checkout.onepage.address.add-new-address')</span>
                                    </div>
                                </div>

                                <x-shop::form.control-group.error name="shipping.id" />
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
            </template>

            <!-- Create/Edit Address Form -->
            <template v-else>
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, updateOrCreateAddress)">
                        <!-- Address Form Header -->
                        <div class="mb-4 flex items-center justify-between pb-3 border-b border-[#fae8ef]">
                            <h3 class="text-base font-bold text-[#3f2a2e]">
                                <template v-if="activeAddressForm == 'billing'">
                                    @lang('shop::app.checkout.onepage.address.billing-address')
                                </template>

                                <template v-else>
                                    @lang('shop::app.checkout.onepage.address.shipping-address')
                                </template>
                            </h3>

                            <button
                                type="button"
                                class="text-xs font-bold text-[#d95882] hover:underline flex items-center gap-1"
                                v-show="customerSavedAddresses.billing.length && ['billing', 'shipping'].includes(activeAddressForm)"
                                @click="selectedAddressForEdit = null; activeAddressForm = null"
                            >
                                <span>&larr;</span>
                                <span>@lang('shop::app.checkout.onepage.address.back')</span>
                            </button>
                        </div>
                        
                        <!-- Address Form Vue Component -->
                        <v-checkout-address-form
                            :control-name="activeAddressForm"
                            :address="selectedAddressForEdit || undefined"
                        ></v-checkout-address-form>

                        <!-- Save Address to Address Book Checkbox -->
                        <div class="mt-4">
                            <x-shop::form.control-group class="!mb-0 flex items-center gap-2">
                                <x-shop::form.control-group.control
                                    type="checkbox"
                                    ::name="activeAddressForm + '.save_address'"
                                    id="save_address"
                                    for="save_address"
                                    value="1"
                                    v-model="saveAddress"
                                    @change="saveAddress = ! saveAddress"
                                />

                                <label
                                    class="cursor-pointer select-none text-xs font-semibold text-[#756166]"
                                    for="save_address"
                                >
                                    @lang('shop::app.checkout.onepage.address.save-address')
                                </label>
                            </x-shop::form.control-group>
                        </div>

                        <!-- Save Button -->
                        <div class="mt-5 flex justify-end gap-3">
                            <button
                                type="button"
                                class="px-6 py-2.5 rounded-full border border-[#f2d7df] text-xs font-bold text-[#756166] hover:bg-[#fff5f8]"
                                @click="selectedAddressForEdit = null; activeAddressForm = null"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-8 py-2.5 rounded-full bg-gradient-to-r from-[#dfb76c] to-[#c49a45] text-white text-xs font-extrabold shadow-md hover:brightness-105 transition-all"
                                :disabled="isStoring"
                            >
                                <span v-if="isStoring" class="animate-spin">⏳</span>
                                <span>@lang('shop::app.checkout.onepage.address.save')</span>
                            </button>
                        </div>
                    </form>
                </x-shop::form>
            </template>
        </template>
    </script>

    <script type="module">
        app.component('v-checkout-address-customer', {
            template: '#v-checkout-address-customer-template',

            props: ['cart'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    customerSavedAddresses: {
                        'billing': [],
                        'shipping': [],
                    },

                    useBillingAddressForShipping: true,
                    activeAddressForm: null,
                    selectedAddressForEdit: null,
                    saveAddress: false,

                    selectedAddresses: {
                        billing_address_id: null,
                        shipping_address_id: null,
                    },

                    isLoading: true,
                    isStoring: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            mounted() {
                this.getCustomerSavedAddresses();
            },

            methods: {
                getCustomerSavedAddresses() {
                    this.$axios.get('{{ route('shop.api.customers.account.addresses.index') }}')
                        .then(response => {
                            this.initializeAddresses('billing', structuredClone(response.data.data));
                            this.initializeAddresses('shipping', structuredClone(response.data.data));

                            if (! this.customerSavedAddresses.billing.length) {
                                this.activeAddressForm = 'billing';
                            }

                            this.isLoading = false;
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                },

                initializeAddresses(type, addresses) {
                    this.customerSavedAddresses[type] = addresses;

                    let cartAddress = this.cart[type + '_address'];

                    if (! cartAddress) {
                        addresses.forEach(address => {
                            if (address.default_address) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });

                        return addresses;
                    }

                    if (cartAddress.parent_address_id) {
                        addresses.forEach(address => {
                            if (address.id == cartAddress.parent_address_id) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });
                    } else {
                        this.selectedAddresses[type + '_address_id'] = cartAddress.id;
                        addresses.unshift(cartAddress);
                    }

                    return addresses;
                },

                updateOrCreateAddress(params, { setErrors }) {
                    this.$emit('processing', 'address');

                    params = params[this.activeAddressForm];

                    let address = this.customerSavedAddresses[this.activeAddressForm].find(address => {
                        return address.id == params.id;
                    });

                    if (! address) {
                        if (params.save_address) {
                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.addAddressToList(params);
                        }

                        return;
                    }

                    if (params.save_address) {
                        if (address.address_type == 'customer') {
                            this.updateCustomerAddress(params.id, params, { setErrors })
                                .then((response) => {
                                    this.updateAddressInList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.removeAddressFromList(params);

                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        }
                    } else {
                        this.updateAddressInList(params);
                    }
                },

                addAddressToList(address) {
                    this.cart[this.activeAddressForm + '_address'] = address;
                    this.customerSavedAddresses[this.activeAddressForm].unshift(address);
                    this.selectedAddresses[this.activeAddressForm + '_address_id'] = address.id;
                    this.activeAddressForm = null;
                },

                updateAddressInList(params) {
                    this.customerSavedAddresses[this.activeAddressForm].forEach((address, index) => {
                        if (address.id == params.id) {
                            params = {
                                ...address,
                                ...params,
                            };

                            this.cart[this.activeAddressForm + '_address'] = params;
                            this.customerSavedAddresses[this.activeAddressForm][index] = params;
                            this.selectedAddresses[this.activeAddressForm + '_address_id'] = params.id;
                            this.activeAddressForm = null;
                        }
                    });
                },

                removeAddressFromList(params) {
                    this.customerSavedAddresses[this.activeAddressForm] = this.customerSavedAddresses[this.activeAddressForm].filter(address => address.id != params.id);
                },

                createCustomerAddress(params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.post('{{ route('shop.api.customers.account.addresses.store') }}', params)
                        .then((response) => {
                            this.isStoring = false;
                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};
                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });
                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                updateCustomerAddress(id, params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.put('{{ route('shop.api.customers.account.addresses.update') }}/' + id, params)
                        .then((response) => {
                            this.isStoring = false;
                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};
                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });
                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                addAddressToCart(params, { setErrors }) {
                    let payload = {
                        billing: {
                            ...this.getSelectedAddress('billing', params.billing.id),
                            use_for_shipping: this.useBillingAddressForShipping
                        },
                    };

                    if (params.shipping !== undefined) {
                        payload.shipping = this.getSelectedAddress('shipping', params.shipping.id);
                    }

                    this.isStoring = true;
                    this.moveToNextStep();

                    this.$axios.post('{{ route('shop.checkout.onepage.addresses.store') }}', payload)
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
                                const billingRegex = /^billing\./;

                                if (Object.keys(error.response.data.errors).some(key => billingRegex.test(key))) {
                                    setErrors({
                                        'billing.id': error.response.data.message
                                    });
                                } else {
                                    setErrors({
                                        'shipping.id': error.response.data.message
                                    });
                                }
                            }
                        });
                },

                getSelectedAddress(type, id) {
                    let address = Object.assign({}, this.customerSavedAddresses[type].find(address => address.id == id));

                    if (id == 0) {
                        address.id = null;
                    }

                    if (! address.email) {
                        address.email = this.cart?.customer_email || @js(auth()->guard('customer')->user()?->email ?? '');
                    }

                    if (address.phone) {
                        address.phone = String(address.phone).replace(/[\s\-\(\)]/g, '');
                    }

                    return {
                        ...address,
                        default_address: 0,
                    };
                },

                moveToNextStep() {
                    if (this.cart.have_stockable_items) {
                        this.$emit('processing', 'shipping');
                    } else {
                        this.$emit('processing', 'payment');
                    }
                },
            }
        });
    </script>
@endPushOnce