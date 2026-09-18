<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Helpers\Indexers\Flat as FlatIndexer;
use Webkul\Product\Models\ProductImage;
use Webkul\Product\Repositories\ProductRepository;

if (! function_exists('mb_split')) {
    function mb_split(string $pattern, string $string, int $limit = -1): array|false
    {
        $delimiter = '/';
        $escaped = str_replace($delimiter, '\\'.$delimiter, $pattern);
        $result = preg_split($delimiter.$escaped.$delimiter.'u', $string, $limit);

        return $result !== false ? $result : false;
    }
}

class ImportShopifyProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kawaii:import-shopify-products {--file= : Path to the Shopify CSV file} {--force : Force overwrite existing products}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products, categories, and download images locally from a Shopify export CSV';

    /**
     * Category keywords map for automated classification.
     */
    protected array $categoryKeywords = [
        'sanrio-collection' => ['sanrio', 'hello kitty', 'kuromi', 'cinnamoroll', 'my melody', 'pompompurin', 'pochacco', 'hangyodon', 'cogimyun', 'tuxedo sam'],
        'love-and-deepspace-collection' => ['love and deepspace', 'sylus', 'zayne', 'xavier', 'rafayel', 'caleb', 'lads'],
        'blind-box' => ['blind box', 'blind bag', 'mystery box', 'mystery figures', 'nommi'],
        'popmart-collection' => ['pop mart', 'popmart', 'skullpanda', 'labubu', 'the monsters', 'crybaby', 'dimoo', 'hirono', 'molly', 'sweet bean'],
        'plushies' => ['plush', 'plushes', 'plushie', 'stuffed toy', 'cuddly', 'mascot holder', 'nommi'],
        'mofusand-collection' => ['mofusand'],
        'chiikawa-collection' => ['chiikawa', 'hachiware', 'usagi', 'momonga', 'furuhonya'],
        'pingu-collection' => ['pingu'],
        'sonny-angel-collection' => ['sonny angel', 'sonnyangel', 'hippers'],
        'labubus-outfit' => ['outfit labubu', 'labubu outfits', 'labubu sheep outfits'],
        'bag-charms' => ['bag charm', 'keychain', 'key ring', 'pendant', 'bag tag', 'phone charm', 'lanyard', 'charm'],
        'bags' => ['bag', 'tote bag', 'backpack', 'shoulder bag', 'crossbody', 'packbag'],
        'kawaii-parisu-merch' => ['kawaii parisu', 'parisu'],
        'kirby-collection' => ['kirby'],
        'sailor-moon-collection' => ['sailor moon'],
        'shirts' => ['shirt', 'shirts', 't-shirt'],
        'lifestyle-accessories' => ['lifestyle', 'accessories', 'lamp', 'night light', 'camera', 'digicam', 'bath bomb', 'diary book', 'magnet'],
    ];

    /**
     * Execute the console command.
     */
    public function handle(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        FlatIndexer $flatIndexer
    ): int {
        @ini_set('memory_limit', '1024M');
        @set_time_limit(0);
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

        File::ensureDirectoryExists(storage_path('framework/cache/data'));
        File::ensureDirectoryExists(storage_path('framework/sessions'));
        File::ensureDirectoryExists(storage_path('framework/views'));
        File::ensureDirectoryExists(storage_path('app/public/product'));
        File::ensureDirectoryExists(storage_path('logs'));

        $filePath = $this->option('file') ?: '/Users/samerkhan/Downloads/https___kawaiiblessings_ae__shopify.csv';

        if (! file_exists($filePath)) {
            $this->error("CSV file not found at: {$filePath}");

            return self::FAILURE;
        }

        $this->info("Parsing Shopify CSV: {$filePath}");

        $productsData = $this->parseShopifyCsv($filePath);
        $this->info('Found '.count($productsData).' unique products to process.');

        $this->info('1. Ensuring all categories exist in database...');
        $categoryMap = $this->ensureCategoriesExist($categoryRepository);

        $this->info('2. Importing products and downloading image assets...');
        $progressBar = $this->output->createProgressBar(count($productsData));
        $progressBar->start();

        $importedCount = 0;
        $imagesCount = 0;
        $failedCount = 0;

        foreach ($productsData as $handle => $productData) {
            try {
                $product = $this->importSingleProduct($productRepository, $productData, $categoryMap);

                if ($product) {
                    $downloadedImages = $this->downloadAndAttachImages($product->id, $productData['images']);
                    $imagesCount += $downloadedImages;
                    $importedCount++;
                }
            } catch (\Throwable $e) {
                $failedCount++;
                $this->newLine();
                $this->warn("Skipped product '{$handle}': {$e->getMessage()}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info('3. Re-indexing catalog (Flat, Price, Inventory)...');
        try {
            $flatIndexer->reindexFull();
            $this->call('indexer:index');
        } catch (\Throwable $e) {
            $this->warn("Indexing warning: {$e->getMessage()}");
        }

        $this->info("Successfully imported {$importedCount} products and saved {$imagesCount} local images. (Failed/Skipped: {$failedCount})");

        return self::SUCCESS;
    }

    /**
     * Parse the Shopify CSV export file.
     */
    protected function parseShopifyCsv(string $filePath): array
    {
        $products = [];
        $handle = fopen($filePath, 'r');

        if (! $handle) {
            return [];
        }

        $header = fgetcsv($handle);
        $headerMap = array_flip($header);

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row) || ! isset($row[$headerMap['Handle']])) {
                continue;
            }

            $productHandle = trim($row[$headerMap['Handle']]);
            if (! $productHandle) {
                continue;
            }

            if (! isset($products[$productHandle])) {
                $tags = ! empty($row[$headerMap['Tags']])
                    ? array_map('trim', explode(',', $row[$headerMap['Tags']]))
                    : [];

                $products[$productHandle] = [
                    'handle' => $productHandle,
                    'title' => trim($row[$headerMap['Title']] ?? ''),
                    'body_html' => trim($row[$headerMap['Body (HTML)']] ?? ''),
                    'vendor' => trim($row[$headerMap['Vendor']] ?? 'Kawaii Blessings'),
                    'type' => trim($row[$headerMap['Type']] ?? ''),
                    'tags' => $tags,
                    'seo_title' => trim($row[$headerMap['SEO Title']] ?? ''),
                    'seo_description' => trim($row[$headerMap['SEO Description']] ?? ''),
                    'variants' => [],
                    'images' => [],
                ];
            }

            $opt1Val = trim($row[$headerMap['Option1 Value']] ?? '');
            if ($opt1Val !== '') {
                $products[$productHandle]['variants'][] = [
                    'opt1_name' => trim($row[$headerMap['Option1 Name']] ?? ''),
                    'opt1_val' => $opt1Val,
                    'price' => (float) ($row[$headerMap['Variant Price']] ?? 0),
                    'compare_at_price' => (float) ($row[$headerMap['Variant Compare At Price']] ?? 0),
                    'sku' => trim($row[$headerMap['Variant SKU']] ?? ''),
                    'grams' => (float) ($row[$headerMap['Variant Grams']] ?? 0),
                    'image' => trim($row[$headerMap['Variant Image']] ?? ''),
                ];
            }

            $imgSrc = trim($row[$headerMap['Image Src']] ?? '');
            if ($imgSrc && ! in_array($imgSrc, array_column($products[$productHandle]['images'], 'src'))) {
                $products[$productHandle]['images'][] = [
                    'src' => $imgSrc,
                    'position' => (int) ($row[$headerMap['Image Position']] ?? 1),
                    'alt' => trim($row[$headerMap['Image Alt Text']] ?? ''),
                ];
            }
        }

        fclose($handle);

        return $products;
    }

    /**
     * Ensure all necessary store categories exist.
     */
    protected function ensureCategoriesExist(CategoryRepository $categoryRepository): array
    {
        $categoriesDefinition = [
            'sanrio-collection' => ['name' => 'Sanrio Collection', 'description' => 'Explore authentic Sanrio character merchandise including Hello Kitty, Cinnamoroll, Kuromi, My Melody, Pompompurin, Pochacco, and more in the UAE.'],
            'love-and-deepspace-collection' => ['name' => 'Love and Deepspace Collection', 'description' => 'Official and authentic Love and Deepspace merchandise, plushes, bags, and collector accessories featuring Sylus, Zayne, Xavier, Rafayel, and Caleb.'],
            'blind-box' => ['name' => 'Blind Box', 'description' => 'Discover surprise mystery figures and collectible blind boxes from top designer toy brands.'],
            'popmart-collection' => ['name' => 'Popmart Collection', 'description' => '100% authentic Popmart figures, plush pendants, Skullpanda, Labubu, Dimoo, Crybaby, Hirono, and Molly.'],
            'plushies' => ['name' => 'Plushies', 'description' => 'Soft, huggable, authentic plushies and cuddly character companions.'],
            'mofusand-collection' => ['name' => 'Mofusand collection', 'description' => 'Adorable feline creations from Mofusand, cat costumed plushies, blind boxes, and accessories.'],
            'chiikawa-collection' => ['name' => 'Chiikawa collection', 'description' => 'Charming Chiikawa, Hachiware, Usagi, and Momonga plushies, keychains, and figurines.'],
            'pingu-collection' => ['name' => 'Pingu Collection', 'description' => 'Playful, nostalgic Pingu character collectibles, plush bags, and blind boxes.'],
            'sonny-angel-collection' => ['name' => 'Sonny Angel collection', 'description' => 'Authentic Sonny Angel mini figures, Hippers series, Strawberry Love, and limited drops.'],
            'labubus-outfit' => ['name' => "Labubu's outfit", 'description' => 'Cute outfits, costumes, and miniature clothing accessories tailored for Labubu plush figures.'],
            'bag-charms' => ['name' => 'Bag Charms', 'description' => 'Elevate your bags with authentic plush keychains, acrylic charms, and mascot holders.'],
            'bags' => ['name' => 'Bags', 'description' => 'Kawaii tote bags, canvas carryalls, backpacks, and Maison de FLEUR ribbon bags.'],
            'kawaii-parisu-merch' => ['name' => 'Kawaii Parisu Merch', 'description' => 'Original Kawaii Parisu exclusive merchandise, character bags, and adorable shirts.'],
            'kirby-collection' => ['name' => 'Kirby Collection', 'description' => 'Pink, starry Kirby plushies, mini figurines, and baguette bags.'],
            'sailor-moon-collection' => ['name' => 'Sailor Moon Collection', 'description' => 'Magical Sailor Moon crystal star crossbody bags, accessories, and collector items.'],
            'shirts' => ['name' => 'Shirts', 'description' => 'Cute Japanese kawaii t-shirts and wearable merchandise.'],
            'lifestyle-accessories' => ['name' => 'Lifestyle & Accessories', 'description' => 'Night lights, mini digital cameras, stationery, bath bombs, and magnetic ornaments.'],
        ];

        $categoryMap = [];

        foreach ($categoriesDefinition as $slug => $def) {
            $existing = DB::table('category_translations')->where('slug', $slug)->first();

            if ($existing) {
                $categoryMap[$slug] = $existing->category_id;
            } else {
                $newCat = $categoryRepository->create([
                    'position' => count($categoryMap) + 1,
                    'status' => 1,
                    'display_mode' => 'products_and_description',
                    'parent_id' => 1,
                    'en' => [
                        'name' => $def['name'],
                        'slug' => $slug,
                        'description' => $def['description'],
                        'meta_title' => $def['name'].' | Kawaii Blessings UAE',
                        'meta_description' => $def['description'],
                        'meta_keywords' => $def['name'].', Kawaii Blessings, UAE, Dubai, KeynoStore',
                    ],
                ]);

                $categoryMap[$slug] = $newCat->id;
            }
        }

        return $categoryMap;
    }

    /**
     * Import a single product into Bagisto.
     */
    protected function importSingleProduct(ProductRepository $productRepository, array $productData, array $categoryMap)
    {
        $handle = $productData['handle'];
        $title = $productData['title'] ?: ucwords(str_replace('-', ' ', $handle));
        $sku = 'KB-'.strtoupper(Str::slug($handle, '-'));

        $primaryVariant = $productData['variants'][0] ?? [];
        $price = (float) ($primaryVariant['price'] ?? 0);
        $compareAtPrice = (float) ($primaryVariant['compare_at_price'] ?? 0);

        $regularPrice = $price;
        $specialPrice = null;

        if ($compareAtPrice > $price && $price > 0) {
            $regularPrice = $compareAtPrice;
            $specialPrice = $price;
        }

        $weight = isset($primaryVariant['grams']) && $primaryVariant['grams'] > 0
            ? round($primaryVariant['grams'] / 1000, 3)
            : 0.1;

        $matchedCategoryIds = $this->matchCategoryIds($productData, $categoryMap);

        $description = ! empty($productData['body_html'])
            ? $productData['body_html']
            : "<p>{$title} — Authentic Kawaii Blessings boutique merchandise.</p>";

        $shortDescription = Str::limit(strip_tags($description), 160);

        $existingProduct = $productRepository->findOneByField('sku', $sku);

        if (! $existingProduct) {
            $existingProduct = $productRepository->create([
                'type' => 'simple',
                'attribute_family_id' => 1,
                'sku' => $sku,
            ]);
        }

        $productRepository->update([
            'sku' => $sku,
            'name' => $title,
            'url_key' => $handle,
            'short_description' => $shortDescription,
            'description' => $description,
            'price' => $regularPrice,
            'special_price' => $specialPrice,
            'weight' => $weight,
            'status' => 1,
            'visible_individually' => 1,
            'guest_checkout' => 1,
            'new' => 1,
            'featured' => 0,
            'manage_stock' => 1,
            'channels' => [1],
            'categories' => $matchedCategoryIds,
            'inventories' => [1 => 10],
            'meta_title' => $productData['seo_title'] ?: "{$title} | Kawaii Blessings",
            'meta_description' => $productData['seo_description'] ?: $shortDescription,
            'meta_keywords' => implode(', ', array_merge($productData['tags'], ['Kawaii Blessings', 'UAE'])),
        ], $existingProduct->id);

        return $existingProduct;
    }

    /**
     * Download images from Shopify and attach to product.
     */
    protected function downloadAndAttachImages(int $productId, array $images): int
    {
        $downloadedCount = 0;
        $existingImagePaths = DB::table('product_images')->where('product_id', $productId)->pluck('path')->toArray();

        foreach ($images as $img) {
            $src = $img['src'];
            $pos = (int) ($img['position'] ?: 1);

            $urlWithoutQuery = strtok($src, '?');
            $originalFilename = basename($urlWithoutQuery);
            $cleanFilename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)).'.'.(pathinfo($originalFilename, PATHINFO_EXTENSION) ?: 'jpg');
            $storagePath = "product/{$productId}/{$cleanFilename}";

            if (in_array($storagePath, $existingImagePaths) && Storage::disk('public')->exists($storagePath)) {
                continue;
            }

            try {
                $response = Http::timeout(20)->retry(2, 500)->get($src);

                if ($response->successful()) {
                    Storage::disk('public')->put($storagePath, $response->body());

                    ProductImage::create([
                        'product_id' => $productId,
                        'path' => $storagePath,
                        'position' => $pos,
                        'type' => 'images',
                    ]);

                    $downloadedCount++;
                }
            } catch (\Throwable $e) {
                // Ignore transient network errors and continue
            }
        }

        return $downloadedCount;
    }

    /**
     * Match product tags, title, and handle to category IDs.
     */
    protected function matchCategoryIds(array $productData, array $categoryMap): array
    {
        $searchString = strtolower($productData['title'].' '.$productData['handle'].' '.implode(' ', $productData['tags']));
        $categoryIds = [];

        foreach ($this->categoryKeywords as $slug => $keywords) {
            if (isset($categoryMap[$slug])) {
                foreach ($keywords as $kw) {
                    if (str_contains($searchString, $kw)) {
                        $categoryIds[] = $categoryMap[$slug];
                        break;
                    }
                }
            }
        }

        if (empty($categoryIds)) {
            $categoryIds[] = $categoryMap['blind-box'] ?? 4;
        }

        return array_unique($categoryIds);
    }
}
