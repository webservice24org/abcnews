<section class="mb-10">
    <div class="flex justify-between items-center border-b-3 border-red-700 mb-4">
        <h2 class="text-2xl font-bold text-white bg-red-600 p-2 inline-block">{{ $title }}</h2>

        {{-- Read More Button --}}
        
        @if (!empty($categorySlug))
            <a href="{{ route('category.show', ['slug' => $categorySlug]) }}" class="text-sm text-white bg-red-600 hover:bg-red-700 px-4 py-1 rounded shadow-sm transition">আরও দেখুন</a>
        @endif

    </div>

    @php
        $last = $news->first();
        $others = $news->skip(1)->take(7);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        {{-- Main News --}}
        <div class="md:col-span-8">
            @if($last)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
                    <img src="{{ asset('storage/' . $last->news_thumbnail) }}" alt="{{ $last->news_title }}" class="w-full h-auto mb-4 rounded">

                    

                    <a href="{{ route('news.show', $last->slug) }}" class="text-2xl font-bold leading-snug mb-1 hover:text-blue-600">
                        {{ $last->news_title }}
                    </a>

                    <p class="text-gray-500 text-sm mb-4">
                         {{ \App\Helpers\DateHelper::formatBanglaDateTime($last->created_at) }}
                    </p>

                    <p class="text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($last->news_description), 200) }}
                    </p>
                </div>
            @endif
            <div class="hidden md:flex  items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-2">
                <img src="{{ asset('storage/ads/national-categoryad.png') }}" alt="add" class="object-fill">
            </div>
        </div>

        {{-- Remaining News --}}
        <div class="md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
            @foreach($others as $newsItem)
                <div class="flex items-start gap-3 p-3 @if (!$loop->last) border-b border-gray-200 @endif">
                    <div class="flex-1">
                        

                        <a href="{{ route('news.show', $newsItem->slug) }}">
                            <h4 class="text-md font-bold leading-tight hover:text-blue-600">
                                {{ $newsItem->news_title }}
                            </h4>
                        </a>
                    </div>

                    <img src="{{ asset('storage/' . $newsItem->news_thumbnail) }}"
                        alt="{{ $newsItem->news_title }}"
                        class="w-24 h-20 object-cover rounded">
                </div>
            @endforeach
        </div>
        <div class="md:hidden text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition ">
            <img src="{{ asset('storage/ads/national-categoryad.png') }}" alt="add" class="object-fill">
        </div>
    </div>
</section>
