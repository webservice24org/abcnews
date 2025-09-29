<div class="max-w-5xl mx-auto px-4 py-4">
    {{-- Section title --}}
    <div class="flex items-center justify-between border-b border-gray-300 mb-4">
        <h2 class="text-xl font-bold text-gray-900 px-2">
            <a href="{{ route('category.show', ['slug' => $categorySlug]) }}">
            {{ $title }}
            </a>
        </h2>
    </div>

    {{-- News block --}}
    @if($news)
        <div class="grid grid-cols-1 md:grid-cols-10 gap-6 items-center">
            {{-- Left Content (30%) --}}
            <div class="md:col-span-3 space-y-4">
                <h3 class="text-xl font-bold text-gray-900">
                    <a href="{{ route('news.show', $news->slug) }}" class="news_title">
                        {{ $news->news_title }}
                    </a>
                </h3>
                <p class="text-gray-600">
                    {{ \Illuminate\Support\Str::words(strip_tags($news->news_description), 40, '...') }}
                </p>
                <a href="{{ route('news.show', $news->slug) }}" 
                   class="inline-block text-sm text-black border border-black px-3 py-1 rounded transition duration-300 hover:bg-[rgb(179,25,66)]  hover:border-[rgb(179,25,66)] hover:text-white">
                    ডিটেলস
                </a>
            </div>

            {{-- Right Image (70%) --}}
            <div class="md:col-span-7">
                <img src="{{ $news->news_thumbnail 
                            ? asset('storage/'.$news->news_thumbnail) 
                            : asset('images/default.jpg') }}"
                     alt="{{ $news->news_title }}"
                     class="w-full h-80 object-cover rounded">
            </div>
        </div>
    @endif
</div>
