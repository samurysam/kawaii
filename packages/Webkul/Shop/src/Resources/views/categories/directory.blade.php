<!-- SEO Meta Content -->
@push('meta')
    <meta
        name="description"
        content="Explore authentic Kawaii Blessings collections including Sanrio, Pop Mart, Blind Boxes, Sonny Angel, Mofusand, Chiikawa, Plushies, Bag Charms and more."
    />

    <meta
        name="keywords"
        content="Kawaii Categories, Sanrio, Pop Mart, Blind Box, Sonny Angel, Chiikawa, Mofusand, Plushies, Bag Charms, UAE, Dubai"
    />
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        Shop by Category | Kawaii Blessings
    </x-slot>

    <!-- Breadcrumb -->
    <div class="container mt-6 px-[60px] max-lg:px-8 max-sm:px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('shop.home.index') }}" class="hover:text-[#ef789f] transition-colors">Home</a>
            <span class="text-gray-300">/</span>
            <span class="font-medium text-[#4a2e35]">Categories</span>
        </nav>
    </div>

    <!-- Category Directory Header -->
    <div class="container mt-6 px-[60px] max-lg:px-8 max-sm:px-4">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#fffafa] via-[#fff4f8] to-[#fce4ec] p-8 md:p-12 border border-[#f5d0dc] shadow-sm">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ef789f]/10 px-3.5 py-1 text-xs font-semibold tracking-wide text-[#ef789f]">
                    <span>✦</span> Official Collections <span>✦</span>
                </span>
                <h1 class="mt-4 text-3xl md:text-4xl font-bold tracking-tight text-[#4a2e35]">
                    Shop by Category <span class="text-[#ef789f]">♡</span>
                </h1>
                <p class="mt-3 text-base md:text-lg text-[#80616a]">
                    Explore authentic Japanese character goods, blind boxes, adorable plushies, and boutique collector treasures.
                </p>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="container my-10 px-[60px] max-lg:px-8 max-sm:px-4">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-6">
            @forelse ($categories as $index => $category)
                @php
                    $catImg = $category->logo_url
                        ?: ($category->banner_url
                        ?: ($category->products->first()?->images->first()?->url ?? ($category->products->first()?->base_image_url ?? '')));
                    $prodCount = $category->products()->count();
                @endphp
                <a
                    href="{{ url($category->slug) }}"
                    class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-[#f0d5dd] bg-white p-4 md:p-5 transition-all duration-300 hover:-translate-y-1.5 hover:border-[#ef789f] hover:shadow-[0_12px_30px_rgba(239,120,159,0.18)]"
                >
                    <div>
                        <!-- Thumbnail Image Container -->
                        <div class="relative aspect-square w-full overflow-hidden rounded-xl bg-gradient-to-b from-[#fff8fa] to-[#fff0f5] flex items-center justify-center p-3 border border-[#fae4ec]">
                            <!-- Number Badge -->
                            <span class="absolute top-2.5 left-2.5 z-10 flex h-6 w-6 items-center justify-center rounded-full bg-white/90 text-[10px] font-bold text-[#ef789f] shadow-sm">
                                {{ sprintf('%02d', $index + 1) }}
                            </span>

                            @if ($prodCount > 0)
                                <span class="absolute top-2.5 right-2.5 z-10 rounded-full bg-white/90 px-2 py-0.5 text-[10px] font-medium text-[#80616a] shadow-sm">
                                    {{ $prodCount }} items
                                </span>
                            @endif

                            @if ($catImg)
                                <img
                                    src="{{ $catImg }}"
                                    alt="{{ $category->name }}"
                                    loading="lazy"
                                    decoding="async"
                                    class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-110"
                                />
                            @else
                                <div class="flex flex-col items-center justify-center text-[#ef789f]">
                                    <span class="text-3xl font-bold">♡</span>
                                    <span class="mt-1 text-[11px] font-medium text-[#80616a]">Collection</span>
                                </div>
                            @endif
                        </div>

                        <h2 class="mt-4 text-base md:text-lg font-bold text-[#4a2e35] transition-colors group-hover:text-[#ef789f] text-center md:text-left">
                            {{ $category->name }}
                        </h2>

                        @if ($category->description)
                            <p class="mt-1.5 text-xs leading-relaxed text-[#80616a] line-clamp-2 hidden md:block">
                                {{ strip_tags($category->description) }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center justify-between border-t border-[#fce8ef] pt-3 text-xs font-semibold text-[#ef789f]">
                        <span>Explore</span>
                        <span class="transition-transform duration-300 group-hover:translate-x-1.5">→</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center">
                    <p class="text-base text-gray-500">No categories found.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-shop::layouts>
