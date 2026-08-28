<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Payment Links (uTap by e&)
    </x-slot>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <span>Payment Links</span>
                <span class="text-xs px-2.5 py-1 rounded-full font-bold bg-pink-100 text-pink-700 dark:bg-pink-900/40 dark:text-pink-300">
                    uTap by e&
                </span>
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Generate custom payment links or share your store's public QR code for custom collections.
            </p>
        </div>

        <div class="flex items-center gap-x-2.5">
            <!-- View Public QR Button -->
            <button
                type="button"
                class="secondary-button"
                onclick="window.open('{{ route('payment_link.open_pay') }}', '_blank')"
            >
                📱 Open Public QR Page
            </button>

            <!-- Create Payment Link Button -->
            <v-create-payment-link-form></v-create-payment-link-form>
        </div>
    </div>

    <!-- DataGrid Table -->
    <x-admin::datagrid :src="route('admin.sales.payment_links.index')" ref="datagrid">
        <template #header="{ columns, records, sortPage, selectAllRecords, applied, isLoading }">
            <template v-if="isLoading">
                <x-admin::shimmer.datagrid.table.head :is-multi-row="true" />
            </template>
        </template>
    </x-admin::datagrid>

    <!-- Details & QR Code Modal -->
    <v-payment-link-drawer ref="paymentLinkDrawer"></v-payment-link-drawer>

    @pushOnce('scripts')
        <!-- Drawer Component Template -->
        <script type="text/x-template" id="v-payment-link-drawer-template">
            <x-admin::modal ref="qrModal">
                <x-slot:header>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        Payment Link #@{{ data.link_code }}
                    </p>
                </x-slot>

                <x-slot:content>
                    <div class="flex flex-col gap-5" v-if="data.id">
                        <!-- QR Code & Link Sharing Box -->
                        <div class="p-4 rounded-2xl bg-pink-50/60 border border-pink-200 text-center">
                            <img :src="data.qr_code_url" alt="QR Code" class="w-40 h-40 mx-auto rounded-xl shadow mb-3 bg-white p-2 border border-pink-100" />
                            <p class="text-xs font-bold text-gray-700 mb-2">Scan with camera or share link with customer</p>
                            
                            <div class="flex items-center gap-2 max-w-sm mx-auto">
                                <input
                                    type="text"
                                    :value="data.url"
                                    readonly
                                    class="w-full text-xs font-mono px-3 py-2 bg-white border border-pink-200 rounded-lg text-gray-700"
                                />
                                <button
                                    type="button"
                                    @click="copyUrl(data.url)"
                                    class="px-4 py-2 text-xs font-bold text-white rounded-lg transition"
                                    style="background:#ed5287;"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>

                        <!-- Data Breakdown -->
                        <div class="border border-gray-200 dark:border-gray-800 rounded-2xl p-4 divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Amount</span>
                                <span class="font-bold text-gray-900 dark:text-white text-sm" v-text="data.amount"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Customer Name</span>
                                <span class="font-semibold text-gray-900 dark:text-white" v-text="data.name"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Email ID</span>
                                <span class="font-semibold text-gray-900 dark:text-white" v-text="data.email"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Phone</span>
                                <span class="font-semibold text-gray-900 dark:text-white" v-text="data.phone"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Type</span>
                                <span class="font-semibold text-gray-900 dark:text-white" v-text="data.type"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Status</span>
                                <span class="font-bold uppercase" :class="data.status === 'completed' ? 'text-green-600' : 'text-amber-500'" v-text="data.status"></span>
                            </div>
                            <div class="flex justify-between py-2" v-if="data.utap_txn_id !== 'N/A'">
                                <span class="text-gray-500 font-semibold">uTap Txn ID</span>
                                <span class="font-mono text-gray-900 dark:text-white" v-text="data.utap_txn_id"></span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-500 font-semibold">Paid At</span>
                                <span class="font-semibold text-gray-900 dark:text-white" v-text="data.paid_at"></span>
                            </div>
                            <div class="py-2">
                                <span class="text-gray-500 font-semibold block mb-1">Reason for Payment:</span>
                                <p class="text-gray-800 dark:text-gray-200 font-semibold p-2 bg-gray-50 dark:bg-gray-900 rounded-xl" v-text="data.reason"></p>
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-admin::modal>
        </script>

        <!-- Create Form Template -->
        <script type="text/x-template" id="v-create-payment-link-form-template">
            <div>
                <button
                    type="button"
                    class="primary-button"
                    @click="$refs.createModal.toggle()"
                >
                    + Create Payment Link
                </button>

                <!-- Modal -->
                <x-admin::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, store)">
                        <x-admin::modal ref="createModal">
                            <x-slot:header>
                                <p class="text-lg font-bold text-gray-800 dark:text-white">
                                    Create Payment Link (uTap by e&) 💖
                                </p>
                            </x-slot>

                            <x-slot:content>
                                <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
                                    <!-- Amount in AED -->
                                    <x-admin::form.control-group class="mb-2">
                                        <x-admin::form.control-group.label class="required">
                                            Amount (AED)
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="amount"
                                            rules="required|decimal"
                                            label="Amount in AED"
                                            placeholder="e.g. 150.00"
                                        />

                                        <x-admin::form.control-group.error control-name="amount" />
                                    </x-admin::form.control-group>

                                    <!-- Customer Name -->
                                    <x-admin::form.control-group class="mb-2">
                                        <x-admin::form.control-group.label class="required">
                                            Customer Name
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="name"
                                            rules="required"
                                            label="Customer Name"
                                            placeholder="e.g. Samer Khan"
                                        />

                                        <x-admin::form.control-group.error control-name="name" />
                                    </x-admin::form.control-group>

                                    <!-- Email ID -->
                                    <x-admin::form.control-group class="mb-2">
                                        <x-admin::form.control-group.label class="required">
                                            Customer Email (for Receipt)
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="email"
                                            name="email"
                                            rules="required|email"
                                            label="Email Address"
                                            placeholder="customer@example.com"
                                        />

                                        <x-admin::form.control-group.error control-name="email" />
                                    </x-admin::form.control-group>

                                    <!-- Phone -->
                                    <x-admin::form.control-group class="mb-2">
                                        <x-admin::form.control-group.label>
                                            Phone Number
                                        </x-admin::form.control-group.label>

                                        <x-admin::form.control-group.control
                                            type="text"
                                            name="phone"
                                            label="Phone Number"
                                            placeholder="05X XXX XXXX"
                                        />

                                        <x-admin::form.control-group.error control-name="phone" />
                                    </x-admin::form.control-group>
                                </div>

                                <!-- Reason for Payment -->
                                <x-admin::form.control-group class="mb-2">
                                    <x-admin::form.control-group.label class="required">
                                        Reason for Payment
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="textarea"
                                        name="reason"
                                        rules="required"
                                        label="Reason for Payment"
                                        placeholder="e.g. Custom pre-order, express gift delivery, wholesale deposit..."
                                        rows="2"
                                    />

                                    <x-admin::form.control-group.error control-name="reason" />
                                </x-admin::form.control-group>

                                <!-- Validity -->
                                <x-admin::form.control-group class="mb-2">
                                    <x-admin::form.control-group.label>
                                        Link Validity (Days)
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        name="validity_days"
                                        value="30"
                                        label="Validity Days"
                                        placeholder="30"
                                    />

                                    <x-admin::form.control-group.error control-name="validity_days" />
                                </x-admin::form.control-group>
                            </x-slot>

                            <x-slot:footer>
                                <x-admin::button
                                    button-type="submit"
                                    class="primary-button"
                                    title="Generate Payment Link"
                                    ::loading="isLoading"
                                    ::disabled="isLoading"
                                />
                            </x-slot:footer>
                        </x-admin::modal>
                    </form>
                </x-admin::form>
            </div>
        </script>

        <script type="module">
            app.component('v-payment-link-drawer', {
                template: '#v-payment-link-drawer-template',

                data() {
                    return {
                        data: {},
                    };
                },

                mounted() {
                    window.__paymentLinkDrawer = this;
                },

                methods: {
                    open(url) {
                        this.$axios.get(url)
                            .then((response) => {
                                this.data = response.data.data;
                                this.$refs.qrModal.open();
                            })
                            .catch((error) => {
                                this.$emitter.emit('add-flash', { type: 'error', message: 'Unable to fetch link details' });
                            });
                    },

                    copyUrl(text) {
                        navigator.clipboard.writeText(text).then(() => {
                            this.$emitter.emit('add-flash', { type: 'success', message: 'Payment link copied to clipboard! 📋' });
                        });
                    }
                }
            });

            app.component('v-create-payment-link-form', {
                template: '#v-create-payment-link-form-template',

                data() {
                    return {
                        isLoading: false,
                    };
                },

                methods: {
                    store(params, { setErrors, resetForm }) {
                        this.isLoading = true;

                        this.$axios.post('{{ route('admin.sales.payment_links.store') }}', params)
                            .then((response) => {
                                this.isLoading = false;
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                                this.$refs.createModal.toggle();
                                resetForm();

                                // Reload datagrid
                                window.location.reload();
                            })
                            .catch((error) => {
                                this.isLoading = false;
                                if (error.response && error.response.status === 422) {
                                    setErrors(error.response.data.errors);
                                } else {
                                    this.$emitter.emit('add-flash', { type: 'error', message: error.response?.data?.message || 'Something went wrong' });
                                }
                            });
                    }
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>
