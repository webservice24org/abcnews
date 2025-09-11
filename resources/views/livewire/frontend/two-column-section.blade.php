<div class="pt-2 section max-w-5xl mx-auto px-4 py-4">
    
    <div class="pt-2 border-b-2 border-black mb-4">
        <h2 class="text-xl font-bold text-gray-900"><a href="{{ route('category.show', ['slug' => $categorySlug]) }}">{{ $title }}</a></h2>
    </div>

    {{-- 2 Column Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($news as $item)
            <div class="border-b pb-4">
                <a href="{{ route('news.show', $item->slug) }}" class="block group">
                    {{-- Thumbnail --}}
                    <div class="overflow-hidden rounded-md">
                        <img src="{{ $item->news_thumbnail 
                            ? asset('storage/' . $item->news_thumbnail) 
                            : asset('images/default.jpg') }}"
                            alt="{{ $item->news_title }}"
                            class="w-full h-48 object-cover transform transition duration-500 group-hover:scale-105 group-hover:brightness-90">
                    </div>
                    
                    {{-- Title --}}
                    <h3 class="mt-3 font-semibold text-gray-800 text-lg news_title transition">
                        {{ $item->news_title }}
                    </h3>
                    
                    {{-- Short Description --}}
                    <p class="text-sm text-gray-600 mt-1">
                        {{ \Illuminate\Support\Str::words(strip_tags($item->news_description), 20, '...') }}
                    </p>
                </a>
            </div>
        @empty
            <p class="text-gray-500">No news available.</p>
        @endforelse
    </div>
</div>
