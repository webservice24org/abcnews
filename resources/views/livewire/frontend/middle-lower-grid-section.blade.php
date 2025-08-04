<section class="mb-10 bg-white rounded shadow p-4">
    <div class="flex justify-between items-center border-b-3 border-red-700 mb-4">
        <h2 class="text-2xl font-bold text-white bg-red-600 p-2 inline-block">{{ $title }}</h2>

        {{-- Read More Button --}}
        
        @if (!empty($categorySlug))
            <a href="{{ route('category.show', ['slug' => $categorySlug]) }}" class="text-sm text-white bg-red-600 hover:bg-red-700 px-4 py-1 rounded shadow-sm transition">আরও দেখুন</a>
        @endif

    </div>

    {{-- Grid: Left (2), Middle (1), Right (2) --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        {{-- Left 2 News --}}
        <div class="md:col-span-3 space-y-4">
            @foreach($leftNews as $item)
                <div>
                    <img src="{{ asset('storage/' . $item->news_thumbnail) }}" class="w-full h-40 object-cover rounded mb-2">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <h3 class="text-md font-semibold text-black hover:text-blue-600">{{ $item->news_title }}</h3>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Middle 1 News --}}
        <div class="md:col-span-6">
            @if($middleNews)
                <div>
                    <img src="{{ asset('storage/' . $middleNews->news_thumbnail) }}" class="w-full h-64 object-cover rounded mb-3">
                    <a href="{{ route('news.show', $middleNews->slug) }}">
                        <h2 class="text-2xl font-bold text-black hover:text-blue-600">{{ $middleNews->news_title }}</h2>
                    </a>

                    <p class="text-gray-500 text-sm mb-4">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($middleNews->created_at) }}
                    </p>

                    <p class="text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($middleNews->news_description), 200) }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Right 2 News --}}
        <div class="md:col-span-3 space-y-4">
            @foreach($rightNews as $item)
                <div>
                    <img src="{{ asset('storage/' . $item->news_thumbnail) }}" class="w-full h-40 object-cover rounded mb-2">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <h3 class="text-md font-semibold text-black hover:text-blue-600">{{ $item->news_title }}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Bottom Grid of 4 News --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        @foreach($bottomNews as $item)
            <div>
                <img src="{{ asset('storage/' . $item->news_thumbnail) }}" class="w-full h-40 object-cover rounded mb-2">
                <a href="{{ route('news.show', $item->slug) }}">
                    <h3 class="text-md font-semibold text-black hover:text-blue-600">{{ $item->news_title }}</h3>
                </a>
            </div>
        @endforeach
    </div>
</section>
