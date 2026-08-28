@php
    $customer = auth()->guard('customer')->user();
    $ordersCount = $customer ? $customer->orders()->count() : 0;
    $wishlistCount = $customer ? $customer->wishlist_items()->count() : 0;
    $points = 860;
@endphp

<aside class="kb-dash-sidebar-card">
    <!-- Avatar + Greeting Header -->
    <div class="kb-dash-user-head">
        <div class="kb-dash-avatar-wrap">
            <div class="kb-dash-avatar-ring">
                @if ($customer && $customer->image_url)
                    <img
                        src="{{ $customer->image_url }}"
                        class="kb-dash-avatar-img"
                        alt="{{ $customer->first_name }}"
                    >
                @else
                    <!-- Default Kawaii Bunny Avatar matching mockup 1:1 -->
                    <div class="kb-dash-avatar-img flex items-center justify-center bg-[#fff0f5] overflow-hidden">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-full h-full p-1">
                            <circle cx="50" cy="50" r="48" fill="#fff5f8"/>
                            <ellipse cx="38" cy="24" rx="8" ry="20" fill="#ffffff" stroke="#e8a8bd" stroke-width="2" transform="rotate(-8 38 24)"/>
                            <ellipse cx="38" cy="24" rx="4" ry="14" fill="#ffd5e3" transform="rotate(-8 38 24)"/>
                            <ellipse cx="62" cy="24" rx="8" ry="20" fill="#ffffff" stroke="#e8a8bd" stroke-width="2" transform="rotate(8 62 24)"/>
                            <ellipse cx="62" cy="24" rx="4" ry="14" fill="#ffd5e3" transform="rotate(8 62 24)"/>
                            <!-- Head Bow -->
                            <path d="M58 26 C53 20 48 24 52 29 Z" fill="#ff8cb2"/>
                            <path d="M64 26 C69 20 74 24 70 29 Z" fill="#ff8cb2"/>
                            <circle cx="61" cy="27" r="3" fill="#ed5e90"/>
                            <!-- Head -->
                            <circle cx="50" cy="58" r="28" fill="#ffffff" stroke="#e8a8bd" stroke-width="2"/>
                            <circle cx="41" cy="55" r="3" fill="#452e37"/>
                            <circle cx="40" cy="53.5" r="1.2" fill="#ffffff"/>
                            <circle cx="59" cy="55" r="3" fill="#452e37"/>
                            <circle cx="58" cy="53.5" r="1.2" fill="#ffffff"/>
                            <ellipse cx="36" cy="62" rx="4.5" ry="2.5" fill="#ff9db9" opacity="0.8"/>
                            <ellipse cx="64" cy="62" rx="4.5" ry="2.5" fill="#ff9db9" opacity="0.8"/>
                            <circle cx="50" cy="60" r="1.8" fill="#f55a8c"/>
                            <path d="M47 62 Q50 65 53 62" fill="none" stroke="#452e37" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="kb-dash-user-info" v-pre>
            <div class="kb-dash-user-name">
                <span>Hello, {{ $customer ? $customer->first_name : 'Guest' }}!</span>
                <span class="sparkle">✨</span>
            </div>

            <div class="kb-dash-user-email">
                {{ $customer ? $customer->email : '' }}
            </div>

            <div class="kb-dash-member-chip">
                <span>👑</span>
                <span>Kawaii Club Member</span>
            </div>
        </div>
    </div>

    <!-- Stats Strip -->
    <div class="kb-dash-stats-strip">
        <div class="kb-dash-stat-item">
            <div class="kb-dash-stat-val">
                <span class="icon">⭐</span>
                <span>{{ $points }}</span>
            </div>
            <div class="kb-dash-stat-lbl">Points</div>
        </div>

        <div class="kb-dash-stat-item">
            <div class="kb-dash-stat-val">
                <span class="icon" style="color:#d95d86;">🛍️</span>
                <span>{{ $ordersCount }}</span>
            </div>
            <div class="kb-dash-stat-lbl">Orders</div>
        </div>

        <div class="kb-dash-stat-item">
            <div class="kb-dash-stat-val">
                <span class="icon" style="color:#ef7ca5;">🤍</span>
                <span>{{ $wishlistCount }}</span>
            </div>
            <div class="kb-dash-stat-lbl">Wishlist</div>
        </div>
    </div>

    <!-- ACCOUNT Navigation Section -->
    <div class="kb-dash-side-heading">
        Account
    </div>

    <nav class="kb-dash-nav-list" aria-label="Customer Account Navigation">
        <!-- Profile -->
        <a
            href="{{ route('shop.customers.account.profile.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.profile*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">👤</span>
                <span>@lang('shop::app.customers.account.profile.index.title')</span>
            </div>
            @if (request()->routeIs('shop.customers.account.profile*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- Orders -->
        <a
            href="{{ route('shop.customers.account.orders.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.orders*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">🛍️</span>
                <span>@lang('shop::app.customers.account.orders.title')</span>
            </div>
            @if (request()->routeIs('shop.customers.account.orders*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- Address Book -->
        <a
            href="{{ route('shop.customers.account.addresses.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.addresses*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">📍</span>
                <span>Address Book</span>
            </div>
            @if (request()->routeIs('shop.customers.account.addresses*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- Wishlist -->
        <a
            href="{{ route('shop.customers.account.wishlist.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.wishlist*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">🤍</span>
                <span>@lang('shop::app.customers.account.wishlist.page-title')</span>
            </div>
            @if (request()->routeIs('shop.customers.account.wishlist*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- Reviews -->
        <a
            href="{{ route('shop.customers.account.reviews.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.reviews*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">⭐</span>
                <span>@lang('shop::app.customers.account.reviews.title')</span>
            </div>
            @if (request()->routeIs('shop.customers.account.reviews*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- Downloadable Products -->
        <a
            href="{{ route('shop.customers.account.downloadable_products.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.downloadable_products*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">☁️</span>
                <span>@lang('shop::app.customers.account.downloadable-products.name')</span>
            </div>
            @if (request()->routeIs('shop.customers.account.downloadable_products*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- GDPR Requests -->
        <a
            href="{{ route('shop.customers.account.gdpr.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.gdpr*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">🛡️</span>
                <span>@lang('shop::app.customers.account.gdpr.index.title')</span>
            </div>
            @if (request()->routeIs('shop.customers.account.gdpr*'))
                <span class="active-dot">✦</span>
            @endif
        </a>

        <!-- RMA -->
        <a
            href="{{ route('shop.customers.account.rma.index') }}"
            class="kb-dash-nav-item {{ request()->routeIs('shop.customers.account.rma*') ? 'active' : '' }}"
        >
            <div class="kb-dash-nav-item-left">
                <span class="nav-icon">🔄</span>
                <span>RMA</span>
            </div>
            @if (request()->routeIs('shop.customers.account.rma*'))
                <span class="active-dot">✦</span>
            @endif
        </a>
    </nav>

    <!-- QUICK ACTIONS Section -->
    <div class="kb-dash-side-heading" style="margin-top: 20px;">
        Quick Actions
    </div>

    <div class="kb-dash-quick-actions">
        <!-- Track Order -->
        <a href="{{ route('shop.customers.account.orders.index') }}" class="kb-dash-qa-card">
            <span class="qa-icon">📦</span>
            <div class="kb-dash-qa-info">
                <div class="kb-dash-qa-title">Track Order</div>
                <div class="kb-dash-qa-sub">Check order status &gt;</div>
            </div>
        </a>

        <!-- View Wishlist -->
        <a href="{{ route('shop.customers.account.wishlist.index') }}" class="kb-dash-qa-card">
            <span class="qa-icon" style="color:#d95d86;">🤍</span>
            <div class="kb-dash-qa-info">
                <div class="kb-dash-qa-title">View Wishlist</div>
                <div class="kb-dash-qa-sub">See your saved items &gt;</div>
            </div>
        </a>
    </div>

    <!-- Logout Button -->
    <div class="pt-1">
        <x-shop::form
            method="DELETE"
            action="{{ route('shop.customer.session.destroy') }}"
            id="customerSidebarLogout"
        />

        <button
            type="button"
            onclick="document.getElementById('customerSidebarLogout').submit();"
            class="kb-dash-logout-btn"
        >
            <span>⏻</span>
            <span>@lang('shop::app.components.layouts.header.desktop.bottom.logout')</span>
        </button>
    </div>
</aside>