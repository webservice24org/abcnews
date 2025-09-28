
<div class="container mx-auto max-w-5xl px-4 py-4">
    <livewire:frontend.under-construction-banner />
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

    
        {{-- Main Content --}}
        <div class="md:col-span-8 space-y-6">

            {{-- Breadcrumb --}}
            <div class="flex flex-wrap items-center text-sm text-gray-500 gap-2 bg-gray-100 p-2">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600">
                    {{-- Home Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v7a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
                    </svg>
                </a>

                @foreach ($news->categories as $cat)
                    <span>/</span>
                    <a href="{{ route('category.show', $cat->slug) }}" class="news_title font-bold" >
                        {{ $cat->name }}
                    </a>
                @endforeach

                @foreach ($news->subcategories as $sub)
                    <span>/</span>
                    <a href="{{ route('subcategory.show', $sub->slug) }}" class="news_title">
                        {{ $sub->name }}
                    </a>
                @endforeach
            </div>



            {{-- Title --}}
            <h1 class="text-xl font-bold " style="color:#8b0000;">{{ $news->top_title }}</h1>
            <h1 class="text-3xl font-bold text-black">{{ $news->news_title }}</h1>

            {{-- Author & Date --}}
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 mt-4 w-full">

                {{-- Author Info --}}
                <div class="flex items-center mb-2 md:mb-0">
                    @if ($news->user && $news->user->profile)
                        <img src="{{ asset('storage/' . $news->user->profile->profile_photo) }}" 
                            class="w-10 h-10 rounded-full mr-2" />
                    @endif
                    <span>
                        <a href="{{ route('news.user', $news->user->id) }}">
                            <strong>{{ $news->user->name ?? 'Unknown' }}</strong>
                        </a> | প্রকাশ: {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at) }}
                    </span>
                </div>

                {{-- Social Share & Embed --}}
                <div class="flex items-center gap-2 text-gray-700 flex-wrap">

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                    target="_blank"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 hover:bg-blue-600 hover:text-white transition"
                    title="Facebook">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>

                    {{-- X (Twitter) --}}
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($news->news_title) }}"
                    target="_blank"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 hover:bg-black hover:text-white transition"
                    title="Twitter">
                        <i class="fab fa-x-twitter text-sm"></i>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ urlencode(Request::fullUrl()) }}"
                    target="_blank"
                    class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 hover:bg-green-600 hover:text-white transition"
                    title="WhatsApp">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>

                    {{-- Copy Link --}}
                    <button onclick="navigator.clipboard.writeText('{{ Request::fullUrl() }}'); showToast('success', 'Link copied!');"
                            class="w-9 h-9 flex items-center justify-center rounded-full border border-gray-300 hover:bg-blue-500 hover:text-white transition"
                            title="Copy Link">
                        <i class="fas fa-link text-sm"></i>
                    </button>

                    {{-- Print --}}
                    <a href="{{ route('news.print', $news->slug) }}" target="_blank"
                    class="inline-flex items-center gap-1 px-3 py-1 border border-gray-400 text-sm rounded hover:bg-gray-100 text-gray-600">
                        <i class="fas fa-print"></i> প্রিন্ট
                    </a>

                    {{-- Copy Embed Code --}}
                    <button 
                        x-data="{ copied: false, code: `<iframe src='{{ route('news.embed', $news->slug) }}' width='600' height='400' frameborder='0' allowfullscreen></iframe>` }"
                        @click="navigator.clipboard.writeText(code).then(() => { copied = true; setTimeout(() => copied = false, 2000); })"
                        class="px-3 py-1 bg-[rgb(179,25,66)] text-white text-sm rounded hover:bg-pink-800 hover:cursor-pointer transition"
                        x-text="copied ? 'Copied!' : 'Embed'">
                    </button>

                </div>
            </div>




            {{-- Thumbnail --}}
            @if ($news->news_thumbnail)
                <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}"
                     class="w-full rounded shadow-sm my-4">
            @endif

            {{-- Description --}}
            <div class="news-show-descp">
                {!! $news->news_description !!}
            </div>

            




            {{-- Tags --}}
            @if($news->tags->isNotEmpty())
                <div class="mt-4">
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($news->tags as $tag)
                            <a href=""
                            class="text-xs bg-gray-100 border border-gray-300 px-2 py-1 rounded hover:bg-red-600 hover:text-white transition">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="hidden md:flex  items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-2">
                 @php
                    $globalBelowGridAd = \App\Models\Advertisement::where('ad_name', 'Single Page Below Article')
                        ->where('is_global', 1)
                        ->where('status', 1)
                        ->first();
                @endphp                            

                @if ($globalBelowGridAd)
                    @if ($globalBelowGridAd->ad_image)
                        <a href="{{ $globalBelowGridAd->ad_url ?? '#' }}" target="_blank">
                            <img src="{{ asset('storage/' . $globalBelowGridAd->ad_image) }}" alt="{{$globalBelowGridAd->ad_name}}" class="object-fill">
                        </a>
                    @elseif ($globalBelowGridAd->ad_code)
                        {!! $globalBelowGridAd->ad_code !!}
                    @endif

                @else
                    {{-- Fallback image --}}
                    <img src="{{ asset('storage/fallback-ad/home-section-below.png') }}" alt="Fallback Ad" class="object-fill">
                @endif
            </div>

            <div class="mt-2 text-black">
                <div class="flex justify-between items-center">
                    <h2 class="text-3xl">মন্তব্য করুন <span class="ml-2 text-red-500"><i class="fa-solid fa-comment"></i></span></h2>
                    <a href="{{ route('login') }}" class="text-md font-bold bg-red-500 p-2 text-white rounded">কমেন্ট করতে লগ ইন করুন</a>
                </div>
                <div>
                    <x-commenter::index :model="$news" />

                </div>

            </div>

        </div>

        {{-- Sidebar --}}
        <div class="md:col-span-4">
            <livewire:frontend.news-archive-search />
            <livewire:frontend.popular-news-sidebar />
            <livewire:frontend.latest-news-sidebar />

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

            <livewire:frontend.weather-widget />

        </div>

        
    </div>
    
    @if($relatedPosts->isNotEmpty())
        <section class="mt-10 bg-white shadow rounded p-4">
            <h3 class="text-xl font-bold  border-b-3 p-2 mb-6" style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }}; color: {{ $color->sec_title_color ?? '#fff' }}; border-color: {{ $color->sec_border_color ?? '#e7000b' }};">
                {{ $primaryCategory->name ?? 'সংবাদ' }} নিয়ে আরও পড়ুন
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedPosts as $post)
                    <div>
                        <a href="{{ route('news.show', $post->slug) }}">
                            <img src="{{ asset('storage/' . $post->news_thumbnail) }}"
                                alt="{{ $post->news_title }}"
                                class="w-full h-40 object-cover rounded mb-2">
                            <h4 class="text-md font-semibold news_title leading-snug">
                                {{ \Illuminate\Support\Str::limit($post->news_title, 70) }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ \App\Helpers\DateHelper::formatBanglaDateTime($post->created_at) }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
