<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.orders.title')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>🛍️</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.orders.title')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Track, reorder, and review your purchase history
                    </p>
                </div>
            </div>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

        <!-- For Desktop View -->
        <div class="max-md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.orders.index')" />
        </div>

        <!-- For Mobile View -->
        <div class="md:hidden">
            <x-shop::datagrid :src="route('shop.customers.account.orders.index')">
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
                            <div class="mb-4 last:mb-0 w-full rounded-[20px] border-[1.5px] border-[#f2d7df] bg-white p-4 shadow-sm transition-all hover:bg-[#fff9fc] hover:border-[#e7cf9a]">
                                <a :href="record.actions[0].url" class="block no-underline">
                                    <div class="flex items-center justify-between border-b border-[#fae8ef] pb-3">
                                        <div>
                                            <p class="font-['Playfair_Display'] text-[15px] font-bold text-[#3f2b2d]">
                                                @lang('shop::app.customers.account.orders.order-id'): #@{{ record.id }}
                                            </p>
    
                                            <p class="text-xs font-semibold text-[#7c6770]">
                                                @{{ record.created_at }}
                                            </p>
                                        </div>
    
                                        <div v-html="record.status"></div>
                                    </div>
        
                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-xs font-bold text-[#7c6770]">
                                            @lang('shop::app.customers.account.orders.subtotal'):
                                        </span>
    
                                        <p class="font-['Plus_Jakarta_Sans'] text-base font-extrabold text-[#d95d86]">
                                            @{{ record.grand_total }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </template>
                </template>
            </x-shop::datagrid>
        </div>
    
        {!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}

    </div>
</x-shop::layouts.account>
