<div class="kb-co-summary-card">
    {!! view_render_event('bagisto.shop.checkout.cart.summary.title.before') !!}

    <!-- Summary Header -->
    <div class="kb-co-summary-header">
        <div>
            <h2 class="kb-co-summary-title">
                Bag Summary <span class="heart">♡</span>
            </h2>
            <p class="kb-co-summary-sub">
                @{{ parseInt(cart.items_qty || cart.items.length) }} lovely @{{ parseInt(cart.items_qty || cart.items.length) === 1 ? 'item' : 'items' }} ready for checkout
            </p>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.checkout.cart.summary.title.after') !!}

    <!-- Cart Totals & Controls -->
    <div class="mt-4 flex flex-col gap-4">
        <!-- Estimate Tax and Shipping -->
        @if (core()->getConfigData('sales.checkout.shopping_cart.estimate_shipping'))
            <template v-if="cart.have_stockable_items">
                @include('shop::checkout.cart.summary.estimate-shipping')
            </template>
        @endif

        <!-- Apply Coupon -->
        {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.before') !!}

        @include('shop::checkout.coupon')

        {!! view_render_event('bagisto.shop.checkout.cart.summary.coupon.after') !!}

        <!-- Breakdown Section -->
        <div class="kb-co-totals-list">
            <!-- Sub Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.before') !!}

            <template v-if="displayTax.subtotal == 'including_tax'">
                <div class="kb-co-total-row">
                    <span>@lang('shop::app.checkout.cart.summary.sub-total')</span>
                    <span>@{{ cart.formatted_sub_total_incl_tax }}</span>
                </div>
            </template>

            <template v-else-if="displayTax.subtotal == 'both'">
                <div class="kb-co-total-row">
                    <span>@lang('shop::app.checkout.cart.summary.sub-total')</span>
                    <div class="text-right">
                        <span>@{{ cart.formatted_sub_total_incl_tax }}</span>
                        <p class="text-xs text-[#9b898d]">
                            @lang('shop::app.checkout.cart.summary.excl-tax') @{{ cart.formatted_sub_total }}
                        </p>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="kb-co-total-row">
                    <span>@lang('shop::app.checkout.cart.summary.sub-total')</span>
                    <span>@{{ cart.formatted_sub_total }}</span>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.sub_total.after') !!}

            <!-- Discount -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.before') !!}

            <template v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0">
                <div class="kb-co-total-row discount">
                    <span>@lang('shop::app.checkout.cart.summary.discount-amount')</span>
                    <span>- @{{ cart.formatted_discount_amount }}</span>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.discount_amount.after') !!}

            <!-- Shipping Rates -->
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}
            
            <template v-if="cart.selected_shipping_rate || parseFloat(cart.base_shipping_amount || 0) > 0">
                <div class="kb-co-total-row" :class="{'delivery-free': !(parseFloat(cart.base_shipping_amount || 0) > 0)}">
                    <span>@lang('shop::app.checkout.cart.summary.delivery-charges')</span>
                    <span>
                        @{{ parseFloat(cart.base_shipping_amount || 0) > 0 ? '+ ' + cart.formatted_shipping_amount : 'FREE' }}
                    </span>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

            <!-- Taxes -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.before') !!}

            <template v-if="cart.tax_total && parseFloat(cart.tax_total) > 0">
                <div class="kb-co-total-row">
                    <span>@lang('shop::app.checkout.cart.summary.tax')</span>
                    <span>+ @{{ cart.formatted_tax_total }}</span>
                </div>
            </template>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.tax.after') !!}

            <div class="kb-co-totals-divider"></div>

            <!-- Grand Total -->
            {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.before') !!}

            <div class="kb-co-grand-total-row">
                <span class="kb-co-grand-total-lbl">Total</span>
                <span class="kb-co-grand-total-val">@{{ cart.formatted_grand_total }}</span>
            </div>

            {!! view_render_event('bagisto.shop.checkout.cart.summary.grand_total.after') !!}
        </div>

        {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.before') !!}

        <!-- Proceed to Checkout CTA -->
        <a
            href="{{ route('shop.checkout.onepage.index') }}"
            class="kb-co-btn-place-order text-center"
        >
            Proceed to Checkout · @{{ cart.formatted_grand_total }} ✨
        </a>

        {!! view_render_event('bagisto.shop.checkout.cart.summary.proceed_to_checkout.after') !!}

        <!-- 2x2 Trust Grid -->
        <div class="kb-co-trust-grid">
            <div class="kb-co-trust-item">
                <span class="icon">✨</span>
                <span>100% authentic guarantee</span>
            </div>
            <div class="kb-co-trust-item">
                <span class="icon">🔒</span>
                <span>Secure encrypted checkout</span>
            </div>
            <div class="kb-co-trust-item">
                <span class="icon">🤍</span>
                <span>Packed with extra care</span>
            </div>
            <div class="kb-co-trust-item">
                <span class="icon">🇦🇪</span>
                <span>Fast UAE delivery</span>
            </div>
        </div>

        <p class="kb-co-footnote">
            Taxes & shipping calculated at checkout. Thank you for shopping with <span class="text-[#d95882] font-semibold">Kawaii Blessings ♡</span>
        </p>
    </div>
</div>