{!! view_render_event('bagisto.shop.layout.header.before') !!}

@php
    $channel = core()->getCurrentChannel();
    $logoUrl = $channel->logo_url ?? bagisto_asset('images/logo.svg');
    $logoAlt = $channel->logo_alt ?: config('app.name');
    $currentPath = request()->path();
    $isHome = request()->routeIs('shop.home.index') || $currentPath === '/' || $currentPath === '';
    $isAboutUs = request()->is('page/about-us*') || request()->is('about-us*');
    $isContactUs = request()->is('page/contact-us*') || request()->is('contact-us*');
    $isStore = request()->is('search*') || request()->is('categories*') || request()->is('bag-charms*') || request()->is('plushies*') || request()->is('blind-box*');
    $isAccount = request()->is('customer/account/profile*') || (request()->is('customer*') && !request()->is('customer/account/wishlist*'));
    $isWishlist = request()->is('customer/account/wishlist*') || request()->is('wishlist*');
    $isCart = request()->is('checkout/cart*') || request()->is('cart*');

    $offerTitle = core()->getConfigData('general.content.header_offer.title') ?: 'Free UAE Shipping on orders AED 250+';
    $offerHot = 'AED 250+';
    if (preg_match('/(AED\s*\d+\+?|\d+\s*AED\+?)/i', $offerTitle, $matches)) {
        $offerHot = $matches[0];
        $offerTitle = trim(str_replace($offerHot, '', $offerTitle));
    } else {
        $offerTitle = 'Free UAE Shipping on orders';
    }

    $customer = auth()->guard('customer')->user();
    $wishlistCount = $customer ? $customer->wishlist_items()->count() : 0;

    $categories = \Webkul\Category\Models\Category::where('parent_id', 1)
        ->where('status', 1)
        ->orderBy('position', 'asc')
        ->get();
@endphp

<style>
:root {
  --pink: #ef6d98;
  --pink-2: #f38cad;
  --pink-3: #ffd8e5;
  --pink-soft: #fff5f8;
  --pink-softer: #fff9fb;
  --gold: #d9a84f;
  --gold-soft: #f3d59a;
  --ink: #2f2529;
  --muted: #7e6870;
  --line: #f4ccd8;
  --shadow: 0 10px 30px rgba(202,105,137,.09);
  --max: 1440px;
}

.kb-header-wrapper {
  width: min(calc(100% - 32px), var(--max));
  margin: 14px auto 20px;
}

.kb-header {
  background: rgba(255, 255, 255, 0.98);
  border: 1px solid var(--line);
  border-radius: 20px;
  box-shadow: var(--shadow);
  position: relative;
  z-index: 30;
}

/* =========================
   DESKTOP TOP STRIP (COMPACT)
   ========================= */
