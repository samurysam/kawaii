{!! view_render_event('bagisto.shop.checkout.onepage.address.before') !!}

<!-- Step 1: Delivery Address Card -->
<div
    class="kb-co-step-card"
    :class="{'active-step': currentStep === 'address'}"
>
    <!-- Step Header -->
    <div class="kb-co-step-card-head">
        <div class="kb-co-step-card-head-left">
            <div class="kb-co-step-icon-box">📍</div>
            <div>
                <h2 class="kb-co-step-title">
                    @lang('shop::app.checkout.onepage.address.title')
                </h2>
                <p class="kb-co-step-sub">
                    Where should we send your little bundle of joy?
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span
                class="kb-co-step-badge"
                v-if="cart.billing_address || isStepCompleted('address')"
            >
                ✓ SAVED
            </span>
        </div>
    </div>

    <!-- Step Body -->
    <div class="kb-co-step-content">
        <!-- If the customer is guest -->
        <template v-if="cart.is_guest">
            @include('shop::checkout.onepage.address.guest')
        </template>

        <!-- If the customer is logged in -->
        <template v-else>
            @include('shop::checkout.onepage.address.customer')
        </template>
    </div>
</div>

{!! view_render_event('bagisto.shop.checkout.onepage.address.after') !!}