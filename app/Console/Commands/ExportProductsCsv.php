<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\Product;

class ExportProductsCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kawaii:export-products {--file= : Destination path for the exported CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all products and comprehensive details from the local database to an Excel-compatible CSV';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $defaultPath = base_path('kawaii_products_export.csv');
        $outputPath = $this->option('file') ?: $defaultPath;

        $this->info("Starting export of all products to: {$outputPath}");

        $products = Product::with([
            'images',
            'categories',
            'inventories',
            'attribute_family',
        ])->get();

        $productFlatMap = DB::table('product_flat')
            ->where('locale', 'en')
            ->get()
            ->keyBy('product_id');

        $headers = [
            'Product ID',
            'SKU',
            'Name',
            'URL Key',
            'Type',
            'Status',
            'Price (AED)',
            'Special Price (AED)',
            'Special Price From',
            'Special Price To',
            'Quantity / Total Stock',
            'Stock Status',
            'Weight (kg)',
            'Categories',
            'Category Slugs',
            'Attribute Family',
            'Short Description',
            'Description (HTML)',
            'Meta Title',
            'Meta Description',
            'Meta Keywords',
            'Primary Image URL',
            'All Image URLs',
            'Images Count',
            'Is New',
            'Is Featured',
            'Visible Individually',
            'Created At',
            'Updated At',
        ];

        $handle = fopen($outputPath, 'w');
        if (! $handle) {
            $this->error("Failed to open file for writing at: {$outputPath}");

            return self::FAILURE;
        }

        // Add UTF-8 BOM for Microsoft Excel compatibility
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($handle, $headers);

        $baseUrl = config('app.url', 'http://127.0.0.1:8000');
        $exportedCount = 0;

        foreach ($products as $product) {
            $flat = $productFlatMap->get($product->id);

            $totalQty = $product->inventories->sum('qty');
            $stockStatus = $totalQty > 0 ? 'In Stock' : 'Out of Stock';

            $categoryNames = $product->categories->pluck('name')->filter()->join(', ');
            $categorySlugs = $product->categories->pluck('slug')->filter()->join(', ');

            $imageUrls = $product->images->map(function ($img) use ($baseUrl) {
                return $baseUrl.'/storage/'.$img->path;
            })->toArray();

            $primaryImageUrl = $imageUrls[0] ?? '';
            $allImageUrlsString = implode(' ; ', $imageUrls);

            $name = $flat->name ?? ($product->name ?? '');
            $urlKey = $flat->url_key ?? ($product->url_key ?? '');
            $price = $flat->price ?? ($product->price ?? 0);
            $specialPrice = $flat->special_price ?? ($product->special_price ?? '');
            $specialFrom = $flat->special_price_from ?? '';
            $specialTo = $flat->special_price_to ?? '';
            $weight = $flat->weight ?? ($product->weight ?? 0);
            $shortDesc = $flat->short_description ?? ($product->short_description ?? '');
            $description = $flat->description ?? ($product->description ?? '');
            $metaTitle = $flat->meta_title ?? ($product->meta_title ?? '');
            $metaDesc = $flat->meta_description ?? ($product->meta_description ?? '');
            $metaKeywords = $flat->meta_keywords ?? ($product->meta_keywords ?? '');
            $status = ($flat->status ?? $product->status) ? 'Active' : 'Disabled';
            $isNew = ($flat->new ?? $product->new) ? 'Yes' : 'No';
            $isFeatured = ($flat->featured ?? $product->featured) ? 'Yes' : 'No';
            $visibleIndividually = ($flat->visible_individually ?? $product->visible_individually) ? 'Yes' : 'No';

            $row = [
                $product->id,
                $product->sku,
                $name,
                $urlKey,
                $product->type,
                $status,
                is_numeric($price) ? number_format((float) $price, 2, '.', '') : $price,
                is_numeric($specialPrice) && $specialPrice > 0 ? number_format((float) $specialPrice, 2, '.', '') : '',
                $specialFrom,
                $specialTo,
                $totalQty,
                $stockStatus,
                $weight,
                $categoryNames,
                $categorySlugs,
                $product->attribute_family?->name ?? 'Default',
                $shortDesc,
                $description,
                $metaTitle,
                $metaDesc,
                $metaKeywords,
                $primaryImageUrl,
                $allImageUrlsString,
                count($imageUrls),
                $isNew,
                $isFeatured,
                $visibleIndividually,
                $product->created_at?->toDateTimeString() ?? '',
                $product->updated_at?->toDateTimeString() ?? '',
            ];

            fputcsv($handle, $row);
            $exportedCount++;
        }

        fclose($handle);

        $this->info("Successfully exported {$exportedCount} products to {$outputPath}");

        return self::SUCCESS;
    }
}
