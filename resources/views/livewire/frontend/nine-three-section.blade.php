<div class="section max-w-5xl mx-auto px-4 py-4">
    {{-- Section Title --}}
    <div class="pt-2 border-b-2 border-black mb-4">
        <h2 class="text-xl font-bold text-gray-900"><a href="{{ route('category.show', ['slug' => $categorySlug]) }}">{{ $title }}</a></h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="md:col-span-9 space-y-6">
            @if($topMain)
                <a href="{{ route('news.show', $topMain->slug) }}" class="flex gap-4 border-b pb-4 group">
                    {{-- Title + Description (40%) --}}
                    <div class="w-2/5 flex flex-col justify-center">
                        <h2 class="text-xl font-bold text-gray-900 news_title transition">
                            {{ $topMain->news_title }}
                        </h2>
                        <p class="text-gray-600 mt-2">
                            {{ \Illuminate\Support\Str::words(strip_tags($topMain->news_description), 25, '...') }}
                        </p>
                    </div>
                    {{-- Thumbnail (60%) --}}
                    <div class="w-3/5 overflow-hidden rounded-md">
                        <img src="{{ $topMain->news_thumbnail 
                            ? asset('storage/'.$topMain->news_thumbnail) 
                            : asset('images/default.jpg') }}"
                            alt="{{ $topMain->news_title }}"
                            class="w-full h-64 object-cover transform transition duration-500 group-hover:scale-105 group-hover:brightness-90">
                    </div>

                    

                </a>
            @endif


            {{-- Below Grid (2-column news cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($leftGrid as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="block group border-b pb-3">
                        <div class="overflow-hidden rounded-md">
                            <img src="{{ $item->news_thumbnail ? asset('storage/'.$item->news_thumbnail) : asset('images/default.jpg') }}"
                                 alt="{{ $item->news_title }}"
                                 class="w-full h-40 object-cover transform transition duration-500 group-hover:scale-105 group-hover:brightness-90">
                        </div>
                        <h3 class="text-lg mt-2 font-semibold text-gray-900 news_title">
                            {{ $item->news_title }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::words(strip_tags($item->news_description), 18, '...') }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- RIGHT 3 columns --}}
        <div class="md:col-span-3 space-y-4">
            {{-- Top with Thumbnail --}}
            @if($rightTop)
                <a href="{{ route('news.show', $rightTop->slug) }}" class="block group border-b pb-2">
                    <div class="overflow-hidden rounded-md">
                        <img src="{{ $rightTop->news_thumbnail ? asset('storage/'.$rightTop->news_thumbnail) : asset('images/default.jpg') }}"
                             alt="{{ $rightTop->news_title }}"
                             class="w-full h-32 object-cover transform transition duration-500 group-hover:scale-105 group-hover:brightness-90">
                    </div>
                    <h3 class="mt-2 font-semibold text-lg text-gray-900 news_title">
                        {{ $rightTop->news_title }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ \Illuminate\Support\Str::words(strip_tags($rightTop->news_description), 18, '...') }}
                    </p>
                </a>
            @endif

            {{-- Small List without Thumbnail --}}
            @foreach($rightSmall as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="block border-b pb-2 group">
                    <h3 class="text-lg font-semibold text-gray-800 news_title">
                        {{ $item->news_title }}
                    </h3>
                
                <p class="text-sm text-gray-600">
                        {{ \Illuminate\Support\Str::words(strip_tags($item->news_description), 18, '...') }}
                    </p>
                    </a>
            @endforeach
        </div>
    </div>
</div>
