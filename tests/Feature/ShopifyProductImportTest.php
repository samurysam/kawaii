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

    /**
     * Test /categories directory page renders successfully.
     */
    public function test_categories_directory_page_renders(): void
    {
        $response = $this->get('/categories');
        $response->assertStatus(200);
        $response->assertSee('Shop by Category');
        $response->assertSee('Sanrio Collection');
        $response->assertSee('Popmart Collection');
    }

    /**
     * Test /search with sorting parameters renders without PHP 8.4 deprecation errors.
     */
    public function test_search_with_sort_params_renders(): void
    {
        $response = $this->get('/search?sort=created_at-desc');
        $response->assertStatus(200);

        $apiResponse = $this->get('/api/products?sort=created_at-desc');
        $apiResponse->assertStatus(200);
    }

    /**
     * Test /page/authenticity and /page/packaging CMS pages render.
     */
    public function test_authenticity_and_packaging_cms_pages_render(): void
    {
        $authResponse = $this->get('/page/authenticity');
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Authenticity Guarantee');

        $packResponse = $this->get('/page/packaging');
        $packResponse->assertStatus(200);
        $packResponse->assertSee('Kawaii Safe Packaging');
    }

    /**
     * Test Just Landed section has multi-row grid styles and limit 16.
     */
    public function test_just_landed_grid_configuration(): void
    {
        $section = DB::table('theme_section_translations')
            ->where('section_id', 207)
            ->where('locale', 'en')
            ->first();

        $this->assertNotNull($section);
        $this->assertStringContainsString('repeat(4, minmax(0, 1fr))', $section->options);
        $this->assertStringContainsString('limit=16', $section->options);
    }
}
