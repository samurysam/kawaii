<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShopifyProductImportTest extends TestCase
{
    /**
     * Test products and categories are imported in the database.
     */
    public function test_imported_products_and_categories_exist(): void
    {
        $productsCount = DB::table('products')->count();
        $this->assertGreaterThanOrEqual(134, $productsCount);

        $productFlatCount = DB::table('product_flat')->count();
        $this->assertGreaterThanOrEqual(134, $productFlatCount);

        $categoriesCount = DB::table('categories')->count();
        $this->assertGreaterThanOrEqual(17, $categoriesCount);

        $imagesCount = DB::table('product_images')->count();
        $this->assertGreaterThanOrEqual(700, $imagesCount);
    }

    /**
     * Test that product images are stored locally in disk storage.
     */
    public function test_product_images_are_stored_locally(): void
    {
        $sampleImage = DB::table('product_images')->first();
        $this->assertNotNull($sampleImage);
        $this->assertStringStartsWith('product/', $sampleImage->path);

        $exists = Storage::disk('public')->exists($sampleImage->path);
        $this->assertTrue($exists);
    }

    /**
     * Test sample product data integrity and category mapping.
     */
    public function test_sample_product_attributes_and_pricing(): void
    {
        $productFlat = DB::table('product_flat')
            ->where('url_key', 'mofusand-x-sanrio-kiramekko-fluffy-kittens-vinyl-keychain-1-blind-box-pre-order')
            ->first();

        $this->assertNotNull($productFlat);
        $this->assertEquals('225.0000', $productFlat->price);
        $this->assertEquals(10, $productFlat->quantity);
        $this->assertStringContainsString('Sanrio Collection', $productFlat->category_name);
        $this->assertStringContainsString('Blind Box', $productFlat->category_name);
    }
}
