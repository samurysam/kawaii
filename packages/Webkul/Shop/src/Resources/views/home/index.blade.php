@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

@push('scripts')
    @if(! empty($categories))
        <script>
            localStorage.setItem('categories', JSON.stringify(@json($categories)));
        </script>
    @endif
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Loop over the storefront sections -->
    @foreach ($sections as $section)
        @php ($data = $section->options) @endphp

        {{-- Only the types this page renders; the layout marks the ones it draws. --}}
        @php
            $marks = ($preview ?? false) && in_array($section->type, [
                $section::IMAGE_CAROUSEL,
                $section::STATIC_CONTENT,
                $section::CUSTOM_HTML,
                $section::CATEGORY_CAROUSEL,
                $section::PRODUCT_CAROUSEL,
            ]);
        @endphp

        @if ($marks)
            <div
                data-section-id="{{ $section->id }}"
                data-section-name="{{ $section->name }}"
            >
        @endif

        <!-- Static / Custom Content -->
        @switch ($section->type)
            @case ($section::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-shop::carousel
                    :options="$data"
                    aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                />

                @break
            @case ($section::STATIC_CONTENT)
                <!-- Push Style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {!! $data['css'] !!}
                        </style>
                    @endpush
                @endif

                <!-- Render HTML -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($section::CUSTOM_HTML)
                <!-- Custom HTML -->
                @if (! empty($data['html']))
                    @php
                        $rawHtml = $data['html'] ?? '';
                        preg_match_all('/<style\b[^>]*>(.*?)<\/style>/is', $rawHtml, $styleMatches);
                        preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $rawHtml, $scriptMatches);
                        $cleanMarkup = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $rawHtml);
                        $cleanMarkup = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $cleanMarkup);
                        $stylesString = implode("\n", $styleMatches[0] ?? []);
                        $scriptsString = implode("\n", $scriptMatches[0] ?? []);
                    @endphp

                    @if (! empty($stylesString))
                        @push ('styles')
                            {!! $stylesString !!}
                        @endpush
                    @endif

                    <div v-pre>
                        {!! $cleanMarkup !!}
                    </div>

                    @if (! empty($scriptsString))
                        @push ('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    setTimeout(function() {
                                        const container = document.createElement('div');
                                        container.innerHTML = {!! json_encode($scriptsString) !!};
                                        Array.from(container.querySelectorAll('script')).forEach(function(oldScript) {
                                            const newScript = document.createElement('script');
                                            Array.from(oldScript.attributes).forEach(function(attr) {
                                                newScript.setAttribute(attr.name, attr.value);
                                            });
                                            newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                                            document.body.appendChild(newScript);
                                        });
                                    }, 50);
                                });
                            </script>
                        @endpush
                    @endif
                @endif

                @break
            @case ($section::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($section::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch

        @if ($marks)
            </div>
        @endif
    @endforeach

    @if ($preview ?? false)
        @include('shop::home.preview-bridge')
    @endif
</x-shop::layouts>
