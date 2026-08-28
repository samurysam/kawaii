<?php

namespace Tests\Feature;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Webkul\Sales\Models\Invoice;

class InvoicePdfRedesignTest extends TestCase
{
    protected function getTestInvoice(): Invoice
    {
        return Invoice::with(['order.items', 'order.addresses', 'order.payment', 'items'])->first()
            ?: Invoice::factory()->create();
    }

    public function test_invoice_pdf_blade_renders_without_bagisto_logo_fallback(): void
    {
        $invoice = $this->getTestInvoice();
        $orderCurrencyCode = 'AED';

        $html = view('shop::customers.account.orders.pdf', compact('invoice', 'orderCurrencyCode'))->render();

        // 1. Must not contain the old hardcoded Bagisto base64 logo or Bagisto/Webkul branding
        $this->assertStringNotContainsString('iVBORw0KGgoAAAANSUhEUgAAAIIAAAAkCAYAAABFRuIO', $html);
        $this->assertStringNotContainsString('Bagisto', $html);
        $this->assertStringNotContainsString('Webkul', $html);

        // 2. Must contain Kawaii Blessings branding
        $this->assertStringContainsString('Kawaii Blessings', $html);
        $this->assertStringContainsString('kawaii.keynostore.com', $html);
    }

    public function test_invoice_pdf_renders_with_channel_logo_fallback(): void
    {
        $invoice = $this->getTestInvoice();
        $orderCurrencyCode = 'AED';

        $html = view('shop::customers.account.orders.pdf', compact('invoice', 'orderCurrencyCode'))->render();

        $this->assertStringContainsString('data:image/png;base64,', $html);
    }

    public function test_invoice_pdf_shipping_title_normalisation(): void
    {
        $invoice = $this->getTestInvoice();
        $invoice->order->shipping_title = 'Free Shipping - Free Shipping';
        $orderCurrencyCode = 'AED';

        $html = view('shop::customers.account.orders.pdf', compact('invoice', 'orderCurrencyCode'))->render();

        $this->assertStringContainsString('Free Shipping', $html);
        $this->assertStringNotContainsString('Free Shipping - Free Shipping', $html);
    }

    public function test_invoice_pdf_handles_configured_footer_text(): void
    {
        $invoice = $this->getTestInvoice();
        $orderCurrencyCode = 'AED';

        DB::table('core_config')->updateOrInsert(
            [
                'code' => 'sales.invoice_settings.pdf_print_outs.footer_text',
                'channel_code' => 'default',
                'locale_code' => 'en',
            ],
            [
                'value' => 'Custom Kawaii Store Note for Customers',
            ]
        );

        $html = view('shop::customers.account.orders.pdf', compact('invoice', 'orderCurrencyCode'))->render();

        $this->assertStringContainsString('Custom Kawaii Store Note for Customers', $html);
    }

    public function test_invoice_pdf_dompdf_generation_produces_valid_pdf_stream(): void
    {
        $invoice = $this->getTestInvoice();
        $orderCurrencyCode = 'AED';

        $html = view('shop::customers.account.orders.pdf', compact('invoice', 'orderCurrencyCode'))->render();

        $pdfOutput = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->set_option('isRemoteEnabled', true)
            ->output();

        $this->assertNotEmpty($pdfOutput);
        $this->assertStringStartsWith('%PDF-', $pdfOutput);
    }

    public function test_invoice_pdf_multipage_and_large_order_rendering(): void
    {
        $invoice = clone $this->getTestInvoice();
        $originalItem = $invoice->items->first();
        $items = collect();

        for ($i = 1; $i <= 35; $i++) {
            $item = clone $originalItem;
            $item->name = "Super Kawaii Luxury Collectible Product Item #{$i} - Limited Edition 2026";
            $item->qty = $i;
            $items->push($item);
        }

        $invoice->setRelation('items', $items);
        $orderCurrencyCode = 'AED';

        $html = view('shop::customers.account.orders.pdf', compact('invoice', 'orderCurrencyCode'))->render();

        $pdfOutput = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->set_option('isRemoteEnabled', true)
            ->output();

        $this->assertNotEmpty($pdfOutput);
        $this->assertStringStartsWith('%PDF-', $pdfOutput);
        $this->assertGreaterThan(50000, strlen($pdfOutput));
    }
}
