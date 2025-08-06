<div class="max-w-7xl mx-auto mt-6 grid grid-cols-1 md:grid-cols-12 gap-6 px-4">

    {{-- Left Column (Main Content) --}}
    <div class="md:col-span-8 space-y-4">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-600 mb-2">
            <a href="{{ route('photo-news.index') }}" class="text-red-600 hover:underline">
                <i class="fas fa-home"></i> হোম
            </a> / 
            <a href="{{ route('photo-news.index') }}" class="text-red-600 hover:underline">
                ফটো গ্যালারি
            </a> / 
            <span class="text-gray-700">{{ $photoNews->title }}</span>
        </nav>

        {{-- Title --}}
        <h1 class="text-2xl font-bold text-gray-800">{{ $photoNews->title }}</h1>

        {{-- Main Thumbnail --}}
        @if ($photoNews->main_thumbnail)
            <img src="{{ asset('storage/' . $photoNews->main_thumbnail) }}" class="w-full h-auto rounded shadow">
        @endif

        {{-- Description --}}
        @if ($photoNews->description)
            <div class="text-gray-700 leading-relaxed mt-2">
                {!! nl2br(e($photoNews->description)) !!}
            </div>
        @endif

        {{-- Divider --}}
        <hr class="my-4 border-t-2 border-red-500">

        {{-- Gallery --}}
        <div class="space-y-6">
            @foreach ($photoNews->images as $image)
                <div>
                    <img src="{{ asset('storage/' . $image->image) }}" alt="Gallery Image"
                        class="w-full rounded shadow mb-2">
                    @if ($image->caption)
                        <p class="text-sm text-gray-600 italic">{{ $image->caption }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Right Column (Sidebar) --}}
    <div class="md:col-span-4 space-y-4">
        <livewire:frontend.popular-news-sidebar />
         @php

            $globalSideTwoAd = \App\Models\Advertisement::where('ad_name', 'Single Page Sidebar One')
                ->where('is_global', 1)
                ->where('status', 1)
                ->first();
        @endphp

        <div class="text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition my-4">
            

            @if ($globalSideTwoAd)
                {{-- Global ad --}}
                @if ($globalSideTwoAd->ad_image)
                    <a href="{{ $globalSideTwoAd->ad_url ?? '#' }}" target="_blank">
                        <img src="{{ asset('storage/' . $globalSideTwoAd->ad_image) }}" alt="{{$globalSideTwoAd->ad_name}}" class="object-fill">
                    </a>
                @elseif ($globalSideTwoAd->ad_code)
                    {!! $globalSideTwoAd->ad_code !!}
                @endif

            @else
                {{-- Fallback image --}}
                <img src="{{ asset('storage/fallback-ad/ad-450-456.png') }}" alt="Fallback Ad" class="object-fill">
            @endif


        </div>
    </div>

</div>
