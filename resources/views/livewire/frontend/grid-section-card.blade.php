@if ($news && count($news))
    <section class="mb-10">
        <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-red-700 border-b-2 border-red-700 mb-4">{{ $title }}</h2>
        @if (!empty($categorySlug))
                    <a href="{{ route('category.show', ['slug' => $categorySlug]) }}" class="text-sm text-white bg-red-600 hover:bg-red-700 px-4 py-1 rounded shadow-sm transition">আরও দেখুন</a>
                @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <div class="border rounded-lg shadow-sm hover:shadow-md transition">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <img src="{{ asset('storage/' . $item->news_thumbnail) }}"
                             class="w-full h-48 object-cover rounded-t" alt="{{ $item->news_title }}">
                    </a>
                    <div class="p-4">
                        <a href="{{ route('news.show', $item->slug) }}"
                           class="text-lg font-semibold text-black hover:text-blue-600 block">
                            {{ $item->news_title }}
                        </a>
                        
                        <p class="mt-2 text-gray-700">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->news_description), 100) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
