<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Webkul\Faker\Helpers\Product as ProductFaker;

use function Pest\Laravel\put;

it('should persist newly uploaded product images and videos on product update', function () {
    Storage::fake();

    $product = (new ProductFaker)->getSimpleProductFactory()->create();

    $this->loginAsAdmin();

    put(route('admin.catalog.products.update', $product->id), [
        'sku' => $product->sku,
        'url_key' => $product->url_key,
        'name' => fake()->words(3, true),
        'short_description' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'price' => 100,
        'weight' => 1,
        'channel' => core()->getCurrentChannelCode(),
        'locale' => app()->getLocale(),
        'images' => [
            'files' => [
                'image_0' => UploadedFile::fake()->image('product.jpg', 20, 20),
            ],
            'meta' => [
                'image_0' => [
                    'alt_text' => 'Product image alt',
                    'file_name' => 'Product Image',
                ],
            ],
        ],
        'videos' => [
            'files' => [
                'video_0' => UploadedFile::fake()->create('product.mp4', 8, 'video/mp4'),
            ],
            'meta' => [
                'video_0' => [
                    'file_name' => 'Product Video',
                ],
            ],
        ],
    ])->assertRedirect(route('admin.catalog.products.index'));

    $product = $product->fresh();

    expect($product->images)->toHaveCount(1)
        ->and($product->videos)->toHaveCount(1)
        ->and($product->images->first()->path)->toBe('product/'.$product->id.'/product-image.webp')
        ->and($product->videos->first()->path)->toBe('product/'.$product->id.'/product-video.mp4');
});
