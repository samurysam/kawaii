<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.reviews.title')
    </x-slot>

    <!-- Sidebar Navigation -->
    <x-shop::layouts.account.navigation />

    <!-- Main Content Card -->
    <div class="kb-dash-main-card">
        <!-- Page Header -->
        <div class="kb-dash-card-head">
            <div class="kb-dash-card-head-left">
                <div class="kb-dash-card-icon-box">
                    <span>⭐</span>
                </div>
                <div>
                    <h1 class="kb-dash-card-title">
                        @lang('shop::app.customers.account.reviews.title')
                    </h1>
                    <p class="kb-dash-card-subtitle">
                        Your product reviews and verified ratings
                    </p>
                </div>
            </div>
        </div>

        <!-- Reviews Vue Component -->
        <v-product-reviews>
            <!-- Reviews Shimmer Effect -->
            <x-shop::shimmer.customers.account.reviews :count="4" />
        </v-product-reviews>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-product-reviews-template"
        >
            <div>
                <!-- Reviews Shimmer Effect -->
                <template v-if="isLoading">
                    <x-shop::shimmer.customers.account.reviews :count="4" />
                </template>

                {!! view_render_event('bagisto.shop.customers.account.reviews.list.before', ['reviews' => $reviews]) !!}

                <!-- Reviews Information -->
                <template v-else>
                    @if (! $reviews->isEmpty())
                        <!-- Review Information -->
                        <div class="grid gap-4">
                            @foreach($reviews as $review)
                                <a
                                    href="{{ route('shop.product_or_category.index', $review->product->url_key) }}"
                                    id="{{ $review->product_id }}"
                                    aria-label="{{ $review->title }}"
                                    class="block no-underline"
                                >
                                    <div class="flex gap-5 rounded-[22px] border-[1.5px] border-[#f2d7df] bg-white p-5 shadow-[0_6px_20px_rgba(237,110,152,0.04)] transition-all hover:border-[#e7cf9a] hover:shadow-[0_10px_28px_rgba(237,110,152,0.1)] max-md:flex-col">
                                        {!! view_render_event('bagisto.shop.customers.account.reviews.image.before', ['reviews' => $reviews]) !!}

                                        <div class="shrink-0">
                                            <x-shop::media.images.lazy
                                                class="h-28 w-28 rounded-[16px] border border-[#fae8ef] object-cover max-md:h-20 max-md:w-20 shadow-sm"
                                                src="{{ $review->product->base_image_url ?? bagisto_asset('images/small-product-placeholder.webp') }}"
                                                alt="Review Image"                   
                                            />
                                        </div>

                                        {!! view_render_event('bagisto.shop.customers.account.reviews.image.after', ['reviews' => $reviews]) !!}

                                        <div class="w-full flex-1">
                                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-[#fae8ef] pb-3">
                                                <div>
                                                    {!! view_render_event('bagisto.shop.customers.account.reviews.title.before', ['reviews' => $reviews]) !!}

                                                    <h2
                                                        class="font-['Playfair_Display'] text-[17px] font-bold text-[#3f2b2d]"
                                                        v-pre
                                                    >
                                                        {{ $review->title }}
                                                    </h2>

                                                    {!! view_render_event('bagisto.shop.customers.account.reviews.title.after', ['reviews' => $reviews]) !!}
                                                </div>
        
                                                {!! view_render_event('bagisto.shop.customers.account.reviews.rating.before', ['reviews' => $reviews]) !!}

                                                <div class="flex items-center gap-1 rounded-full bg-[#fff8eb] px-3 py-1 border border-[#fdecd0]">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span class="text-sm {{ $review->rating >= $i ? 'text-amber-400' : 'text-zinc-300' }}">★</span>
                                                    @endfor
                                                    <span class="text-xs font-bold text-amber-700 ml-1">{{ $review->rating }}/5</span>
                                                </div>

                                                {!! view_render_event('bagisto.shop.customers.account.reviews.rating.after', ['reviews' => $reviews]) !!}
                                            </div>
        
                                            {!! view_render_event('bagisto.shop.customers.account.reviews.created_at.before', ['reviews' => $reviews]) !!}

                                            <div class="mt-2 flex items-center gap-2 text-xs font-semibold text-[#7c6770]">
                                                <span>Reviewed on:</span>
                                                <span class="rounded-full bg-[#fff0f5] border border-[#f2d7df] px-2.5 py-0.5 text-[#d95d86]" v-pre>
                                                    {{ $review->created_at }}
                                                </span>
                                            </div>
        
                                            {!! view_render_event('bagisto.shop.customers.account.reviews.created_at.after', ['reviews' => $reviews]) !!}

                                            {!! view_render_event('bagisto.shop.customers.account.reviews.comment.before', ['reviews' => $reviews]) !!}

                                            <p
                                                class="mt-3 text-sm font-semibold leading-relaxed text-[#3f2b2d]"
                                                v-pre
                                            >
                                                "{{ $review->comment }}"
                                            </p>

                                            {!! view_render_event('bagisto.shop.customers.account.reviews.comment.after', ['reviews' => $reviews]) !!}
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $reviews->links() }}
                            </div>
                        </div>
                    @else
                        <!-- Review Empty Page -->
                        <div class="m-auto grid w-full place-content-center items-center justify-items-center py-16 text-center">
                            <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[#fff0f5] border border-[#f2d7df] shadow-inner mb-4">
                                <span class="text-4xl">⭐</span>
                            </div>

                            <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#3f2b2d] mb-1">
                                @lang('shop::app.customers.account.reviews.empty-review')
                            </h2>

                            <p class="text-sm font-semibold text-[#7c6770] max-w-sm">
                                You haven't written any reviews yet. Share your experience with products you've purchased!
                            </p>
                        </div>
                    @endif
                </template>

                {!! view_render_event('bagisto.shop.customers.account.reviews.list.after', ['reviews' => $reviews]) !!}

            </div>
        </script>

        <script type="module">
            app.component("v-product-reviews", {
                template: '#v-product-reviews-template',

                data() {
                    return {
                        isLoading: true,
                    };
                },

                mounted() {
                    this.get();
                },

                methods: {
                    get() {
                        this.$axios.get("{{ route('shop.customers.account.reviews.index') }}")
                            .then(response => {
                                this.isLoading = false;
                            })
                            .catch(error => {});
                    },
                },
            });
        </script>
    @endpushOnce
</x-shop::layouts.account>
