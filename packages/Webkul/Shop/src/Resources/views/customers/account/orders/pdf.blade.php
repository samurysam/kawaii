<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ core()->getCurrentLocale()->direction }}"
>
    <head>
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        @php
            $fontPath = [];

            // True UTF-8 font family for crisp glyph rendering in DomPDF & mPDF
            $fontFamily = [
                'regular' => 'DejaVu Sans, Arial, sans-serif',
                'bold'    => 'DejaVu Sans, Arial, sans-serif',
            ];

            if (app()->getLocale() == 'zh_CN') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSC-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSC-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans SC',
                    'bold'    => 'Noto Sans SC Bold',
                ];
            } elseif (app()->getLocale() == 'ja') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansJP-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansJP-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans JP',
                    'bold'    => 'Noto Sans JP Bold',
                ];
            } elseif (app()->getLocale() == 'hi_IN') {
                $fontPath = [
                    'regular' => asset('fonts/Hind-Regular.ttf'),
                    'bold'    => asset('fonts/Hind-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Hind',
                    'bold'    => 'Hind Bold',
                ];
            } elseif (app()->getLocale() == 'bn') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansBengali-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansBengali-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Bengali',
                    'bold'    => 'Noto Sans Bengali Bold',
                ];
            } elseif (app()->getLocale() == 'sin') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSinhala-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSinhala-Bold.ttf'),
                ];

                $fontFamily = [
                    'regular' => 'Noto Sans Sinhala',
                    'bold'    => 'Noto Sans Sinhala Bold',
                ];
            }

            // Safe Local / Base64 Logo Resolution Chain
            $logoBase64 = null;
            $customLogo = core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo');
            if ($customLogo && Storage::disk('public')->exists($customLogo)) {
                $logoData = Storage::disk('public')->get($customLogo);
                $mime = Storage::disk('public')->mimeType($customLogo) ?: 'image/png';
                $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($logoData);
            } elseif ($channelLogo = core()->getCurrentChannel()->logo) {
                if (Storage::disk('public')->exists($channelLogo)) {
                    $logoData = Storage::disk('public')->get($channelLogo);
                    $mime = Storage::disk('public')->mimeType($channelLogo) ?: 'image/png';
                    $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($logoData);
                }
            }

            // Clean Duplicate Shipping Method Title
            $shippingTitle = $invoice->order->shipping_title;
            if ($shippingTitle) {
                $parts = explode(' - ', $shippingTitle);
                if (count($parts) === 2 && strcasecmp(trim($parts[0]), trim($parts[1])) === 0) {
                    $shippingTitle = trim($parts[0]);
                }
            }
        @endphp

        <style type="text/css">
            @if (! empty($fontPath['regular']))
                @font-face {
                    src: url({{ $fontPath['regular'] }}) format('truetype');
                    font-family: {{ $fontFamily['regular'] }};
                }
            @endif

            @if (! empty($fontPath['bold']))
                @font-face {
                    src: url({{ $fontPath['bold'] }}) format('truetype');
                    font-family: {{ $fontFamily['bold'] }};
                    font-style: bold;
                }
            @endif

            @page {
                margin: 24px 30px 48px 30px;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 8.5px;
                color: #2f2529;
                background-color: #ffffff;
                line-height: 1.35;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            b, strong, th {
                font-family: "{{ $fontFamily['bold'] }}";
            }

            .page-container {
                width: 100%;
                padding: 0;
            }

            /* Header Section */
            .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 6px;
            }

            .header-table td {
                vertical-align: top;
            }

            .brand-logo-cell {
                width: 52%;
                text-align: left;
            }

            .brand-logo-cell.rtl {
                text-align: right;
            }

            .brand-logo-img {
                max-width: 155px;
                max-height: 52px;
                display: block;
            }

            .brand-text-fallback {
                font-size: 19px;
                font-weight: bold;
                color: #ef6d98;
                letter-spacing: 0.5px;
            }

            .store-info {
                margin-top: 5px;
                font-size: 8px;
                color: #7e6870;
                line-height: 1.35;
            }

            .store-name {
                color: #2f2529;
                font-size: 9px;
                font-weight: bold;
            }

            .invoice-title-cell {
                width: 48%;
                text-align: right;
            }

            .invoice-title-cell.rtl {
                text-align: left;
            }

            .invoice-heading {
                font-size: 22px;
                font-weight: bold;
                color: #ef6d98;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                line-height: 1.1;
            }

            .invoice-subheading {
                font-size: 8.5px;
                color: #7e6870;
                margin-top: 2px;
                margin-bottom: 6px;
                font-style: italic;
            }

            .meta-table {
                border-collapse: collapse;
                font-size: 8.5px;
                margin-top: 4px;
            }

            .meta-table td {
                padding: 1.5px 0;
            }

            .meta-label {
                color: #7e6870;
                padding-right: 10px;
                text-align: right;
                white-space: nowrap;
                font-weight: bold;
            }

            .meta-label.rtl {
                padding-right: 0;
                padding-left: 10px;
                text-align: left;
            }

            .meta-value {
                color: #2f2529;
                font-weight: bold;
                text-align: right;
                white-space: nowrap;
            }

            .meta-value.rtl {
                text-align: left;
            }

            .gold-divider {
                width: 100%;
                height: 1px;
                background-color: #f4ccd8;
                margin: 8px 0 12px 0;
            }

            /* 2-Column Info Cards */
            .cards-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }

            .card-col {
                width: 48.5%;
                vertical-align: top;
            }

            .card-spacer {
                width: 3%;
            }

            .info-card {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #f4ccd8;
                background-color: #fffdfd;
            }

            .card-header {
                background-color: #fff0f5;
                color: #ef6d98;
                font-size: 9px;
                font-weight: bold;
                padding: 5px 8px;
                border-bottom: 1px solid #f4ccd8;
                text-align: left;
                letter-spacing: 0.3px;
            }

            .card-header.rtl {
                text-align: right;
            }

            .card-body {
                padding: 6px 8px;
                font-size: 8.5px;
                color: #2f2529;
                line-height: 1.35;
                text-align: left;
            }

            .card-body.rtl {
                text-align: right;
            }

            .card-body strong {
                color: #2f2529;
            }

            /* Product Items Table */
            .items-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
                margin-bottom: 12px;
                font-size: 8.5px;
            }

            .items-table thead {
                display: table-header-group;
            }

            .items-table tr {
                page-break-inside: avoid;
            }

            .items-table thead th {
                background-color: #fff0f5;
                color: #2f2529;
                font-weight: bold;
                padding: 6.5px 8px;
                border-top: 1.5px solid #f4ccd8;
                border-bottom: 1.5px solid #f4ccd8;
                text-align: left;
                font-size: 8.5px;
            }

            .items-table.rtl thead th {
                text-align: right;
            }

            .items-table tbody td {
                padding: 7px 8px;
                border-bottom: 1px solid #fae8ee;
                text-align: left;
                vertical-align: top;
                color: #2f2529;
            }

            .items-table.rtl tbody td {
                text-align: right;
            }

            .item-name {
                font-weight: bold;
                color: #2f2529;
            }

            .item-attributes {
                margin-top: 2px;
                font-size: 7.5px;
                color: #7e6870;
            }

            .small-tax-text {
                font-size: 7.5px;
                color: #7e6870;
                margin-top: 1px;
            }

            /* Summary / Totals */
            .bottom-section {
                width: 100%;
                border-collapse: collapse;
                margin-top: 4px;
                page-break-inside: avoid;
            }

            .bottom-section td {
                vertical-align: top;
            }

            .summary-card-table {
                width: 245px;
                border-collapse: collapse;
                border: 1px solid #f4ccd8;
                background-color: #fffdfd;
                font-size: 8.5px;
            }

            .summary-card-table td {
                padding: 4.5px 8px;
                border-bottom: 1px solid #fceef3;
            }

            .summary-label {
                color: #7e6870;
                text-align: left;
            }

            .summary-label.rtl {
                text-align: right;
            }

            .summary-value {
                color: #2f2529;
                font-weight: bold;
                text-align: right;
            }

            .summary-value.rtl {
                text-align: left;
            }

            .summary-grand-total {
                background-color: #ffe6ee;
                border-top: 1.5px solid #d9a84f !important;
                border-bottom: none !important;
            }

            .summary-grand-total td {
                padding: 6.5px 8px;
            }

            .grand-total-label {
                font-size: 9.5px;
                font-weight: bold;
                color: #2f2529;
                text-align: left;
            }

            .grand-total-label.rtl {
                text-align: right;
            }

            .grand-total-value {
                font-size: 11px;
                font-weight: bold;
                color: #ef6d98;
                text-align: right;
            }

            .grand-total-value.rtl {
                text-align: left;
            }

            /* Fixed PDF Footer */
            .pdf-footer {
                position: fixed;
                bottom: -22px;
                left: 0;
                right: 0;
                height: 38px;
                text-align: center;
                border-top: 1px solid #f4ccd8;
                padding-top: 5px;
                font-size: 8px;
                color: #7e6870;
            }

            .footer-primary-text {
                font-size: 8.5px;
                color: #ef6d98;
                font-weight: bold;
            }

            .footer-custom-text {
                font-size: 7.5px;
                color: #7e6870;
                margin-top: 1px;
            }

            .footer-sub-text {
                font-size: 7px;
                color: #a38b93;
                margin-top: 1px;
            }
        </style>
    </head>

    <body dir="{{ core()->getCurrentLocale()->direction }}">
        <div class="page-container">
            <!-- Header Section -->
            <table class="header-table {{ core()->getCurrentLocale()->direction }}">
                <tr>
                    <!-- Left: Kawaii Blessings Brand Logo & Seller Details -->
                    <td class="brand-logo-cell {{ core()->getCurrentLocale()->direction }}">
                        @if ($logoBase64)
                            <img src="{{ $logoBase64 }}" class="brand-logo-img" alt="Kawaii Blessings" />
                        @else
                            <div class="brand-text-fallback">Kawaii Blessings &#9825;</div>
                        @endif

                        <div class="store-info">
                            <div class="store-name">
                                {{ core()->getConfigData('sales.shipping.origin.store_name') ?: 'Kawaii Blessings' }}
                            </div>

                            @if (core()->getConfigData('sales.shipping.origin.address'))
                                <div>{{ core()->getConfigData('sales.shipping.origin.address') }}</div>
                            @endif

                            @if (core()->getConfigData('sales.shipping.origin.city') || core()->getConfigData('sales.shipping.origin.country'))
                                <div>
                                    {{ trim(core()->getConfigData('sales.shipping.origin.zipcode') . ' ' . core()->getConfigData('sales.shipping.origin.city')) }}
                                    {{ core()->getConfigData('sales.shipping.origin.state') ? ', ' . core()->getConfigData('sales.shipping.origin.state') : '' }}
                                    {{ core()->getConfigData('sales.shipping.origin.country') ? ', ' . core()->country_name(core()->getConfigData('sales.shipping.origin.country')) : '' }}
                                </div>
                            @endif

                            <div style="color: #ef6d98; font-weight: bold; margin-top: 1px;">
                                kawaii.keynostore.com
                            </div>
                        </div>
                    </td>

                    <!-- Right: Large INVOICE Heading & Metadata -->
                    <td class="invoice-title-cell {{ core()->getCurrentLocale()->direction }}">
                        <div class="invoice-heading">
                            @lang('shop::app.customers.account.orders.invoice-pdf.invoice')
                        </div>

                        <div class="invoice-subheading">
                            Thank you for your order &#9825;
                        </div>

                        <table class="meta-table {{ core()->getCurrentLocale()->direction }}" align="{{ core()->getCurrentLocale()->direction === 'rtl' ? 'left' : 'right' }}">
                            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.invoice_id'))
                                <tr>
                                    <td class="meta-label {{ core()->getCurrentLocale()->direction }}">
                                        <strong>@lang('shop::app.customers.account.orders.invoice-pdf.invoice-id'):</strong>
                                    </td>
                                    <td class="meta-value {{ core()->getCurrentLocale()->direction }}">
                                        #{{ $invoice->increment_id ?? $invoice->id }}
                                    </td>
                                </tr>
                            @endif

                            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.order_id'))
                                <tr>
                                    <td class="meta-label {{ core()->getCurrentLocale()->direction }}">
                                        <strong>@lang('shop::app.customers.account.orders.invoice-pdf.order-id'):</strong>
                                    </td>
                                    <td class="meta-value {{ core()->getCurrentLocale()->direction }}">
                                        #{{ $invoice->order->increment_id }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td class="meta-label {{ core()->getCurrentLocale()->direction }}">
                                    <strong>@lang('shop::app.customers.account.orders.invoice-pdf.date'):</strong>
                                </td>
                                <td class="meta-value {{ core()->getCurrentLocale()->direction }}">
                                    {{ core()->formatDate($invoice->created_at, 'd M Y') }}
                                </td>
                            </tr>

                            <tr>
                                <td class="meta-label {{ core()->getCurrentLocale()->direction }}">
                                    <strong>@lang('shop::app.customers.account.orders.invoice-pdf.order-date'):</strong>
                                </td>
                                <td class="meta-value {{ core()->getCurrentLocale()->direction }}">
                                    {{ core()->formatDate($invoice->order->created_at, 'd M Y') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Divider -->
            <div class="gold-divider"></div>

            <!-- Billing & Shipping Information Cards -->
            <table class="cards-table {{ core()->getCurrentLocale()->direction }}">
                <tr>
                    <!-- Bill To Card -->
                    <td class="{{ $invoice->order->shipping_address ? 'card-col' : '' }}" style="{{ ! $invoice->order->shipping_address ? 'width: 100%;' : '' }}">
                        @if ($invoice->order->billing_address)
                            <table class="info-card">
                                <tr>
                                    <td class="card-header {{ core()->getCurrentLocale()->direction }}">
                                        &#10022; @lang('shop::app.customers.account.orders.invoice-pdf.bill-to')
                                    </td>
                                </tr>
                                <tr>
                                    <td class="card-body {{ core()->getCurrentLocale()->direction }}">
                                        @if (! empty($invoice->order->billing_address->company_name))
                                            <div><strong>{{ $invoice->order->billing_address->company_name }}</strong></div>
                                        @endif

                                        <div><strong>{{ $invoice->order->billing_address->name }}</strong></div>
                                        <div>{{ $invoice->order->billing_address->address }}</div>
                                        <div>{{ trim($invoice->order->billing_address->postcode . ' ' . $invoice->order->billing_address->city) }}</div>
                                        <div>{{ $invoice->order->billing_address->state . ', ' . core()->country_name($invoice->order->billing_address->country) }}</div>

                                        @if (! empty($invoice->order->billing_address->phone))
                                            <div style="margin-top: 2px; color: #7e6870;">
                                                <strong>@lang('shop::app.customers.account.orders.invoice-pdf.contact'):</strong> {{ $invoice->order->billing_address->phone }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </td>

                    @if ($invoice->order->shipping_address)
                        <td class="card-spacer"></td>

                        <!-- Ship To Card -->
                        <td class="card-col">
                            <table class="info-card">
                                <tr>
                                    <td class="card-header {{ core()->getCurrentLocale()->direction }}">
                                        &#10022; @lang('shop::app.customers.account.orders.invoice-pdf.ship-to')
                                    </td>
                                </tr>
                                <tr>
                                    <td class="card-body {{ core()->getCurrentLocale()->direction }}">
                                        @if (! empty($invoice->order->shipping_address->company_name))
                                            <div><strong>{{ $invoice->order->shipping_address->company_name }}</strong></div>
                                        @endif

                                        <div><strong>{{ $invoice->order->shipping_address->name }}</strong></div>
                                        <div>{{ $invoice->order->shipping_address->address }}</div>
                                        <div>{{ trim($invoice->order->shipping_address->postcode . ' ' . $invoice->order->shipping_address->city) }}</div>
                                        <div>{{ $invoice->order->shipping_address->state . ', ' . core()->country_name($invoice->order->shipping_address->country) }}</div>

                                        @if (! empty($invoice->order->shipping_address->phone))
                                            <div style="margin-top: 2px; color: #7e6870;">
                                                <strong>@lang('shop::app.customers.account.orders.invoice-pdf.contact'):</strong> {{ $invoice->order->shipping_address->phone }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endif
                </tr>
            </table>

            <!-- Payment & Delivery Information Cards -->
            <table class="cards-table {{ core()->getCurrentLocale()->direction }}">
                <tr>
                    <!-- Payment Method Card -->
                    <td class="{{ $invoice->order->shipping_address ? 'card-col' : '' }}" style="{{ ! $invoice->order->shipping_address ? 'width: 100%;' : '' }}">
                        <table class="info-card">
                            <tr>
                                <td class="card-header {{ core()->getCurrentLocale()->direction }}">
                                    &#10022; @lang('shop::app.customers.account.orders.invoice-pdf.payment-method')
                                </td>
                            </tr>
                            <tr>
                                <td class="card-body {{ core()->getCurrentLocale()->direction }}">
                                    <div><strong>{{ core()->getConfigData('sales.payment_methods.' . $invoice->order->payment->method . '.title') ?: ($invoice->order->payment->method_title ?? $invoice->order->payment->method) }}</strong></div>

                                    @php $additionalDetails = \Webkul\Payment\Payment::getAdditionalDetails($invoice->order->payment->method); @endphp

                                    @if (! empty($additionalDetails))
                                        <div style="margin-top: 2px; color: #7e6870; font-size: 7.5px;">
                                            <span>{{ $additionalDetails['title'] }}:</span>
                                            <span>{{ $additionalDetails['value'] }}</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>

                    @if ($invoice->order->shipping_address)
                        <td class="card-spacer"></td>

                        <!-- Delivery Method Card -->
                        <td class="card-col">
                            <table class="info-card">
                                <tr>
                                    <td class="card-header {{ core()->getCurrentLocale()->direction }}">
                                        &#10022; @lang('shop::app.customers.account.orders.invoice-pdf.shipping-method')
                                    </td>
                                </tr>
                                <tr>
                                    <td class="card-body {{ core()->getCurrentLocale()->direction }}">
                                        <div><strong>{{ $shippingTitle ?: 'Standard Delivery' }}</strong></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endif
                </tr>
            </table>

            <!-- Product Items Table -->
            <table class="items-table {{ core()->getCurrentLocale()->direction }}">
                <thead>
                    <tr>
                        <th style="width: 16%;">@lang('shop::app.customers.account.orders.invoice-pdf.sku')</th>
                        <th style="width: 44%;">@lang('shop::app.customers.account.orders.invoice-pdf.product-name')</th>
                        <th style="width: 14%; text-align: right;">@lang('shop::app.customers.account.orders.invoice-pdf.price')</th>
                        <th style="width: 10%; text-align: center;">@lang('shop::app.customers.account.orders.invoice-pdf.qty')</th>
                        <th style="width: 16%; text-align: right;">@lang('shop::app.customers.account.orders.invoice-pdf.subtotal')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <!-- SKU -->
                            <td style="color: #7e6870; font-family: monospace; font-size: 8px;">
                                {{ $item->getTypeInstance()->getOrderedItem($item)->sku }}
                            </td>

                            <!-- Product Name & Options -->
                            <td>
                                <div class="item-name">{{ $item->name }}</div>

                                @if (isset($item->additional['attributes']))
                                    <div class="item-attributes">
                                        @foreach ($item->additional['attributes'] as $attribute)
                                            @if (! isset($attribute['attribute_type']) || $attribute['attribute_type'] !== 'file')
                                                <span><strong>{{ $attribute['attribute_name'] }}:</strong> {{ $attribute['option_label'] }}</span><br>
                                            @else
                                                <span><strong>{{ $attribute['attribute_name'] }}:</strong> {{ File::basename($attribute['option_label']) }}</span><br>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            <!-- Unit Price -->
                            <td style="text-align: right;">
                                @if (core()->getConfigData('sales.taxes.sales.display_prices') == 'including_tax')
                                    <strong>{!! core()->formatPrice($item->price_incl_tax, $orderCurrencyCode) !!}</strong>
                                @elseif (core()->getConfigData('sales.taxes.sales.display_prices') == 'both')
                                    <strong>{!! core()->formatPrice($item->price_incl_tax, $orderCurrencyCode) !!}</strong>
                                    <div class="small-tax-text">
                                        @lang('shop::app.customers.account.orders.invoice-pdf.excl-tax') {{ core()->formatPrice($item->price, $orderCurrencyCode) }}
                                    </div>
                                @else
                                    <strong>{!! core()->formatPrice($item->price, $orderCurrencyCode) !!}</strong>
                                @endif
                            </td>

                            <!-- Quantity -->
                            <td style="text-align: center; font-weight: bold; color: #2f2529;">
                                {{ $item->qty }}
                            </td>

                            <!-- Subtotal -->
                            <td style="text-align: right;">
                                @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                    <strong>{!! core()->formatPrice($item->total_incl_tax, $orderCurrencyCode) !!}</strong>
                                @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                    <strong>{!! core()->formatPrice($item->total_incl_tax, $orderCurrencyCode) !!}</strong>
                                    <div class="small-tax-text">
                                        @lang('shop::app.customers.account.orders.invoice-pdf.excl-tax') {{ core()->formatPrice($item->total, $orderCurrencyCode) }}
                                    </div>
                                @else
                                    <strong>{!! core()->formatPrice($item->total, $orderCurrencyCode) !!}</strong>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary Section & Bank Details -->
            <table class="bottom-section {{ core()->getCurrentLocale()->direction }}">
                <tr>
                    <!-- Left: Notes & Bank Details -->
                    <td style="width: 52%; text-align: left;">
                        @if ($invoice->hasPaymentTerm())
                            <div style="font-size: 8px; color: #7e6870; background: #fff0f5; border: 1px solid #f4ccd8; padding: 5px 8px; margin-bottom: 6px; display: inline-block;">
                                <strong style="color: #2f2529;">@lang('shop::app.customers.account.orders.invoice-pdf.payment-terms'):</strong> {{ $invoice->getFormattedPaymentTerm() }}
                            </div>
                        @endif

                        @if (core()->getConfigData('sales.shipping.origin.bank_details'))
                            <div style="font-size: 8px; color: #7e6870; margin-top: 4px;">
                                <strong style="color: #2f2529;">@lang('shop::app.customers.account.orders.invoice-pdf.bank-details'):</strong><br>
                                {!! nl2br(e(core()->getConfigData('sales.shipping.origin.bank_details'))) !!}
                            </div>
                        @endif
                    </td>

                    <!-- Right: Summary Card -->
                    <td style="width: 48%;" align="{{ core()->getCurrentLocale()->direction === 'rtl' ? 'left' : 'right' }}">
                        <table class="summary-card-table {{ core()->getCurrentLocale()->direction }}">
                            <!-- Subtotal -->
                            @if (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'including_tax')
                                <tr>
                                    <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.subtotal')</td>
                                    <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->sub_total_incl_tax, $orderCurrencyCode) !!}</td>
                                </tr>
                            @elseif (core()->getConfigData('sales.taxes.sales.display_subtotal') == 'both')
                                <tr>
                                    <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.subtotal-incl-tax')</td>
                                    <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->sub_total_incl_tax, $orderCurrencyCode) !!}</td>
                                </tr>
                                <tr>
                                    <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.subtotal-excl-tax')</td>
                                    <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->sub_total, $orderCurrencyCode) !!}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.subtotal')</td>
                                    <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->sub_total, $orderCurrencyCode) !!}</td>
                                </tr>
                            @endif

                            <!-- Shipping & Handling -->
                            @if ($invoice->order->shipping_address)
                                @if (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'including_tax')
                                    <tr>
                                        <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling')</td>
                                        <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->shipping_amount_incl_tax, $orderCurrencyCode) !!}</td>
                                    </tr>
                                @elseif (core()->getConfigData('sales.taxes.sales.display_shipping_amount') == 'both')
                                    <tr>
                                        <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling-incl-tax')</td>
                                        <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->shipping_amount_incl_tax, $orderCurrencyCode) !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling-excl-tax')</td>
                                        <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->shipping_amount, $orderCurrencyCode) !!}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.shipping-handling')</td>
                                        <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->shipping_amount, $orderCurrencyCode) !!}</td>
                                    </tr>
                                @endif
                            @endif

                            <!-- Tax -->
                            @if ((float) $invoice->tax_amount > 0)
                                <tr>
                                    <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.tax')</td>
                                    <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->tax_amount, $orderCurrencyCode) !!}</td>
                                </tr>
                            @endif

                            <!-- Discount -->
                            @if ((float) $invoice->discount_amount > 0)
                                <tr>
                                    <td class="summary-label {{ core()->getCurrentLocale()->direction }}">@lang('shop::app.customers.account.orders.invoice-pdf.discount')</td>
                                    <td class="summary-value {{ core()->getCurrentLocale()->direction }}">{!! core()->formatPrice($invoice->discount_amount, $orderCurrencyCode) !!}</td>
                                </tr>
                            @endif

                            <!-- Grand Total -->
                            <tr class="summary-grand-total">
                                <td class="grand-total-label {{ core()->getCurrentLocale()->direction }}">
                                    @lang('shop::app.customers.account.orders.invoice-pdf.grand-total')
                                </td>
                                <td class="grand-total-value {{ core()->getCurrentLocale()->direction }}">
                                    {!! core()->formatPrice($invoice->grand_total, $orderCurrencyCode) !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Branded Fixed PDF Footer -->
            <div class="pdf-footer">
                <div class="footer-primary-text">
                    Thank you for shopping with Kawaii Blessings &#9825;
                </div>

                @if ($footerText = core()->getConfigData('sales.invoice_settings.pdf_print_outs.footer_text'))
                    <div class="footer-custom-text">
                        {{ $footerText }}
                    </div>
                @endif

                <div class="footer-sub-text">
                    kawaii.keynostore.com &#10022; Delivering Kawaii Joy Across the UAE
                </div>
            </div>
        </div>
    </body>
</html>
