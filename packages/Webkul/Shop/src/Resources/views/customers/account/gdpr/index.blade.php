<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.gdpr.index.title')
    </x-slot>
    
    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="gdpr" />
        @endSection
    @endif

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head gap-4 max-md:flex-wrap">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>🛡️</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.gdpr.index.title')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Manage your personal data requests and exports
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a 
                    href="{{ route('shop.customers.account.gdpr.pdf-view') }}"
                    class="kb-dash-head-btn"
                >
                    <span>📄</span>
                    <span>@lang('shop::app.customers.account.gdpr.index.pdf')</span>
                </a>

                <a
                    href="{{ route('shop.customers.account.gdpr.html-view') }}"
                    target="_blank"
                    class="kb-dash-head-btn"
                >
                    <span>🌐</span>
                    <span>@lang('shop::app.customers.account.gdpr.index.html')</span>
                </a>

                <button
                    type="button"
                    class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent shadow-md"
                    @click="$emitter.emit('open-gdpr-modal')"
                >
                    <span>+</span>
                    <span>@lang('shop::app.customers.account.gdpr.index.create-btn')</span>
                </button>
            </div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.gdpr.list.before') !!}

        <!-- For Desktop View -->
        <div class="max-md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.gdpr.index')" />
        </div>

        <!-- For Mobile View -->
        <div class="md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.gdpr.index')">
                <!-- Datagrid Header -->
                <template #header="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <div class="hidden"></div>
                </template>

                <template #body="{
                    isLoading,
                    available,
                    applied,
                    selectAll,
                    sort,
                    performAction
                }">
                    <template v-if="isLoading">
                        <x-shop::shimmer.datagrid.table.body />
                    </template>
    
                    <template v-else>
                        <template v-for="record in available.records">
                            <div class="mb-4 last:mb-0 w-full rounded-[20px] border-[1.5px] border-[#f6dce5] bg-white p-4 shadow-sm transition-all hover:bg-[#fff9fc]">
                                <div class="flex items-center justify-between border-b border-[#fae8ef] pb-3">
                                    <div class="flex flex-col gap-1 text-xs">
                                        <div class="flex gap-2">
                                            <span class="font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.gdpr.index.datagrid.id'): 
                                            </span>
                                            
                                            <span class="font-bold text-[#382229]">
                                                #@{{ record.id }}
                                            </span>
                                        </div>

                                        <div class="flex gap-2">
                                            <span class="font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.gdpr.index.datagrid.type'): 
                                            </span>
                                            
                                            <span class="font-bold text-[#ed6e98] uppercase">
                                                @{{ record.type }}
                                            </span>
                                        </div>

                                        <div class="flex gap-2">
                                            <span class="font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.gdpr.index.datagrid.date'): 
                                            </span>
                                            
                                            <span class="text-[#382229]">
                                                @{{ record.created_at }}
                                            </span>
                                        </div>
                                    </div>

                                    <div v-html="record.status"></div>
                                </div>

                                <div class="mt-3 text-xs">
                                    <span class="font-bold text-[#846671]">@lang('shop::app.customers.account.gdpr.index.datagrid.message'):</span>
                                    <p class="mt-1 font-semibold text-[#382229] leading-relaxed">
                                        @{{ record.message }}
                                    </p>
                                </div>

                                <div class="mt-3 flex justify-end" v-if="record.revoke" v-html="record.revoke"></div>
                            </div>
                        </template>
                    </template>
                </template>
            </x-shop::datagrid>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.gdpr.list.after') !!}
    </div>

    <!-- GDPR Request Form -->
    <v-account-gdpr></v-account-gdpr>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-account-gdpr-template"
        >
            <x-shop::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                {!! view_render_event('bagisto.shop.customers.account.gdpr.request.form_controls.before') !!}

                <form @submit="handleSubmit($event, store)">
                    <x-shop::modal ref="loginModel">
                        <!-- Modal Header -->
                        <x-slot:header>
                            <h2 class="font-['Fredoka'] text-2xl font-bold text-[#382229]">
                                @lang('shop::app.customers.account.gdpr.index.modal.title')
                            </h2>
                        </x-slot>

                        <!-- Modal Content -->
                        <x-slot:content>
                            <!-- Type -->
                            <x-shop::form.control-group>
                                <x-shop::form.control-group.label class="required font-['Fredoka'] text-[13.5px] font-semibold text-[#5b3a45]">
                                    @lang('shop::app.customers.account.gdpr.index.modal.type.title')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="select"
                                    name="type"
                                    rules="required"
                                    class="!h-[48px] !px-4"
                                >
                                    <option
                                        value=""
                                        disabled
                                        selected
                                    >
                                        @lang('shop::app.customers.account.gdpr.index.modal.type.choose')
                                    </option>

                                    <option value="update">
                                        @lang('shop::app.customers.account.gdpr.index.modal.type.update')
                                    </option>

                                    <option value="delete">
                                        @lang('shop::app.customers.account.gdpr.index.modal.type.delete')
                                    </option>
                                </x-shop::form.control-group.control>

                                <x-shop::form.control-group.error control-name="type" />
                            </x-shop::form.control-group>

                            <!-- Message -->
                            <x-shop::form.control-group class="!mb-0">
                                <x-shop::form.control-group.label class="required font-['Fredoka'] text-[13.5px] font-semibold text-[#5b3a45]">
                                    @lang('shop::app.customers.account.gdpr.index.modal.message')
                                </x-shop::form.control-group.label>

                                <x-shop::form.control-group.control
                                    type="textarea"
                                    name="message"
                                    rules="required"
                                    class="p-4 rounded-2xl border-[1.5px] border-[#ebd3df] w-full"
                                    placeholder="Please describe your GDPR request..."
                                />

                                <x-shop::form.control-group.error control-name="message" />
                            </x-shop::form.control-group>
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <div class="flex flex-wrap items-center gap-4">
                                <x-shop::button
                                    class="primary-button max-w-none flex-auto px-10 py-3 text-base shadow-md"
                                    :title="trans('shop::app.customers.account.gdpr.index.modal.save')"
                                    ::loading="isStoring"
                                    ::disabled="isStoring"
                                />
                            </div>
                        </x-slot>
                    </x-shop::modal>
                </form>

                {!! view_render_event('bagisto.shop.customers.account.gdpr.request.form_controls.after') !!}
            </x-shop::form>
        </script>

        <script type="module">
            app.component('v-account-gdpr', {
                template: '#v-account-gdpr-template',

                data() {
                    return {
                        isStoring: false,
                    };
                },

                mounted() {
                    this.$emitter.on('open-gdpr-modal', () => {
                        this.$refs.loginModel?.open();
                    });
                },

                methods: {
                    store(params, { resetForm, setErrors }) {
                        if (this.isStoring) {
                            return;
                        }

                        this.isStoring = true;

                        this.$axios.post("{{ route('shop.customers.account.gdpr.store') }}", params)
                            .then((response) => {
                                this.$emitter.emit('add-flash', {
                                    type: 'success',
                                    message: response.data.message,
                                });

                                window.location.reload();
                            })
                            .catch((error) => {
                                this.isStoring = false;

                                if (error.response?.status == 422) {
                                    setErrors(error.response.data.errors);

                                    return;
                                }

                                this.$emitter.emit('add-flash', {
                                    type: 'error',
                                    message: error.response?.data?.message,
                                });
                            });
                    },
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts.account>
