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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($categories as $category)
                <a
                    href="{{ url($category->slug) }}"
                    class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-[#f0d5dd] bg-white p-6 transition-all duration-300 hover:-translate-y-1.5 hover:border-[#ef789f] hover:shadow-[0_12px_30px_rgba(239,120,159,0.18)]"
                >
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#fff0f5] text-[#ef789f] text-lg font-bold transition-transform duration-300 group-hover:scale-110">
                                ♡
                            </span>
                            <span class="text-xs font-semibold uppercase tracking-wider text-[#ef789f]/80">
                                Collection
                            </span>
                        </div>

                        <h2 class="mt-5 text-lg font-bold text-[#4a2e35] transition-colors group-hover:text-[#ef789f]">
                            {{ $category->name }}
                        </h2>

                        @if ($category->description)
                            <p class="mt-2 text-xs leading-relaxed text-[#80616a] line-clamp-3">
                                {{ strip_tags($category->description) }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-6 flex items-center justify-between border-t border-[#fce8ef] pt-4 text-xs font-semibold text-[#ef789f]">
                        <span>Explore Collection</span>
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
