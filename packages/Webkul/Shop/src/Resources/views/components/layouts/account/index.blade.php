<x-shop::layouts :has-feature="false">
    <!-- Page Title -->
    <x-slot:title>
        {{ $title ?? '' }}
    </x-slot>

    <!-- Account Dashboard Shell -->
    <div class="kb-account-shell">
        <!-- Floating Kawaii Symbols -->
        <span class="kb-acc-floating-symbol s1">♡</span>
        <span class="kb-acc-floating-symbol s2">♥</span>
        <span class="kb-acc-floating-symbol s3">✦</span>
        <span class="kb-acc-floating-symbol s4">✨</span>

        <!-- Bottom Floral Corner Decorations -->
        <div class="kb-dash-decor-corner bottom-left" aria-hidden="true">
            <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.6">
                    <circle cx="45" cy="115" r="28" fill="#ffeaf0" stroke="#fbd0de" stroke-width="1"/>
                    <circle cx="45" cy="115" r="7" fill="#f79ab8"/>
                    <circle cx="45" cy="115" r="3.5" fill="#fcd98c"/>
                    <ellipse cx="20" cy="80" rx="9" ry="5" fill="#ffd9e5" transform="rotate(-20 20 80)"/>
                    <ellipse cx="85" cy="130" rx="10" ry="5" fill="#ffe2ec" transform="rotate(30 85 130)"/>
                    <ellipse cx="65" cy="65" rx="7" ry="4" fill="#ffd9e5" transform="rotate(45 65 65)"/>
                </g>
            </svg>
        </div>

        <div class="kb-dash-decor-corner bottom-right" aria-hidden="true">
            <svg viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.65">
                    <circle cx="115" cy="115" r="32" fill="#ffeaf0" stroke="#fbd0de" stroke-width="1"/>
                    <circle cx="115" cy="115" r="8" fill="#f79ab8"/>
                    <circle cx="115" cy="115" r="4" fill="#fcd98c"/>
                    <circle cx="55" cy="135" r="16" fill="#fff0f5" stroke="#fcd4e0" stroke-width="0.8"/>
                    <circle cx="55" cy="135" r="4" fill="#f79ab8"/>
                    <ellipse cx="140" cy="80" rx="9" ry="5" fill="#ffd9e5" transform="rotate(20 140 80)"/>
                    <ellipse cx="75" cy="85" rx="10" ry="5" fill="#ffe2ec" transform="rotate(-30 75 85)"/>
                    <ellipse cx="95" cy="55" rx="7" ry="4" fill="#ffd9e5" transform="rotate(-45 95 55)"/>
                </g>
            </svg>
        </div>

        <div class="kb-account-container">
            <!-- Breadcrumbs Line -->
            <div class="kb-dash-breadcrumbs">
                <a href="{{ route('shop.home.index') }}">Home</a>
                <span class="sep">&gt;</span>
                <a href="{{ route('shop.customers.account.profile.index') }}">My Account</a>
                <span class="sep">&gt;</span>
                <span class="current">{{ $title ?? 'Dashboard' }}</span>
            </div>

            <!-- Two-Column Layout (Sidebar + Main Content) -->
            <div class="kb-dash-layout">
                {{ $slot }}
            </div>

            <!-- Bottom Sweet Appreciation Strip -->
            <div class="kb-dash-bottom-strip">
                <span class="bow-icon">🎀</span>
                <span>Thank you for being part of Kawaii Blessings. You make our world sweeter!</span>
                <span>💕</span>
            </div>
        </div>
    </div>
</x-shop::layouts>
