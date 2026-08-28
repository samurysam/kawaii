<div class="flex flex-col max-md:hidden text-[14px]" v-pre>
    @if (! empty($address->company_name))
        <p class="font-bold leading-6 text-[#382229]">
            {{ $address->company_name }}
        </p>
    @endif

    <p class="font-bold leading-6 text-[#382229]">
        {{ $address->name }}
    </p>
    
    <p class="!leading-6 font-semibold text-[#846671]">
        {{ $address->address }}<br>
        {{ $address->city }}<br>
        {{ $address->state }}<br>
        {{ core()->country_name($address->country) }} @if ($address->postcode) ({{ $address->postcode }}) @endif<br>
        <span class="inline-flex items-center gap-1 mt-1 text-[#ed6e98] font-bold">
            📞 {{ trans('shop::app.customers.account.orders.view.contact') }}: {{ $address->phone }}
        </span>
    </p>
</div>

<!-- For Mobile View -->
<div class="text-[#382229] md:hidden text-xs" v-pre>
    @if (! empty($address->company_name))
        <p class="font-bold">
            {{ $address->company_name }}
        </p>
    @endif

    <p class="font-bold text-sm text-[#382229] mb-1">
        {{ $address->name }}
    </p>

    <p class="font-semibold text-[#846671] leading-relaxed">
        {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ core()->country_name($address->country) }} @if ($address->postcode) ({{ $address->postcode }}) @endif <br>
        <span class="inline-flex items-center gap-1 mt-1 text-[#ed6e98] font-bold">
            📞 {{ trans('shop::app.customers.account.orders.view.contact') }}: {{ $address->phone }}
        </span>
    </p>
</div>