<div class="grid grid-cols-12 gap-4">
    {{-- Left Column: Big Lead --}}
    @if($leadNews)
        <div class="col-span-12 md:col-span-6">
            <a href="{{ route('news.show', $leadNews->slug) }}" class="leadBlock block">
                <div class="overflow-hidden">
                    
                    <img src="{{ $leadNews->news_thumbnail 
                    ? asset('storage/' . $leadNews->news_thumbnail) 
                    : $defaultImage }}"
                    class="w-full h-60 object-cover">

                    <div class="p-4">
                        <h2 class="font-bold mb-2 hover:underline">{{ $leadNews->news_title }}</h2>
                        <p class="text-gray-700 mb-2">
                            {{ \Illuminate\Support\Str::words(strip_tags($leadNews->news_description), 40, '...') }}
                        </p>
                        <span class="text-gray-500 text-sm">
                            {{ \App\Helpers\DateHelper::formatBanglaDateTime($leadNews->created_at, false) }}
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @endif

    {{-- Right Column: 4 small lead news --}}
    <div class="col-span-12 md:col-span-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($rightTopNews as $news)
            <a href="{{ route('news.show', $news->slug) }}"
               class="flex md:block items-center gap-3 overflow-hidden p-2 md:p-0 rightBlock">
                {{-- Mobile: image left | Desktop: image top --}}
                
                <img src="{{ $news->news_thumbnail 
                        ? asset('storage/' . $news->news_thumbnail) 
                        : $defaultImage }}"
                class="w-24 h-20 object-cover md:w-full md:h-28">

                <div class="p-0 md:p-2">
                    <h2 class="font-semibold mb-1 hover:underline">{{ $news->news_title }}</h2>
                    <span class="text-gray-500 text-sm">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at, false) }}
                        
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Second Row: 4 news --}}
    <div class="col-span-12 grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
        @foreach($bottomNews as $news)
            <a href="{{ route('news.show', $news->slug) }}" class="overflow-hidden footerBlock border-t-2 border-gray-200 pt-2">
                {{-- Thumbnail: hidden on desktop, visible on mobile --}}
                
                     <img src="{{ $news->news_thumbnail 
              ? asset('storage/' . $news->news_thumbnail) 
              : $defaultImage }}"
                 class="w-full h-24 object-cover md:hidden">

                <div class="p-2">
                    <h2 class="font-semibold mb-1 hover:underline">{{ $news->news_title }}</h2>
                    <span class="text-gray-500 text-sm">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at, false) }}
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</div>
