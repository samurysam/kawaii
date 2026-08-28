<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.downloadable-products.name')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>☁️</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.downloadable-products.name')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Access your digital downloads and purchased files
                    </p>
                </div>
            </div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.downloadable_products.list.before') !!}

        <!-- For Desktop View -->
        <div class="max-md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.downloadable_products.index')" />
        </div>

        <!-- For Mobile View -->
        <div class="hidden max-md:block">
            <x-shop::datagrid :src="route('shop.customers.account.downloadable_products.index')">
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
                        <div class="grid gap-4">
                            <template
                                v-for="record in available.records"
                                v-if="available.records.length"
                            >
                                <div class="grid w-full gap-3 rounded-[20px] border-[1.5px] border-[#f2d7df] bg-white p-4 shadow-sm transition-all hover:bg-[#fff9fc] hover:border-[#e7cf9a]">
                                    <div class="flex justify-between items-center border-b border-[#fae8ef] pb-3">
                                        <div class="font-['Playfair_Display'] text-sm font-bold text-[#3f2b2d]">
                                            <p>@lang('shop::app.customers.account.downloadable-products.orderId'): #@{{ record.increment_id }}</p>

                                            <p class="text-xs font-semibold text-[#7c6770]">
                                                @{{ record.created_at }}
                                            </p>
                                        </div>

                                        <div v-html="record.status"></div>
                                    </div>
            
                                    <div class="text-sm font-semibold">
                                        <p
                                            class="font-['Playfair_Display'] text-base font-bold text-[#d95d86]"
                                            v-html="record.product_name"
                                        >
                                        </p>

                                        <div class="mt-2 flex items-center justify-between text-xs">
                                            <span class="font-bold text-[#7c6770]">@lang('Remaining Downloads'):</span>
                                            <span class="rounded-full bg-[#fff0f5] px-3 py-1 font-bold text-[#d95d86] border border-[#f2d7df]">
                                                @{{ record.remaining_downloads }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-else>
                                <div class="py-12 text-center text-sm font-semibold text-[#7c6770]">
                                    @{{ available.records.length }} @lang('shop::app.customers.account.downloadable-products.records-found')
                                </div>
                            </template>
                        </div>
                    </template>
                </template>
            </x-shop::datagrid>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.downloadable_products.list.after') !!}

    </div>
</x-shop::layouts.account>