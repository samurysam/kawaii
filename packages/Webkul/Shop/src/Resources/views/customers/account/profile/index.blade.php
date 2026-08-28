<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.index.title')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card (1:1 Reference Mockup Replica) -->
    <div class="kb-dash-main-card">
        <!-- Top Right Subtle Sparkles -->
        <span class="absolute top-6 right-8 text-[#d8b46b] text-base select-none pointer-events-none" aria-hidden="true">✨</span>

        <!-- Bottom Right Delicate Sakura Blossom Decor inside Card -->
        <div class="absolute bottom-3 right-4 pointer-events-none select-none opacity-50 z-0" aria-hidden="true">
            <svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <circle cx="85" cy="85" r="24" fill="#ffeaf0" stroke="#fbd0de" stroke-width="1"/>
                    <circle cx="85" cy="85" r="6" fill="#f79ab8"/>
                    <circle cx="85" cy="85" r="3" fill="#fcd98c"/>
                    <circle cx="35" cy="95" r="14" fill="#fff0f5" stroke="#fcd4e0" stroke-width="0.8"/>
                    <circle cx="35" cy="95" r="3.5" fill="#f79ab8"/>
                    <ellipse cx="60" cy="55" rx="7" ry="4" fill="#ffd9e5" transform="rotate(-30 60 55)"/>
                    <ellipse cx="105" cy="50" rx="6" ry="3.5" fill="#ffe2ec" transform="rotate(25 105 50)"/>
                </g>
            </svg>
        </div>

        <div class="relative z-10">
            <!-- Page Header -->
            <div class="kb-dash-card-head">
                <div class="kb-dash-card-head-left">
                    <div class="kb-dash-card-icon-box">
                        <span>👤</span>
                    </div>

                    <div>
                        <h1 class="kb-dash-card-title">
                            @lang('shop::app.customers.account.profile.index.title')
                        </h1>
                        <p class="kb-dash-card-subtitle">
                            Manage your personal details and account settings
                        </p>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.before') !!}

                <a
                    href="{{ route('shop.customers.account.profile.edit') }}"
                    class="kb-dash-head-btn"
                >
                    <span>✏️</span>
                    <span>@lang('shop::app.customers.account.profile.index.edit')</span>
                </a>

                {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.after') !!}
            </div>

            <!-- SECTION 1: PERSONAL INFORMATION -->
            <div class="kb-dash-sec-head">
                <h2 class="kb-dash-sec-title">
                    <span>🌾</span>
                    <span>Personal Information</span>
                </h2>
                <p class="kb-dash-sec-subtitle">
                    Your personal details are used to personalize your experience.
                </p>
            </div>

            <div class="kb-dash-info-list">
                <!-- First Name -->
                {!! view_render_event('bagisto.shop.customers.account.profile.first_name.before') !!}
                <div class="kb-dash-info-row">
                    <div class="kb-dash-info-left">
                        <span class="kb-dash-info-icon">👤</span>
                        <span class="kb-dash-info-label">@lang('shop::app.customers.account.profile.index.first-name')</span>
                    </div>
                    <span class="kb-dash-info-value" v-pre>{{ $customer->first_name }}</span>
                </div>
                {!! view_render_event('bagisto.shop.customers.account.profile.first_name.after') !!}

                <!-- Last Name -->
                {!! view_render_event('bagisto.shop.customers.account.profile.last_name.before') !!}
                <div class="kb-dash-info-row">
                    <div class="kb-dash-info-left">
                        <span class="kb-dash-info-icon">👤</span>
                        <span class="kb-dash-info-label">@lang('shop::app.customers.account.profile.index.last-name')</span>
                    </div>
                    <span class="kb-dash-info-value" v-pre>{{ $customer->last_name }}</span>
                </div>
                {!! view_render_event('bagisto.shop.customers.account.profile.last_name.after') !!}

                <!-- Gender -->
                {!! view_render_event('bagisto.shop.customers.account.profile.gender.before') !!}
                <div class="kb-dash-info-row">
                    <div class="kb-dash-info-left">
                        <span class="kb-dash-info-icon">⚧️</span>
                        <span class="kb-dash-info-label">@lang('shop::app.customers.account.profile.index.gender')</span>
                    </div>
                    <span class="kb-dash-info-value" v-pre>
                        @if ($customer->gender)
                            {{ strtolower($customer->gender) === 'm' ? 'Male' : (strtolower($customer->gender) === 'f' ? 'Female' : 'Other') }}
                        @else
                            Prefer not to say
                        @endif
                    </span>
                </div>
                {!! view_render_event('bagisto.shop.customers.account.profile.gender.after') !!}

                <!-- Date of Birth -->
                {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.before') !!}
                <div class="kb-dash-info-row">
                    <div class="kb-dash-info-left">
                        <span class="kb-dash-info-icon">🎂</span>
                        <span class="kb-dash-info-label">@lang('shop::app.customers.account.profile.index.dob')</span>
                    </div>
                    <span class="kb-dash-info-value" v-pre>{{ $customer->date_of_birth ? core()->formatDate($customer->date_of_birth, 'Y-m-d') : '-' }}</span>
                </div>
                {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.after') !!}

                <!-- Email Address -->
                {!! view_render_event('bagisto.shop.customers.account.profile.email.before') !!}
                <div class="kb-dash-info-row">
                    <div class="kb-dash-info-left">
                        <span class="kb-dash-info-icon">✉️</span>
                        <span class="kb-dash-info-label">@lang('shop::app.customers.account.profile.index.email')</span>
                    </div>
                    <span class="kb-dash-info-value" v-pre>{{ $customer->email }}</span>
                </div>
                {!! view_render_event('bagisto.shop.customers.account.profile.email.after') !!}
            </div>

            <!-- SECTION 2: QUICK ACCESS -->
            <div class="kb-dash-sec-head" style="margin-top: 30px;">
                <h2 class="kb-dash-sec-title">
                    <span>🌾</span>
                    <span>Quick Access</span>
                </h2>
                <p class="kb-dash-sec-subtitle">
                    Jump to your most used account features.
                </p>
            </div>

            <div class="kb-dash-quick-grid">
                <!-- My Orders -->
                <a href="{{ route('shop.customers.account.orders.index') }}" class="kb-dash-card-link">
                    <div class="kb-dash-card-link-content">
                        <span class="kb-dash-card-link-icon">🛍️</span>
                        <div>
                            <div class="kb-dash-card-link-title">My Orders</div>
                            <div class="kb-dash-card-link-sub">View &amp; track orders</div>
                        </div>
                    </div>
                    <span class="kb-dash-card-link-arrow">&gt;</span>
                </a>

                <!-- Wishlist -->
                <a href="{{ route('shop.customers.account.wishlist.index') }}" class="kb-dash-card-link">
                    <div class="kb-dash-card-link-content">
                        <span class="kb-dash-card-link-icon" style="color:#ef7ca5;">🤍</span>
                        <div>
                            <div class="kb-dash-card-link-title">Wishlist</div>
                            <div class="kb-dash-card-link-sub">Saved items</div>
                        </div>
                    </div>
                    <span class="kb-dash-card-link-arrow">&gt;</span>
                </a>

                <!-- Addresses -->
                <a href="{{ route('shop.customers.account.addresses.index') }}" class="kb-dash-card-link">
                    <div class="kb-dash-card-link-content">
                        <span class="kb-dash-card-link-icon">📍</span>
                        <div>
                            <div class="kb-dash-card-link-title">Addresses</div>
                            <div class="kb-dash-card-link-sub">Manage addresses</div>
                        </div>
                    </div>
                    <span class="kb-dash-card-link-arrow">&gt;</span>
                </a>

                <!-- Reviews -->
                <a href="{{ route('shop.customers.account.reviews.index') }}" class="kb-dash-card-link">
                    <div class="kb-dash-card-link-content">
                        <span class="kb-dash-card-link-icon" style="color:#d8b46b;">⭐</span>
                        <div>
                            <div class="kb-dash-card-link-title">Reviews</div>
                            <div class="kb-dash-card-link-sub">Your reviews</div>
                        </div>
                    </div>
                    <span class="kb-dash-card-link-arrow">&gt;</span>
                </a>
            </div>

            <!-- SECTION 3: DANGER ZONE -->
            <div class="kb-dash-danger-panel">
                <div class="kb-dash-danger-left">
                    <div class="kb-dash-danger-icon-box">
                        <span>🛡️</span>
                    </div>

                    <div>
                        <h3 class="kb-dash-danger-title">
                            Danger Zone
                        </h3>
                        <p class="kb-dash-danger-sub">
                            Once you delete your account, there is no going back.
                        </p>
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.customers.account.profile.delete.before') !!}

                <!-- Profile Delete Modal -->
                <x-shop::form action="{{ route('shop.customers.account.profile.destroy') }}">
                    <x-shop::modal>
                        <x-slot:toggle>
                            <button
                                type="button"
                                class="kb-dash-danger-btn"
                            >
                                <span>🗑️</span>
                                <span>@lang('shop::app.customers.account.profile.index.delete-profile')</span>
                            </button>
                        </x-slot>

                        <x-slot:header>
                            <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#3f2b2d]">
                                @lang('shop::app.customers.account.profile.index.enter-password')
                            </h2>
                        </x-slot>

                        <x-slot:content>
                            <p class="mb-4 text-sm font-semibold text-[#7c6770]">
                                For your security, please confirm your password to permanently delete your account.
                            </p>

                            <x-shop::form.control-group class="!mb-0">
                                <x-shop::form.control-group.control
                                    type="password"
                                    name="password"
                                    class="px-5 py-3 rounded-2xl border-[1.5px] border-[#ebd3df] w-full"
                                    rules="required"
                                    placeholder="Enter your current password"
                                />

                                <x-shop::form.control-group.error
                                    class="text-left mt-1 text-xs text-rose-500 font-bold"
                                    control-name="password"
                                />
                            </x-shop::form.control-group>
                        </x-slot>

                        <!-- Modal Footer -->
                        <x-slot:footer>
                            <button
                                type="submit"
                                class="kb-dash-head-btn !bg-gradient-to-r !from-[#f2628e] !to-[#c82458] !text-white !border-transparent px-8 py-3"
                            >
                                @lang('shop::app.customers.account.profile.index.delete')
                            </button>
                        </x-slot>
                    </x-shop::modal>
                </x-shop::form>

                {!! view_render_event('bagisto.shop.customers.account.profile.delete.after') !!}
            </div>
        </div>
    </div>
</x-shop::layouts.account>
