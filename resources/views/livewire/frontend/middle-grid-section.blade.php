<section class="mb-10">
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
        <p class="text-center text-gray-500 py-6">ক্যাটাগরি একটিভ করতে হবে, বা এই ক্যাটাগরিতে পোস্ট করুন/p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
            {{-- Left Column --}}
            <div class="md:col-span-3 space-y-4">
                @foreach($leftNews as $news)
                    <div class="flex gap-3 @if (!$loop->last) border-b border-gray-200 @endif">
                        <img src="{{ asset('storage/' . $news->news_thumbnail) }}"
                             class="w-20 h-16 object-cover rounded"
                             alt="{{ $news->news_title }}">
                        <div>
                            <a href="{{ route('news.show', $news->slug) }}" class="font-semibold text-md news_title">
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
                        <img src="{{ asset('storage/' . $middleNews->news_thumbnail) }}"
                             alt="{{ $middleNews->news_title }}"
                             class="w-full h-auto rounded mb-4">

                        <p class="text-sm text-red-600 font-bold mb-1">
                            @foreach($middleNews->categories as $category)
                                {{ $category->name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>

                        <a href="{{ route('news.show', $middleNews->slug) }}" class="text-2xl font-bold leading-snug news_title">
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
                        <img src="{{ asset('storage/' . $news->news_thumbnail) }}"
                             class="w-20 h-16 object-cover rounded"
                             alt="{{ $news->news_title }}">
                        <div>
                            <a href="{{ route('news.show', $news->slug) }}" class="font-semibold text-md news_title">
                                {{ $news->news_title }}
                            </a>
                        </div>
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
