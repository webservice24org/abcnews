<section class="mb-10 max-w-5xl mx-auto px-4 py-4">
    {{-- Section Header --}}
    <div class="flex justify-between items-center border-b-3 mb-4"
         style="border-color: {{ $color->sec_border_color ?? '#e7000b' }};">
        <h2 class="text-2xl font-bold p-2 inline-block"
            style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }};
                   color: {{ $color->sec_title_color ?? '#fff' }};">
            {{ $title }}
        </h2>

        @if (!empty($categorySlug))
            <a href="{{ route('category.show', ['slug' => $categorySlug]) }}"
               class="text-sm hover:bg-red-700 px-4 py-1 rounded shadow-sm transition"
               style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }};
                      color:{{ $color->cat_btn_color ?? '#fff' }}">
                আরও দেখুন
            </a>
        @endif
    </div>

    {{-- Content --}}
    @if($allNews->isEmpty())
        <p class="text-center text-gray-500 py-6">ক্যাটাগরি একটিভ করতে হবে, বা এই ক্যাটাগরিতে পোস্ট করুন</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
            {{-- Left Column --}}
            
            <div class="col-span-12 md:col-span-3 flex flex-col space-y-4 h-full">
                @foreach($leftNews as $news)
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

            {{-- Middle Column --}}
            <div class="md:col-span-6 bg-sky-300 rounded shadow-sm hover:shadow-md transition group">
                {{-- Featured News --}}
                @if($middleNews)
                    <div class="p-4">
                        <div class="overflow-hidden rounded">
                            <img src="{{ asset('storage/' . $middleNews->news_thumbnail) }}"
                                alt="{{ $middleNews->news_title }}"
                                class="w-full h-auto rounded mb-4 object-cover transform transition duration-500 group-hover:scale-105">
                        </div>

                        <p class="text-sm text-red-600 font-bold mb-1">
                            @foreach($middleNews->categories as $category)
                                {{ $category->name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>

                        <a href="{{ route('news.show', $middleNews->slug) }}" 
                        class="text-2xl font-bold leading-snug news_title">
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
        </div>
    @endif

    {{-- Advertisement --}}
    <div class="flex items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-2">
        @if ($ad && $ad->ad_image)
            <img src="{{ asset('storage/' . $ad->ad_image) }}" alt="Ad" class="object-fill w-full">
        @elseif ($ad && $ad->ad_code)
            {!! $ad->ad_code !!}
        @else
            <img src="{{ asset('storage/fallback-ad/home-big.png') }}" alt="Fallback Ad" class="object-fill w-full">
        @endif
    </div>
</section>
