<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.rma.customer.title')
    </x-slot:title>

    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="rma"></x-shop::breadcrumbs>
    @endSection

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>🔄</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.rma.customer-rma-index.heading')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Request returns, exchanges, and track return status
                    </p>
                </div>
            </div>

            <a
                href="{{ route('shop.customers.account.rma.create') }}"
                class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent shadow-md"
            >
                <span>+</span>
                <span>@lang('shop::app.rma.customer.create.heading')</span>
            </a>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.rma.list.before') !!}

        <!-- Datagrid -->
        <div class="max-md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.rma.index')" />
        </div>

        <div class="md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.rma.index')">
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
                            <div class="mb-4 w-full rounded-[20px] border-[1.5px] border-[#f6dce5] bg-white p-4 shadow-sm transition-all last:mb-0 hover:bg-[#fff9fc]">
                                <div class="block space-y-3">
                                    <!-- Row 1 -->
                                    <div class="flex items-start justify-between border-b border-[#fae8ef] pb-2">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.rma.index.datagrid.id')
                                            </span>

                                            <span class="font-['Fredoka'] text-sm font-bold text-[#382229]">
                                                #@{{ record.id }}
                                            </span>
                                        </div>

                                        <div class="flex flex-col gap-1 text-right">
                                            <span class="text-xs font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.rma.index.datagrid.order-ref')
                                            </span>

                                            <span class="text-sm font-bold text-[#ed6e98]"
                                                v-html="record.order_id">
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="flex items-start justify-between">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-xs font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.rma.index.datagrid.rma-status')
                                            </span>

                                            <div v-html="record.title"></div>
                                        </div>

                                        <div class="flex flex-col gap-1 text-right">
                                            <span class="text-xs font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.rma.index.datagrid.quantity')
                                            </span>

                                            <span class="text-sm font-semibold text-[#382229]"
                                                v-html="record.total_quantity">
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="flex items-center justify-between border-t border-[#fae8ef] pt-2">
                                        <div class="mt-1 flex flex-col gap-1">
                                            <span class="text-xs font-bold text-[#846671]">
                                                @lang('shop::app.customers.account.rma.index.datagrid.create')
                                            </span>

                                            <p class="text-xs font-semibold text-[#382229]">
                                                @{{ record.created_at }}
                                            </p>
                                        </div>

                                        <p
                                            class="mt-1 flex items-center gap-1.5"
                                            v-if="available.actions.length"
                                        >
                                            <span
                                                class="cursor-pointer rounded-full p-2 text-xl text-[#ed6e98] transition-all hover:bg-[#fff0f4] max-sm:place-self-center"
                                                :class="action.icon"
                                                v-text="! action.icon ? action.title : ''"
                                                v-for="action in record.actions"
                                                @click="performAction(action)"
                                            >
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                </template>
            </x-shop::datagrid>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.rma.list.after') !!}
    </div>
</x-shop::layouts.account>
