@php
    $htmlContent = $page->html_content ?? '';

    $isFullHtmlDocument = str_contains(strtolower($htmlContent), '<!doctype html')
        || preg_match('/<html[\s>]/i', $htmlContent);

    $pageTitle = $page->meta_title;

    $pageDescription = $page->meta_description;

    $pageKeywords = $page->meta_keywords;

    $pageStyles = [];

    $pageHeadLinks = [];

    $pageScripts = [];

    $pageBodyContent = $htmlContent;

    if ($isFullHtmlDocument) {
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $htmlContent, $matches)) {
            $pageTitle = trim(strip_tags($matches[1])) ?: $pageTitle;
        }

        if (preg_match('/<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']*)["\']/is', $htmlContent, $matches)) {
            $pageDescription = $matches[1] ?: $pageDescription;
        }

        if (preg_match('/<meta[^>]+name=["\']keywords["\'][^>]+content=["\']([^"\']*)["\']/is', $htmlContent, $matches)) {
            $pageKeywords = $matches[1] ?: $pageKeywords;
        }

        preg_match_all('/<style\b[^>]*>.*?<\/style>/is', $htmlContent, $matches);
        $pageStyles = $matches[0] ?? [];

        preg_match_all('/<link\b[^>]*rel=["\']stylesheet["\'][^>]*>/is', $htmlContent, $matches);
        $pageHeadLinks = $matches[0] ?? [];

        preg_match_all('/<script\b[^>]*>.*?<\/script>/is', $htmlContent, $matches);
        $pageScripts = $matches[0] ?? [];

        if (preg_match('/<body\b[^>]*>(.*)<\/body>/is', $htmlContent, $matches)) {
            $pageBodyContent = $matches[1];
        }

        $pageBodyContent = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $pageBodyContent) ?? $pageBodyContent;
        $pageBodyContent = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $pageBodyContent) ?? $pageBodyContent;
        $pageBodyContent = preg_replace('/<\/?(?:html|head|body)\b[^>]*>/is', '', $pageBodyContent) ?? $pageBodyContent;
    }
@endphp

<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="{{ $pageTitle }}" />

    <meta name="description" content="{{ $pageDescription }}" />

    <meta name="keywords" content="{{ $pageKeywords }}" />
@endPush

@push('styles')
    @foreach ($pageHeadLinks as $stylesheetLink)
        {!! $stylesheetLink !!}
    @endforeach

    @foreach ($pageStyles as $styleBlock)
        {!! $styleBlock !!}
    @endforeach

    <style>
        .kb-cms-page .reveal,
        .kb-cms-page [class*="reveal"],
        .kb-cms-page .kb-social-grid .kb-social,
        .kb-cms-page .kb-points li,
        .kb-cms-page .kb-benefit,
        .kb-cms-page .kb-disclosure,
        .kb-cms-page .kb-contact,
        .container .reveal,
        .container [class*="reveal"] {
            opacity: 1 !important;
            transform: none !important;
            visibility: visible !important;
        }
    </style>
@endpush

@if ($pageScripts)
    @push('scripts')
        @foreach ($pageScripts as $scriptBlock)
            {!! $scriptBlock !!}
        @endforeach
    @endpush
@endif

@push('scripts')
    <script>
        (function() {
            function revealAll() {
                document.querySelectorAll('.reveal, [class*="reveal"]').forEach(function(el) {
                    el.classList.add('is-visible');
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', revealAll);
            } else {
                revealAll();
            }

            window.addEventListener('load', revealAll);
        })();
    </script>
@endpush

<!-- Page Layout -->
<x-shop::layouts :has-feature="false">
    <!-- Page Title -->
    <x-slot:title>
        {{ $pageTitle }}
    </x-slot>

    <!-- Page Content -->
    @if ($isFullHtmlDocument)
        <div v-pre class="kb-cms-page">
            {!! $pageBodyContent !!}
        </div>
    @else
        <div v-pre class="container mt-8 px-[60px] max-lg:px-8">
            {!! $pageBodyContent !!}
        </div>
    @endif
</x-shop::layouts>
