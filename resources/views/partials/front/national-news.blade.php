<section class="mb-10 mt-10">
    <h2 class="text-2xl font-bold text-red-700 border-b-2 border-red-700 mb-4">জাতীয় সংবাদ</h2>

    @php
        $last = $news->first(); // most recent post
        $others = $news->skip(1); // next 5
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        {{-- Main National News --}}
        <div class="md:col-span-8">
            @if($last)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
                    <img src="{{ asset('storage/' . $last->news_thumbnail) }}"
                         alt="{{ $last->news_title }}"
                         class="w-full object-cover rounded mb-4">

                    <p class="text-sm text-red-600 font-bold mb-1">
                        @foreach($last->categories as $category)
                            {{ $category->name }}@if(!$loop->last), @endif
                        @endforeach
                    </p>

                    <a href="{{ route('news.show', $last->slug) }}"
                       class="text-2xl md:text-3xl font-bold leading-snug mb-2 hover:text-blue-600 block">
                        {{ $last->news_title }}
                    </a>

                    <p class="text-gray-500 text-sm mb-4">
                        By {{ optional($last->user)->name }} | {{ $last->created_at->format('M d, Y') }}
                    </p>

                    <p class="text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($last->news_description), 200) }}
                    </p>
                </div>
            @endif

            <div class="hidden md:flex  items-start gap-3 bg-white border border-gray-200 rounded-lg p-3 shadow-sm hover:shadow-md transition mt-2">
                <img src="{{ asset('storage/ads/national-categoryad.png') }}" alt="add" class="object-fill">
            </div>
        </div>

        {{-- Remaining National News --}}
        <div class="md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
            @foreach($others->take(7) as $newsItem)
                <div class="flex items-start gap-3 p-3 @if (!$loop->last) border-b border-gray-200 @endif">
                    <div class="flex-1">
                        <p class="text-xs text-red-600 font-semibold">
                            @foreach($newsItem->categories as $category)
                                {{ $category->name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>

                        <a href="{{ route('news.show', $newsItem->slug) }}">
                            <h4 class="text-sm font-bold leading-tight hover:underline hover:text-blue-600">
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

        <div class="md:hidden  items-start bg-white border border-gray-200 p-2 shadow-sm hover:shadow-md transition ">
            <img src="{{ asset('storage/ads/national-categoryad.png') }}" alt="add" class="object-fill">
        </div>
    </div>
</section>
