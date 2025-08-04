<section class="mb-10">
    
    <div class="flex justify-between items-center border-b-3 border-red-700 mb-4">
        <h2 class="text-2xl font-bold text-white bg-red-600 p-2 inline-block">{{ $title }}</h2>

        {{-- Read More Button --}}
        
        @if (!empty($categorySlug))
            <a href="{{ route('category.show', ['slug' => $categorySlug]) }}" class="text-sm text-white bg-red-600 hover:bg-red-700 px-4 py-1 rounded shadow-sm transition">আরও দেখুন</a>
        @endif

    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
        {{-- Left Column --}}
        <div class="md:col-span-3 space-y-4">
            @foreach($leftNews as $news)
                <div class="flex gap-3 @if (!$loop->last) border-b border-gray-200 @endif">
                    <img src="{{ asset('storage/' . $news->news_thumbnail) }}" class="w-20 h-16 object-cover rounded" alt="{{ $news->news_title }}">
                    <div>
                        <a href="{{ route('news.show', $news->slug) }}" class="font-semibold text-md text-black hover:text-blue-600">
                            {{ $news->news_title }}
                        </a>
                        
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Middle Column --}}
        <div class="md:col-span-6">
            @if($middleNews)
                <div>
                    <img src="{{ asset('storage/' . $middleNews->news_thumbnail) }}" alt="{{ $middleNews->news_title }}" class="w-full h-auto rounded mb-4">

                    <p class="text-sm text-red-600 font-bold mb-1">
                        @foreach($middleNews->categories as $category)
                            {{ $category->name }}@if(!$loop->last), @endif
                        @endforeach
                    </p>

                    <a href="{{ route('news.show', $middleNews->slug) }}" class="text-2xl font-bold leading-snug hover:text-blue-600">
                        {{ $middleNews->news_title }}
                    </a>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($middleNews->created_at) }}
                    </p>

                    <p class="mt-3 text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($middleNews->news_description), 180) }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="md:col-span-3 space-y-4">
            @foreach($rightNews as $news)
                <div class="flex gap-3 @if (!$loop->last) border-b border-gray-200 @endif">
                    <img src="{{ asset('storage/' . $news->news_thumbnail) }}" class="w-20 h-16 object-cover rounded" alt="{{ $news->news_title }}">
                    <div>
                        <a href="{{ route('news.show', $news->slug) }}" class="font-semibold text-md text-black hover:text-blue-600">
                            {{ $news->news_title }}
                        </a>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex  items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-2">
        <img src="{{ asset('storage/ads/entertainment-add.png') }}" alt="add" class="object-fill">
    </div>
    
</section>
