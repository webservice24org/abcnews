<div class="grid grid-cols-12 gap-4 ml-2 mr-2 mb-10 items-stretch">

    {{-- Left Section (2 news) --}}
    <div class="col-span-12 md:col-span-3 flex flex-col space-y-3 h-full">
        @foreach($leftNews as $news)
            <a href="{{ route('news.show', $news->slug) }}"
               class="flex md:block items-center gap-3 overflow-hidden p-2 md:p-0 group bg-sky-300 rounded shadow-sm flex-1
                      transition-all duration-500 ease-out hover:shadow-lg hover:scale-[1.02]">
                <img src="{{ asset('storage/'.$news->news_thumbnail) }}"
                     alt="{{ $news->news_title }}"
                     class="w-24 h-20 object-cover md:w-full md:h-32 rounded transform transition duration-500 ease-out group-hover:scale-105">

                <div class="p-0 md:p-2 flex-1">
                    <h3 class="text-sm font-semibold mb-1 text-gray-800 news_title">
                        {{ $news->news_title }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Middle Section (1 big news) --}}
    <div class="col-span-12 md:col-span-6 flex flex-col h-full">
        @if($mainNews)
            <div class="bg-sky-300 p-3 rounded shadow-sm flex flex-col flex-1
                        transition-all duration-500 ease-out hover:shadow-lg hover:scale-[1.02]">
                <a href="{{ route('news.show', $mainNews->slug) }}" class="block group flex-1">
                    <img src="{{ asset('storage/'.$mainNews->news_thumbnail) }}"
                         alt="{{ $mainNews->news_title }}"
                         class="w-full h-64 object-cover mb-3 rounded transform transition duration-500 ease-out group-hover:scale-105">
                    <h2 class="text-lg font-bold news_title text-gray-900 mb-2">
                        {{ $mainNews->news_title }}
                    </h2>
                </a>
                <p class="text-sm text-gray-700 leading-relaxed flex-grow">
                    {{ \Illuminate\Support\Str::words(strip_tags($mainNews->news_description), 40, '...') }}
                </p>
            </div>
        @endif
    </div>

    {{-- Right Section (5 news) --}}
    <div class="col-span-12 md:col-span-3 flex flex-col space-y-3 h-full">
        @foreach($rightNews as $news)
            <div class="flex items-center gap-2 bg-sky-300 p-2 rounded shadow-sm flex-1
                        transition-all duration-500 ease-out hover:shadow-lg hover:scale-[1.02]">
                <a href="{{ route('news.show', $news->slug) }}" class="group">
                    <img src="{{ asset('storage/'.$news->news_thumbnail) }}"
                         alt="{{ $news->news_title }}"
                         class="w-20 h-16 object-cover rounded transform transition duration-500 ease-out group-hover:scale-105">
                </a>
                <a href="{{ route('news.show', $news->slug) }}"
                   class="text-sm font-semibold text-gray-800 news_title flex-1">
                    {{ $news->news_title }}
                </a>
            </div>
        @endforeach
    </div>

    {{-- Bottom Section (4 news) --}}
    <div class="col-span-12 grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
        @foreach($bottomNews as $news)
            <a href="{{ route('news.show', $news->slug) }}"
               class="flex md:block items-center gap-3 overflow-hidden p-2 md:p-0 group bg-sky-300 rounded shadow-sm
                      transition-all duration-500 ease-out hover:shadow-lg hover:scale-[1.02]">
                <img src="{{ asset('storage/'.$news->news_thumbnail) }}"
                     alt="{{ $news->news_title }}"
                     class="w-24 h-20 object-cover md:w-full md:h-28 rounded transform transition duration-500 ease-out group-hover:scale-105">

                <div class="p-0 md:p-2">
                    <h4 class="text-sm font-semibold text-gray-800 news_title">
                        {{ $news->news_title }}
                    </h4>
                </div>
            </a>
        @endforeach
    </div>

</div>
