<!-- Sticky Order Summary Card -->
<div class="kb-co-summary-card">
    <!-- Header -->
    <div class="kb-co-summary-head">
        <div>
            <h2 class="kb-co-summary-title">
                Your Kawaii Bag <span class="heart">♡</span>
            </h2>
            <p class="kb-co-summary-sub">
                @{{ parseInt(cart.items_qty || cart.items.length) }} lovely @{{ parseInt(cart.items_qty || cart.items.length) === 1 ? 'item is' : 'items are' }} waiting for you
            </p>
        </div>

        <a
            href="{{ route('shop.checkout.cart.index') }}"
            class="kb-co-btn-edit-bag"
        >
            Edit bag
        </a>
    </div>

    <!-- Cart Items List -->
    <div class="kb-co-items-list">
        <div
            class="kb-co-item-card"
            v-for="item in cart.items"
            :key="item.id"
        >
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.before') !!}

            <div class="kb-co-item-img-wrap">
                <img
                    class="kb-co-item-img"
                    :src="item.base_image.small_image_url"
                    :alt="item.base_image.alt"
                    width="52"
                    height="52"
                    loading="lazy"
                />
            </div>

            {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_image.after') !!}

            <div class="kb-co-item-info">
                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.before') !!}

                <p class="kb-co-item-name" :title="item.name">
                    @{{ item.name }}
                </p>

                {!! view_render_event('bagisto.shop.checkout.onepage.summary.item_name.after') !!}

                <p class="kb-co-item-sub">
                    <template v-if="item.additional && item.additional.attributes">
                        <span v-for="(attr, index) in item.additional.attributes" :key="index">
                            @{{ attr.option_label }} <span v-if="index < item.additional.attributes.length - 1">· </span>
                        </span>
                        <span>· </span>
                    </template>
                    <span>Qty @{{ item.quantity }}</span>
                </p>
            </div>

            <div class="kb-co-item-price">
                <template v-if="displayTax.prices == 'including_tax'">
                    @{{ item.formatted_total_incl_tax || item.formatted_price_incl_tax }}
                </template>
                <template v-else>
                    @{{ item.formatted_total || item.formatted_price }}
                </template>
            </div>
        </div>
    </div>

    <!-- Apply Coupon Component -->
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.before') !!}
    @include('shop::checkout.coupon')
    {!! view_render_event('bagisto.shop.checkout.onepage.summary.coupon.after') !!}

    <!-- Totals Breakdown -->
    <div class="kb-co-totals-list">
        <!-- Sub Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.before') !!}
        <div class="kb-co-total-row">
            <span>@lang('shop::app.checkout.onepage.summary.sub-total')</span>
            <span class="font-bold text-[#3f2a2e]">
                <template v-if="displayTax.subtotal == 'including_tax' || displayTax.subtotal == 'both'">
                    @{{ cart.formatted_sub_total_incl_tax }}
                </template>
                <template v-else>
                    @{{ cart.formatted_sub_total }}
                </template>
            </span>
        </div>
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.sub_total.after') !!}

        <!-- Discount -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.before') !!}
        <div
            class="kb-co-total-row discount"
            v-if="cart.discount_amount && parseFloat(cart.discount_amount) > 0"
        >
            <span>Discount</span>
            <span>- @{{ cart.formatted_discount_amount }}</span>
        </div>
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.discount_amount.after') !!}

        <!-- Delivery Charges -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.before') !!}
        <div class="kb-co-total-row">
            <span>Delivery</span>
            <span
                class="font-bold text-[#22583e]"
                v-if="! cart.shipping_amount || parseFloat(cart.shipping_amount) == 0"
            >
                FREE
            </span>
            <span class="font-bold text-[#3f2a2e]" v-else>
                + @{{ cart.formatted_shipping_amount_incl_tax || cart.formatted_shipping_amount }}
            </span>
        </div>
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.delivery_charges.after') !!}

        <!-- Tax / VAT -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.before') !!}
        <div
            class="kb-co-total-row"
            v-if="cart.tax_total && parseFloat(cart.tax_total) > 0"
        >
            <span>VAT / Tax</span>
            <span class="font-bold text-[#3f2a2e]">
                + @{{ cart.formatted_tax_total }}
            </span>
        </div>
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.tax.after') !!}

        <div class="kb-co-totals-divider"></div>

        <!-- Grand Total -->
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.before') !!}
        <div class="kb-co-grand-total-row">
            <span class="kb-co-grand-total-lbl">Total</span>
            <span class="kb-co-grand-total-val">@{{ cart.formatted_grand_total }}</span>
        </div>
        {!! view_render_event('bagisto.shop.checkout.onepage.summary.grand_total.after') !!}
    </div>

    <!-- Place Order CTA Button -->
    <div class="mt-4" v-if="canPlaceOrder || currentStep === 'review' || true">
        <template v-if="(selectedPaymentMethod || cart.payment_method) == 'paypal_smart_button'">
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}
            <v-paypal-smart-button></v-paypal-smart-button>
            {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
        </template>

        <template v-else>
            <button
                type="button"
                class="kb-co-btn-place-order"
                :disabled="isPlacingOrder || ! canPlaceOrder"
                @click="placeOrder"
            >
                <span v-if="isPlacingOrder" class="animate-spin text-lg">⏳</span>
                <span>Place Order · @{{ cart.formatted_grand_total }} ✨</span>
            </button>
        </template>
    </div>

    <!-- 2x2 Trust Grid -->
    <div class="kb-co-trust-grid">
        <div class="kb-co-trust-item">
            <span>✨</span>
            <span>100% authentic guarantee</span>
        </div>
        <div class="kb-co-trust-item">
            <span>🔒</span>
            <span>Secure encrypted checkout</span>
        </div>
        <div class="kb-co-trust-item">
            <span>🤍</span>
            <span>Packed with extra care</span>
        </div>
        <div class="kb-co-trust-item">
            <span>🇦🇪</span>
            <span>Fast UAE delivery</span>
        </div>
    </div>

    <!-- Terms Footnote -->
    <p class="kb-co-legal-note">
        By placing your order, you agree to our terms. Thank you for supporting <span class="brand-love">Kawaii Blessings ♡</span>
    </p>
</div>
