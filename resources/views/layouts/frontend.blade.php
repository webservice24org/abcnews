<!DOCTYPE html>
<html lang="en">
<head>

    @if (!empty($siteInfo->meta_description))
        <meta name="description" content="{{ $siteInfo->meta_description }}">
    @endif

    @if (!empty($siteInfo->meta_tags))
        <meta name="keywords" content="{{ $siteInfo->meta_tags }}">
    @endif

    @if ($siteConnection = \App\Models\SiteConnection::first())
        @if ($siteConnection->google_verification)
            <meta name="google-site-verification" content="{{ $siteConnection->google_verification }}">
        @endif
        @if ($siteConnection->bing_verification)
            <meta name="msvalidate.01" content="{{ $siteConnection->bing_verification }}">
        @endif
        @if ($siteConnection->baidu_verification)
            <meta name="baidu-site-verification" content="{{ $siteConnection->baidu_verification }}">
        @endif
        @if ($siteConnection->pinterest_verification)
            <meta name="p:domain_verify" content="{{ $siteConnection->pinterest_verification }}">
        @endif
        @if ($siteConnection->yandex_verification)
            <meta name="yandex-verification" content="{{ $siteConnection->yandex_verification }}">
        @endif
    @endif

    @if(Route::currentRouteName() === 'news.show' && isset($news))
        <meta property="og:title" content="{{ $news->news_title }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($news->news_description), 150) }}">
        <meta property="og:image" content="{{ asset('storage/' . $news->news_thumbnail) }}">
        <meta property="og:url" content="{{ Request::fullUrl() }}">
        <meta property="og:type" content="article">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $news->news_title }}">
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($news->news_description), 150) }}">
        <meta name="twitter:image" content="{{ asset('storage/' . $news->news_thumbnail) }}">
    @endif



    @include('partials.head')
    @livewireStyles

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
    .news_title {
        transition: all 0.3s ease;
        color: {{ $color->title_color ?? '#e7000b' }};
        text-decoration: none;
        padding-bottom: 4px; /* space between text and underline */
        line-height: 1.5; /* line height for better readability */
    }
    .news_title:hover {
        color: {{ $color->title_hover_color ?? '#e7000b' }};
        text-decoration: underline solid; /* solid underline */
        text-underline-offset: 4px; /* distance between text and underline */
    }
</style>

 
    @php
        $customCode = Cache::remember('custom_code', 3600, function () {
            return \App\Models\CustomCode::first();
        });
    @endphp

    @if ($customCode && $customCode->custom_css)
        <style>
            {!! $customCode->custom_css !!}
        </style>
    @endif
</head>
<body class="bg-white text-gray-800">

        
    <livewire:frontend.frontend-menu />

    <main class="max-w-7xl mx-auto px-4 py-4">
        {{ $slot }}
    </main>

    <livewire:frontend.footer />


    @livewireScripts

    <div 
        x-data="{ showTopBtn: false }"
        x-init="window.addEventListener('scroll', () => {
        showTopBtn = window.scrollY > 100
        })">
        
        <button
            x-show="showTopBtn"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-transition
            class="fixed bottom-6 right-6 z-50 p-3 rounded-full shadow-lg hover:cursor-pointer transition"
            title="Go to Top"
            style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }}; color:{{$color->cat_btn_color ?? '#e7000b'}}"
        >
           
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.79l-3.71 3.98a.75.75 0 01-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
        </svg>
        </button>
    </div>


@if ($customCode && $customCode->custom_js)
    <script>
        {!! $customCode->custom_js !!}
    </script>
@endif
    
</body>
</html>






