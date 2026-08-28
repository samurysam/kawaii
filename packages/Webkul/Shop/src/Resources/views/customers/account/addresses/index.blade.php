<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.index.title')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>📍</span>
                </div>

                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.addresses.index.title')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Manage your saved shipping and billing addresses
                    </p>
                </div>
            </div>

            <a
                href="{{ route('shop.customers.account.addresses.create') }}"
                class="kb-dash-head-btn"
            >
                <span>+</span>
                <span>@lang('shop::app.customers.account.addresses.index.add-address')</span>
            </a>
        </div>

        @if (! $addresses->isEmpty())
            <!-- Address Information List -->
            {!! view_render_event('bagisto.shop.customers.account.addresses.list.before', ['addresses' => $addresses]) !!}

            <div class="grid grid-cols-2 gap-5 max-lg:grid-cols-1">
                @foreach ($addresses as $address)
                    <div class="relative rounded-[22px] border-[1.5px] border-[#f2d7df] bg-white p-5 shadow-[0_6px_20px_rgba(237,110,152,0.04)] transition-all hover:border-[#e7cf9a] hover:shadow-[0_10px_28px_rgba(237,110,152,0.1)]">
                        <div class="flex items-start justify-between border-b border-[#fae8ef] pb-3.5">
                            <div class="flex items-center gap-2">
                                <span class="text-lg text-[#d95d86]">📍</span>
                                <div>
                                    <p class="font-['Playfair_Display'] text-[16px] font-bold text-[#3f2b2d]" v-pre>
                                        {{ $address->first_name }} {{ $address->last_name }}
                                    </p>

                                    @if ($address->company_name)
                                        <p class="text-xs font-semibold text-[#7c6770]">
                                            ({{ $address->company_name }})
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-2.5">
                                @if ($address->default_address)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-[#fff5f8] border border-[#e7cf9a] px-3 py-1 font-['Plus_Jakarta_Sans'] text-xs font-bold text-[#d95d86] shadow-sm">
                                        ★ @lang('shop::app.customers.account.addresses.index.default-address')
                                    </span>
                                @endif

                                <!-- Dropdown Actions -->
                                <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                                    <x-slot:toggle>
                                        <button
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#fff4f8] text-[#d95d86] border border-[#fae8ef] transition-all hover:bg-[#ffeaf2] cursor-pointer"
                                            aria-label="More Options"
                                        >
                                            <span class="icon-more text-xl"></span>
                                        </button>
                                    </x-slot>

                                    <x-slot:menu class="!py-2 rounded-2xl border-[1.5px] border-[#f2d7df] shadow-lg">
                                        <x-shop::dropdown.menu.item>
                                            <a
                                                href="{{ route('shop.customers.account.addresses.edit', $address->id) }}"
                                                class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-[#3f2b2d] hover:text-[#d95d86] hover:bg-[#fff4f8] rounded-xl"
                                            >
                                                <span>✏️</span>
                                                <span>@lang('shop::app.customers.account.addresses.index.edit')</span>
                                            </a>
                                        </x-shop::dropdown.menu.item>

                                        <x-shop::dropdown.menu.item>
                                            <form
                                                method="POST"
                                                ref="addressDelete_{{ $address->id }}"
                                                action="{{ route('shop.customers.account.addresses.delete', $address->id) }}"
                                            >
                                                @method('DELETE')
                                                @csrf
                                            </form>

                                            <a
                                                href="javascript:void(0);"
                                                class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-rose-500 hover:bg-[#fff0f4] rounded-xl"
                                                @click="$emitter.emit('open-confirm-modal', {
                                                    message: 'Are you sure you want to delete this address?',
                                                    agree: () => {
                                                        $refs['addressDelete_{{ $address->id }}'].submit()
                                                    }
                                                })"
                                            >
                                                <span>🗑️</span>
                                                <span>@lang('shop::app.customers.account.addresses.index.delete')</span>
                                            </a>
                                        </x-shop::dropdown.menu.item>

                                        @if (! $address->default_address)
                                            <x-shop::dropdown.menu.item>
                                                <form
                                                    method="POST"
                                                    ref="setAsDefault_{{ $address->id }}"
                                                    action="{{ route('shop.customers.account.addresses.update.default', $address->id) }}"
                                                >
                                                    @method('PATCH')
                                                    @csrf
                                                </form>

                                                <a
                                                    href="javascript:void(0);"
                                                    class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-[#3f2b2d] hover:text-[#d95d86] hover:bg-[#fff4f8] rounded-xl"
                                                    @click="$emitter.emit('open-confirm-modal', {
                                                        message: 'Set this address as your default shipping address?',
                                                        agree: () => {
                                                            $refs['setAsDefault_{{ $address->id }}'].submit()
                                                        }
                                                    })"
                                                >
                                                    <span>⭐</span>
                                                    <span>@lang('shop::app.customers.account.addresses.index.set-as-default')</span>
                                                </a>
                                            </x-shop::dropdown.menu.item>
                                        @endif
                                    </x-slot>
                                </x-shop::dropdown>
                            </div>
                        </div>

                        <!-- Address String -->
                        <div class="mt-3.5 space-y-1 text-sm font-semibold text-[#3f2b2d]" v-pre>
                            <p class="leading-relaxed">{{ $address->address }}</p>
                            <p class="text-[#7c6770]">{{ $address->city }}, {{ $address->state }} {{ $address->postcode }}</p>
                            <p class="text-[#7c6770]">{{ core()->country_name($address->country) }}</p>
                            @if ($address->phone)
                                <p class="pt-1.5 text-xs font-bold text-[#d95d86]">
                                    📞 {{ $address->phone }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {!! view_render_event('bagisto.shop.customers.account.addresses.list.after', ['addresses' => $addresses]) !!}

        @else
            <!-- Address Empty Page -->
            <div class="grid items-center w-full py-16 m-auto text-center place-content-center justify-items-center">
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[#fff0f5] shadow-inner mb-4 border border-[#f2d7df]">
                    <span class="text-4xl">📍</span>
                </div>

                <h3 class="font-['Playfair_Display'] text-2xl font-bold text-[#3f2b2d] mb-1">
                    @lang('shop::app.customers.account.addresses.index.empty-address')
                </h3>

                <p class="text-sm font-semibold text-[#7c6770] mb-6 max-w-sm">
                    You haven't saved any addresses yet. Add your primary shipping address for faster checkouts!
                </p>

                <a
                    href="{{ route('shop.customers.account.addresses.create') }}"
                    class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#d95d86] !text-white !border-transparent px-8 py-3 text-sm shadow-md"
                >
                    <span>+</span>
                    <span>@lang('shop::app.customers.account.addresses.index.add-address')</span>
                </a>
            </div>
        @endif
    </div>
</x-shop::layouts.account>
