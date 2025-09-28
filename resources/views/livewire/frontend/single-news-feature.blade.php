<div class="section max-w-5xl mx-auto px-4 py-4">
    {{-- Section Title --}}
    <h2 class="font-bold text-lg text-gray-900 border-b-2 border-black mb-5 pb-1">
        
         <a href="{{ route('category.show', ['slug' => $categorySlug]) }}">
            {{ $title }}
            </a>
    </h2>

    @if($news)
        <div class="grid grid-cols-1 md:grid-cols-10 gap-6 items-center">
            <div class="md:col-span-7">
                <a href="{{ route('news.show', $news->slug) }}">
                    <img src="{{ $news->news_thumbnail 
                        ? asset('storage/'.$news->news_thumbnail) 
                        : asset('images/default.jpg') }}"
                         alt="{{ $news->news_title }}"
                         class="w-full h-80 object-cover rounded">
                </a>
            </div>

            <div class="md:col-span-3 justify-center h-full space-y-4">
                <h3 class="text-xl font-bold text-gray-900">
                    <a href="{{ route('news.show', $news->slug) }}" class="news_title">
                        {{ $news->news_title }}
                    </a>
                </h3>
                <p class="text-gray-700">
                    {{ \Illuminate\Support\Str::words(strip_tags($news->news_description), 25, '...') }}
                </p>
               

<a href="{{ route('news.show', $news->slug) }}" 
                   class="inline-block text-sm text-black border border-black px-3 py-1 rounded transition duration-300  hover:border-[rgb(179,25,66)] hover:bg-[rgb(179,25,66)] hover:text-white">
                    ডিটেলস
                </a>



            </div>
        </div>
    @endif
</div>