.kb-topstrip {
  min-height: 38px;
  padding: 0 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  background: linear-gradient(90deg, #fff8fa, #fff4f7);
  border-bottom: 1px solid #f5dce4;
  border-top-left-radius: 19px;
  border-top-right-radius: 19px;
  color: #67545c;
  font-size: 12.5px;
  font-weight: 700;
}
.kb-top-left, .kb-top-right {
  display: flex;
  align-items: center;
  gap: 20px;
}
.kb-top-item {
  display: flex;
  align-items: center;
  gap: 7px;
  white-space: nowrap;
}
.kb-top-item .hot {
  color: var(--pink);
}
.kb-top-divider {
  width: 1px;
  height: 18px;
  background: #efb8ca;
}
.kb-top-flag {
  font-size: 16px;
  line-height: 1;
}

/* =========================
   DESKTOP MAIN HEADER (COMPACT SINGLE ROW)
   Logo | Nav Links | Search | Actions
   ========================= */
.kb-mainrow {
  min-height: 76px;
  padding: 10px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  border-bottom-left-radius: 19px;
  border-bottom-right-radius: 19px;
}

/* 1. Logo */
.kb-logo-link {
  display: flex;
  align-items: center;
  flex-shrink: 0;
  text-decoration: none;
  transition: transform .22s ease;
}
.kb-logo-link:hover {
  transform: scale(1.02);
}
.kb-logo {
  height: 48px;
  max-width: 180px;
  object-fit: contain;
}

/* 2. Nav Links */
.kb-nav-links {
  display: flex;
  align-items: center;
  gap: 22px;
  flex-shrink: 0;
}
.kb-nav-link {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 6px 2px;
  color: #33292d;
  font-size: 14.5px;
  font-weight: 700;
  white-space: nowrap;
  transition: color .2s ease;
  text-decoration: none;
}
.kb-nav-link::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 2.5px;
  border-radius: 999px;
  background: linear-gradient(90deg, #ef7099, #f0b3c6);
  transform: scaleX(0);
  transition: transform .2s ease;
}
.kb-nav-link:hover, .kb-nav-link.active {
  color: var(--pink);
}
.kb-nav-link:hover::after, .kb-nav-link.active::after {
  transform: scaleX(1);
}
.kb-nav-link.active::before {
  content: "✦";
  color: var(--gold);
  font-size: 9px;
}

/* Store Dropdown */
.kb-store-item {
  position: relative;
}
.kb-store-dropdown {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%) translateY(6px);
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 16px;
  box-shadow: 0 14px 34px rgba(202,105,137,.14);
  padding: 10px 14px;
  min-width: 200px;
  display: none;
  z-index: 50;
}
.kb-store-item:hover .kb-store-dropdown {
  display: block;
}
.kb-store-drop-link {
  display: block;
  padding: 7px 10px;
  border-radius: 8px;
  color: #49353c;
  font-size: 13.5px;
  font-weight: 600;
  transition: background .18s, color .18s;
  white-space: nowrap;
  text-decoration: none;
}
.kb-store-drop-link:hover {
  background: #fff1f6;
  color: var(--pink);
}

/* 3. Search Field Bar */
.kb-search {
  flex: 1;
  max-width: 320px;
  min-width: 180px;
  height: 44px;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 0 12px 0 18px;
  border: 1.5px solid #f1c5d2;
  border-radius: 999px;
  background: #fffafb;
  transition: all .22s ease;
}
.kb-search:focus-within {
  border-color: #eaa7ba;
  box-shadow: 0 6px 18px rgba(235,116,154,.10);
  background: #fff;
}
.kb-search input {
  flex: 1;
  min-width: 0;
  border: 0;
  outline: 0;
  background: transparent;
  color: #4b3940;
  font-size: 13.5px;
  font-family: inherit;
}
.kb-search input::placeholder {
  color: #9b868d;
}
.kb-search button {
  width: 28px;
  height: 28px;
  border: 0;
  background: transparent;
  display: grid;
  place-items: center;
  color: var(--pink);
  padding: 0;
  cursor: pointer;
  transition: transform .2s ease;
}
.kb-search button:hover {
  transform: scale(1.1);
}
.kb-search svg {
  width: 20px;
  height: 20px;
  stroke: currentColor;
  stroke-width: 2;
  fill: none;
}

