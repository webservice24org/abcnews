<div class="grid grid-cols-1 md:grid-cols-4 gap-6 my-10 max-w-5xl mx-auto px-4 py-4">
    @foreach($categoryData as $cat)
        <div>
            {{-- Section Title --}}
            <h2 class="font-bold text-lg text-gray-900 border-b-2 border-black mb-3 pb-1">
                <a href="{{ route('category.show', $cat['slug']) }}">
                    {{ strtoupper($cat['title']) }} 
                </a>
            </h2>

            {{-- Featured News --}}
            @if($cat['featured'])
                <a href="{{ route('news.show', $cat['featured']->slug) }}" class="block mb-3">
                    <img src="{{ $cat['featured']->news_thumbnail 
                        ? asset('storage/'.$cat['featured']->news_thumbnail) 
                        : asset('images/default.jpg') }}"
                         alt="{{ $cat['featured']->news_title }}"
                         class="w-full h-40 object-cover rounded">
                    <h3 class="mt-2 font-semibold text-gray-900 news_title">
                        {{ $cat['featured']->news_title }}
                    </h3>
                    <p class="text-sm text-gray-700">
                        {{ \Illuminate\Support\Str::words(strip_tags($cat['featured']->news_description), 18, '...') }}
                    </p>
                </a>
            @endif

            {{-- Other News --}}
            <div class="space-y-2">
                @foreach($cat['others'] as $news)
                    <a href="{{ route('news.show', $news->slug) }}" 
                       class="block border-t pt-2 font-semibold text-gray-900 news_title">
                        {{ $news->news_title }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
