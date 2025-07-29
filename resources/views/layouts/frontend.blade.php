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


    @include('partials.head')
    @livewireStyles
</head>
<body class="bg-white text-gray-800">

    
        <livewire:frontend.frontend-menu />
    

    <!-- Content -->
     <main class="max-w-7xl mx-auto px-4 py-4">
        {{ $slot }}
    </main>

    
    @livewireScripts

    <div 
    x-data="{ showTopBtn: false }"
    x-init="window.addEventListener('scroll', () => {
        showTopBtn = window.scrollY > 100
    })"
>
    <!-- Go to Top Button -->
    <button
        x-show="showTopBtn"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-transition
        class="fixed bottom-6 right-6 z-50 p-3 rounded-full bg-red-600 text-white shadow-lg hover:bg-red-700 transition"
        title="Go to Top"
    >
        <!-- Chevron Up Icon -->
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.79l-3.71 3.98a.75.75 0 01-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
        </svg>
    </button>
</div>


</body>
</html>