/* 4. Actions: Wishlist | Account | Cart | (Signup/Signin) */
.kb-actions {
  display: flex;
  align-items: center;
  gap: 18px;
  flex-shrink: 0;
}
.kb-action {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  color: #33282c;
  font-size: 11px;
  font-weight: 700;
  transition: all .2s ease;
  text-decoration: none;
  cursor: pointer;
  background: none;
  border: none;
  padding: 0;
}
.kb-action:hover {
  color: var(--pink);
  transform: translateY(-1px);
}
.kb-action svg {
  width: 24px;
  height: 24px;
  stroke: #a86576;
  stroke-width: 1.7;
  fill: none;
  transition: stroke .2s ease;
}
.kb-action:hover svg {
  stroke: var(--pink);
}
.kb-badge {
  position: absolute;
  top: -5px;
  right: -5px;
  min-width: 18px;
  height: 18px;
  padding: 0 4px;
  border-radius: 999px;
  display: grid;
  place-items: center;
  background: linear-gradient(180deg, #f58aab, #e85f90);
  color: #fff;
  font-size: 9.5px;
  font-weight: 900;
  border: 1.5px solid #fff;
  box-shadow: 0 3px 8px rgba(231,95,143,.2);
  line-height: 1;
}

/* Sign In / Sign Up Pill Button */
.kb-auth-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 7px 14px;
  border-radius: 999px;
  background: linear-gradient(135deg, #fff1f6, #ffe6ef);
  border: 1px solid #f2bfd0;
  color: #d85483;
  font-size: 12.5px;
  font-weight: 700;
  text-decoration: none;
  transition: all .2s ease;
  white-space: nowrap;
}
.kb-auth-btn:hover {
  background: linear-gradient(135deg, #f58aab, #ed6e98);
  color: #fff;
  border-color: transparent;
  box-shadow: 0 4px 12px rgba(237,110,152,.25);
  transform: translateY(-1px);
}

/* =========================
   MOBILE HEADER
   ========================= */
.kb-mobile {
  display: none;
}
.kb-mobile-row {
  min-height: 72px;
  padding: 10px 16px;
  display: grid;
  grid-template-columns: 44px 1fr 44px;
  align-items: center;
  gap: 12px;
}
.kb-icon-btn {
  width: 42px;
  height: 42px;
  border: 0;
  background: transparent;
  display: grid;
  place-items: center;
  color: var(--pink);
  padding: 0;
  cursor: pointer;
  text-decoration: none;
}
.kb-icon-btn svg {
  width: 28px;
  height: 28px;
  fill: none;
  stroke: currentColor;
  stroke-width: 1.8;
}
.kb-mobile-logo {
  height: 42px;
  max-width: 160px;
  object-fit: contain;
  justify-self: center;
}
.kb-mobile-cart {
  position: relative;
}
.kb-mobile-cart .kb-badge {
  top: 0;
  right: -1px;
}

/* =========================
   MOBILE DRAWER
   Menu items: Home, About Us, Store, Contact Us, Wishlist, Account, Cart, Sign Up
   ========================= */
.kb-overlay {
  position: fixed;
  inset: 0;
  z-index: 99990;
  background: rgba(70, 45, 54, 0.28);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  opacity: 0;
  pointer-events: none;
  transition: opacity .25s ease;
}
.kb-overlay.show {
  opacity: 1 !important;
  pointer-events: auto !important;
}

.kb-drawer {
  position: fixed;
  z-index: 99999;
  top: 0;
  right: 0;
  width: min(88vw, 380px);
  height: 100dvh;
  background: #fff;
  box-shadow: -20px 0 60px rgba(165, 88, 116, 0.25);
  transform: translateX(104%);
  transition: transform .34s cubic-bezier(.2, .8, .2, 1);
  display: flex;
  flex-direction: column;
}
.kb-drawer.open {
  transform: translateX(0) !important;
}

.kb-drawer-handle {
  width: 60px;
  height: 4px;
  margin: 12px auto 6px;
  border-radius: 999px;
  background: linear-gradient(90deg, #f09ab6, #ea638f);
}
.kb-drawer-top {
  padding: 4px 16px 8px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.kb-close {
  width: 38px;
  height: 38px;
  display: grid;
  place-items: center;
  border: 0;
  background: transparent;
  color: var(--pink);
  cursor: pointer;
}
.kb-close svg {
  width: 24px;
  height: 24px;
  fill: none;
  stroke: currentColor;
  stroke-width: 1.8;
}

.kb-drawer-nav {
  padding: 4px 14px 14px;
  display: grid;
  gap: 3px;
  overflow-y: auto;
  flex: 1;
}
.kb-drawer-link {
  min-height: 52px;
  display: grid;
  grid-template-columns: 28px 1fr 22px;
  align-items: center;
  gap: 11px;
  padding: 0 12px;
  border-bottom: 1px solid #f6e3e8;
  border-radius: 12px;
  color: #392d31;
  font-size: 14.5px;
  font-weight: 700;
  transition: .18s ease;
  text-decoration: none;
}
.kb-drawer-link svg {
  width: 20px;
  height: 20px;
  fill: none;
  stroke: #e6789a;
  stroke-width: 1.7;
}
.kb-drawer-link .arrow {
  justify-self: end;
  color: #ed7399;
  font-size: 20px;
  font-weight: 400;
}
.kb-drawer-link:hover,
.kb-drawer-link.active {
  background: linear-gradient(90deg, #fff1f6, #fff8fa);
  color: #e96291;
}
.kb-drawer-link.active {
  border-bottom-color: transparent;
}

.kb-drawer-count {
  justify-self: end;
  min-width: 22px;
  height: 22px;
  padding: 0 5px;
  display: grid;
  place-items: center;
  border-radius: 999px;
  background: linear-gradient(180deg, #f58aab, #e85f90);
  color: #fff;
  font-size: 9.5px;
  font-weight: 900;
}

.kb-drawer-footer {
  margin-top: auto;
  min-height: 72px;
  padding: 14px 18px;
  display: flex;
  align-items: flex-end;
  justify-content: center;
  color: #e77c9e;
  font-size: 12px;
  text-align: center;
  position: relative;
  overflow: hidden;
  background: linear-gradient(180deg, #fff, #fff7fa);
  border-top: 1px solid #f5dce4;
  font-weight: 700;
}
.kb-drawer-footer::before {
  content: "";
  position: absolute;
  left: -4%;
  right: -4%;
  top: -24px;
  height: 48px;
  background:
    radial-gradient(circle at 8% 100%, #fff7fa 0 24px, transparent 25px),
    radial-gradient(circle at 27% 100%, #fff7fa 0 24px, transparent 25px),
    radial-gradient(circle at 47% 100%, #fff7fa 0 24px, transparent 25px),
    radial-gradient(circle at 67% 100%, #fff7fa 0 24px, transparent 25px),
    radial-gradient(circle at 88% 100%, #fff7fa 0 24px, transparent 25px);
}
.kb-drawer-footer span {
  color: var(--gold);
  margin: 0 4px;
}

/* =========================
   RESPONSIVENESS
   ========================= */
@media(max-width: 1120px) {
  .kb-mainrow {
    padding-inline: 18px;
    gap: 14px;
  }
  .kb-nav-links { gap: 14px; }
  .kb-nav-link { font-size: 13.5px; }
  .kb-search { max-width: 220px; }
  .kb-actions { gap: 14px; }
}

@media(max-width: 890px) {
  .kb-header-wrapper {
    width: min(calc(100% - 16px), 680px);
    margin: 12px auto 20px;
  }
  .kb-topstrip, .kb-mainrow { display: none !important; }
  .kb-mobile { display: block !important; }
  .kb-header { border-radius: 18px; }
}

@media(max-width: 460px) {
  .kb-header-wrapper { width: calc(100% - 12px); }
  .kb-mobile-row {
    min-height: 66px;
    grid-template-columns: 40px 1fr 40px;
    gap: 8px;
    padding-inline: 10px;
  }
  .kb-mobile-logo { max-width: 140px; height: 36px; }
  .kb-drawer { width: min(92vw, 340px); }
}
</style>

<div class="kb-header-wrapper">
  <header class="kb-header">

    <!-- DESKTOP TOP STRIP -->
    <div class="kb-topstrip">
      <div class="kb-top-left">
        <div class="kb-top-item">
          <span aria-hidden="true">🚚</span>
          <span>{{ $offerTitle }} <span class="hot">{{ $offerHot }}</span></span>
        </div>
      </div>

      <div class="kb-top-right">
        <div class="kb-top-item">
          <span style="color:var(--gold)" aria-hidden="true">✦</span>
          <span>Authentic Products</span>
        </div>

        <span class="kb-top-divider"></span>

        <!-- Country / Currency Dropdown -->
        <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
          <x-slot:toggle>
            <div class="kb-top-item" style="cursor:pointer;" role="button" tabindex="0">
              <span class="kb-top-flag" aria-hidden="true">🇦🇪</span>
              <span>UAE ({{ core()->getCurrentCurrencyCode() }})</span>
              <span aria-hidden="true" style="font-size:10px;">⌄</span>
            </div>
          </x-slot>

          <x-slot:content class="!p-2 shadow-lg rounded-2xl border border-pink-100 min-w-[160px]">
            <div class="grid gap-1">
              @foreach (core()->getCurrentChannel()->currencies as $currency)
                <a
                  href="?currency={{ $currency->code }}"
                  class="flex items-center justify-between px-3 py-1.5 text-xs font-semibold rounded-lg hover:bg-pink-50 text-gray-700 transition"
                  style="{{ $currency->code === core()->getCurrentCurrencyCode() ? 'background:#fff1f6;color:var(--pink);' : '' }}"
                >
                  <span>{{ $currency->symbol }} {{ $currency->code }}</span>
                  @if($currency->code === core()->getCurrentCurrencyCode())
                    <span style="color:var(--gold)">✓</span>
                  @endif
                </a>
              @endforeach
            </div>
          </x-slot>
        </x-shop::dropdown>
      </div>
    </div>

    <!-- DESKTOP MAIN HEADER (COMPACT SINGLE ROW) -->
    <!-- Order: Logo | home about us store contact us | [search field bar] | wishlist account cart (Signup/Signin) -->
    <div class="kb-mainrow">
      <!-- 1. Logo -->
      <a class="kb-logo-link" href="{{ route('shop.home.index') }}" aria-label="{{ $logoAlt }} home">
        <img
          class="kb-logo"
          src="{{ $logoUrl }}"
          alt="{{ $logoAlt }}"
        >
      </a>

      <!-- 2. Nav Links: home about us store contact us -->
      <nav class="kb-nav-links" aria-label="Primary navigation">
        <a class="kb-nav-link {{ $isHome ? 'active' : '' }}" href="{{ route('shop.home.index') }}">
          Home
        </a>

        <a class="kb-nav-link {{ $isAboutUs ? 'active' : '' }}" href="{{ url('/page/about-us') }}">
          About Us
        </a>

        <!-- Store Link with Category Dropdown -->
        <div class="kb-store-item">
          <a class="kb-nav-link {{ $isStore ? 'active' : '' }}" href="{{ route('shop.search.index') }}">
            Store
            <span style="font-size:10px;margin-left:-2px;" aria-hidden="true">⌄</span>
          </a>
          <div class="kb-store-dropdown">
            <a class="kb-store-drop-link" href="{{ route('shop.search.index') }}" style="font-weight:700;color:var(--pink);border-bottom:1px solid #fce8f0;margin-bottom:4px;padding-bottom:6px;">
              🛍️ All Products
            </a>
            @foreach($categories as $cat)
              <a class="kb-store-drop-link" href="{{ route('shop.product_or_category.index', $cat->slug) }}">
                {{ $cat->name }}
              </a>
            @endforeach
          </div>
        </div>

        <a class="kb-nav-link {{ $isContactUs ? 'active' : '' }}" href="{{ url('/page/contact-us') }}">
          Contact Us
        </a>
      </nav>

      <!-- 3. Search Field Bar -->
      <form class="kb-search" action="{{ route('shop.search.index') }}" method="get" role="search">
        <input
          type="search"
          name="query"
          value="{{ request('query') }}"
          placeholder="Search kawaii treasures..."
          aria-label="Search kawaii treasures"
          required
        >
        <button type="submit" aria-label="Search">
          <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
        </button>
      </form>

      <!-- 4. Actions: wishlist account cart (Signup/Signin) -->
      <div class="kb-actions">
        <!-- Wishlist -->
        <a class="kb-action" href="{{ route('shop.customers.account.wishlist.index') }}" aria-label="Wishlist">
          @if($wishlistCount > 0)
            <span class="kb-badge">{{ $wishlistCount }}</span>
          @endif
          <svg viewBox="0 0 24 24"><path d="M20.8 4.6a5.3 5.3 0 0 0-7.5 0L12 5.9l-1.3-1.3a5.3 5.3 0 0 0-7.5 7.5L12 20.9l8.8-8.8a5.3 5.3 0 0 0 0-7.5Z"/></svg>
          <span>Wishlist</span>
        </a>

        <!-- Account Dropdown -->
        <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
          <x-slot:toggle>
            <div class="kb-action" role="button" tabindex="0">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c.8-5 4-7 8-7s7.2 2 8 7"/></svg>
              <span>Account</span>
            </div>
          </x-slot>

          @guest('customer')
            <x-slot:content class="!p-4 rounded-2xl shadow-xl border border-pink-100 min-w-[230px]">
              <p class="text-sm font-bold text-gray-800 mb-1">Welcome Cutie! 💖</p>
              <p class="text-xs text-gray-500 mb-3">Sign in to track orders & save kawaii finds.</p>
              <div class="grid gap-2">
                <a
                  href="{{ route('shop.customer.session.create') }}"
                  class="block w-full py-2 text-center text-xs font-bold text-white rounded-xl transition"
                  style="background:linear-gradient(135deg,#f58aab,#ed6e98);"
                >
                  Sign In
                </a>
                <a
                  href="{{ route('shop.customers.register.index') }}"
                  class="block w-full py-1.5 text-center text-xs font-bold rounded-xl border border-pink-300 text-pink-600 hover:bg-pink-50 transition"
                >
                  Sign Up
                </a>
              </div>
            </x-slot>
          @endguest

          @auth('customer')
            <x-slot:content class="!p-4 rounded-2xl shadow-xl border border-pink-100 min-w-[210px]">
              <p class="text-sm font-bold text-pink-600 mb-1">Hello, {{ auth()->guard('customer')->user()->first_name }}! ✨</p>
              <div class="border-t border-pink-100 my-2"></div>
              <div class="grid gap-1">
                <a class="px-3 py-1.5 text-xs font-semibold text-gray-700 rounded-lg hover:bg-pink-50 transition" href="{{ route('shop.customers.account.profile.index') }}">
                  👤 My Profile
                </a>
                <a class="px-3 py-1.5 text-xs font-semibold text-gray-700 rounded-lg hover:bg-pink-50 transition" href="{{ route('shop.customers.account.orders.index') }}">
                  📦 Orders
                </a>
                <a class="px-3 py-1.5 text-xs font-semibold text-gray-700 rounded-lg hover:bg-pink-50 transition" href="{{ route('shop.customers.account.wishlist.index') }}">
                  💖 Wishlist
                </a>
                <div class="border-t border-pink-100 my-1"></div>
                <x-shop::form method="DELETE" action="{{ route('shop.customer.session.destroy') }}" id="kbCustomerLogoutCompact" />
                <a
                  class="px-3 py-1.5 text-xs font-semibold text-red-500 rounded-lg hover:bg-red-50 transition"
                  href="{{ route('shop.customer.session.destroy') }}"
                  onclick="event.preventDefault(); document.getElementById('kbCustomerLogoutCompact').submit();"
                >
                  🚪 Logout
                </a>
              </div>
            </x-slot>
          @endauth
        </x-shop::dropdown>

        <!-- Cart Action with Live Badge -->
        <a class="kb-action" href="{{ route('shop.checkout.cart.index') }}" aria-label="Cart">
          <span class="kb-badge" id="kbCartBadgeDesk" style="display:none;">0</span>
          <svg viewBox="0 0 24 24"><path d="M5 8h14l-1 12H6Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
          <span>Cart</span>
        </a>

        <!-- Sign Up / Sign In Pill Button -->
        @guest('customer')
          <a class="kb-auth-btn" href="{{ route('shop.customers.register.index') }}">
            <svg style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c.8-5 4-7 8-7s7.2 2 8 7"/></svg>
            Sign Up
          </a>
        @endguest

        @auth('customer')
          <a class="kb-auth-btn" href="{{ route('shop.customers.account.profile.index') }}">
            <svg style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c.8-5 4-7 8-7s7.2 2 8 7"/></svg>
            Dashboard
          </a>
        @endauth
      </div>
    </div>

    <!-- MOBILE HEADER -->
    <div class="kb-mobile">
      <div class="kb-mobile-row">
        <button class="kb-icon-btn" id="kbMenuOpen" type="button" aria-label="Open navigation menu" aria-controls="kbMobileDrawer" aria-expanded="false">
          <svg viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>

        <a href="{{ route('shop.home.index') }}" aria-label="{{ $logoAlt }} home" style="display:flex;justify-content:center;">
          <img
            class="kb-mobile-logo"
            src="{{ $logoUrl }}"
            alt="{{ $logoAlt }}"
          >
        </a>

        <a class="kb-icon-btn kb-mobile-cart" href="{{ route('shop.checkout.cart.index') }}" aria-label="Cart">
          <span class="kb-badge" id="kbCartBadgeMob" style="display:none;">0</span>
          <svg viewBox="0 0 24 24"><path d="M5 8h14l-1 12H6Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
        </a>
      </div>
    </div>
  </header>
</div>

<!-- MOBILE DRAWER & OVERLAY -->
<!-- Strict Menu items: home, about us, store, contact us, wishlist, account, cart, sign up -->
<div class="kb-overlay" id="kbMenuOverlay"></div>

<aside class="kb-drawer" id="kbMobileDrawer" aria-hidden="true">
  <div class="kb-drawer-handle"></div>

  <div class="kb-drawer-top">
    <button class="kb-close" id="kbMenuClose" type="button" aria-label="Close navigation menu">
      <svg viewBox="0 0 24 24"><path d="m6 6 12 12M18 6 6 18"/></svg>
    </button>
  </div>

  <nav class="kb-drawer-nav" aria-label="Mobile navigation">
    <!-- 1. Home -->
    <a class="kb-drawer-link {{ $isHome ? 'active' : '' }}" href="{{ route('shop.home.index') }}">
      <svg viewBox="0 0 24 24"><path d="m3 11 9-8 9 8"/><path d="M5 10v11h14V10"/><path d="M9 21v-7h6v7"/></svg>
      <span>Home</span>
      <span class="arrow">›</span>
    </a>

    <!-- 2. About Us -->
    <a class="kb-drawer-link {{ $isAboutUs ? 'active' : '' }}" href="{{ url('/page/about-us') }}">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7h.01"/></svg>
      <span>About Us</span>
      <span class="arrow">›</span>
    </a>

    <!-- 3. Store -->
    <a class="kb-drawer-link {{ $isStore ? 'active' : '' }}" href="{{ route('shop.search.index') }}">
      <svg viewBox="0 0 24 24"><path d="M4 9h16l-1 11H5Z"/><path d="m6 9 2-5h8l2 5"/></svg>
      <span>Store</span>
      <span class="arrow">›</span>
    </a>

    <!-- 4. Contact Us -->
    <a class="kb-drawer-link {{ $isContactUs ? 'active' : '' }}" href="{{ url('/page/contact-us') }}">
      <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
      <span>Contact Us</span>
      <span class="arrow">›</span>
    </a>

    <!-- 5. Wishlist -->
    <a class="kb-drawer-link {{ $isWishlist ? 'active' : '' }}" href="{{ route('shop.customers.account.wishlist.index') }}">
      <svg viewBox="0 0 24 24"><path d="M20.8 4.6a5.3 5.3 0 0 0-7.5 0L12 5.9l-1.3-1.3a5.3 5.3 0 0 0-7.5 7.5L12 20.9l8.8-8.8a5.3 5.3 0 0 0 0-7.5Z"/></svg>
      <span>Wishlist</span>
      @if($wishlistCount > 0)
        <span class="kb-drawer-count">{{ $wishlistCount }}</span>
      @else
        <span class="arrow">›</span>
      @endif
    </a>

    <!-- 6. Account -->
    <a class="kb-drawer-link {{ $isAccount ? 'active' : '' }}" href="{{ route('shop.customers.account.profile.index') }}">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c.8-5 4-7 8-7s7.2 2 8 7"/></svg>
      <span>Account</span>
      <span class="arrow">›</span>
    </a>

    <!-- 7. Cart -->
    <a class="kb-drawer-link {{ $isCart ? 'active' : '' }}" href="{{ route('shop.checkout.cart.index') }}">
      <svg viewBox="0 0 24 24"><path d="M5 8h14l-1 12H6Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
      <span>Cart</span>
      <span class="kb-drawer-count" id="kbCartBadgeDraw" style="display:none;">0</span>
    </a>

    <!-- 8. Sign Up / Sign In -->
    @guest('customer')
      <a class="kb-drawer-link" href="{{ route('shop.customers.register.index') }}">
        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
        <span>Sign Up / Sign In</span>
        <span class="arrow">›</span>
      </a>
    @endguest

    @auth('customer')
      <a class="kb-drawer-link" href="{{ route('shop.customer.session.destroy') }}" onclick="event.preventDefault(); document.getElementById('kbCustomerLogoutCompact').submit();">
        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Logout</span>
        <span class="arrow">›</span>
      </a>
    @endauth
  </nav>

  <div class="kb-drawer-footer">
    <span>✦</span> Kawaii made happier <span>✦</span>
  </div>
</aside>

<script>
(function() {
  function openMenu() {
    const drawer = document.getElementById('kbMobileDrawer');
    const overlay = document.getElementById('kbMenuOverlay');
    const openBtn = document.getElementById('kbMenuOpen');
    if (!drawer || !overlay) return;
    drawer.classList.add('open');
    overlay.classList.add('show');
    drawer.setAttribute('aria-hidden', 'false');
    if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
    document.documentElement.style.overflow = 'hidden';
  }

  function closeMenu() {
    const drawer = document.getElementById('kbMobileDrawer');
    const overlay = document.getElementById('kbMenuOverlay');
    const openBtn = document.getElementById('kbMenuOpen');
    if (!drawer || !overlay) return;
    drawer.classList.remove('open');
    overlay.classList.remove('show');
    drawer.setAttribute('aria-hidden', 'true');
    if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
    document.documentElement.style.overflow = '';
  }

  // Global delegated click handler
  document.addEventListener('click', function(e) {
    if (e.target.closest('#kbMenuOpen')) {
      e.preventDefault();
      openMenu();
      return;
    }
    if (e.target.closest('#kbMenuClose')) {
      e.preventDefault();
      closeMenu();
      return;
    }
    if (e.target.closest('#kbMenuOverlay')) {
      e.preventDefault();
      closeMenu();
      return;
    }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeMenu();
  });

  window.addEventListener('resize', function() {
    if (window.innerWidth > 890) closeMenu();
  });

  // Cart Badge Sync
  function updateCartBadges(count) {
    const desktop = document.getElementById('kbCartBadgeDesk');
    const mobile = document.getElementById('kbCartBadgeMob');
    const drawerBadge = document.getElementById('kbCartBadgeDraw');
    const num = parseInt(count, 10) || 0;

    [desktop, mobile, drawerBadge].forEach(function(el) {
      if (!el) return;
      if (num > 0) {
        el.textContent = num;
        el.style.display = 'grid';
      } else {
        el.style.display = 'none';
      }
    });
  }

  fetch('{{ route('shop.api.checkout.cart.index') }}', {
    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(function(res) { return res.json(); })
  .then(function(json) {
    if (json && json.data) {
      const count = json.data.items_count || json.data.items_qty || (Array.isArray(json.data.items) ? json.data.items.length : 0);
      updateCartBadges(count);
    }
  })
  .catch(function() {});

  if (window.emitter) {
    window.emitter.on('update-mini-cart', function(cart) {
      if (cart) {
        updateCartBadges(cart.items_count || cart.items_qty || 0);
      }
    });
  }
})();
</script>

{!! view_render_event('bagisto.shop.layout.header.after') !!}
