<div class="section max-w-5xl mx-auto px-4 py-4">
    <section class="mb-10">
        <div class="flex justify-between items-center border-b-3 mb-4"
             style="border-color: {{ $color->sec_border_color ?? '#e7000b' }};">
            <h2 class="text-2xl font-bold p-2 inline-block"
                style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }};
                       color: {{ $color->sec_title_color ?? '#fff' }};">
                {{ $title }}
            </h2>

            {{-- Read More Button --}}
            @if (!empty($categorySlug))
                <a href="{{ route('category.show', ['slug' => $categorySlug]) }}"
                   class="text-sm hover:bg-red-700 px-4 py-1 rounded shadow-sm transition"
                   style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }};
                          color:{{ $color->cat_btn_color ?? '#e7000b' }}">
                    আরও দেখুন
                </a>
            @endif
        </div>

        @if($news && $news->count() > 0)
            @php
                $last = $news->first();
                $others = $news->skip(1)->take(7);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                {{-- Main News --}}
                <div class="md:col-span-8">
                    @if($last)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition p-4">
                            <img src="{{ asset('storage/' . $last->news_thumbnail) }}"
                                 alt="{{ $last->news_title }}"
                                 class="w-full h-auto mb-4 rounded">

                            <a href="{{ route('news.show', $last->slug) }}"
                               class="text-2xl font-bold leading-snug mb-1 news_title">
                                {{ $last->news_title }}
                            </a>

                            <p class="text-gray-500 text-sm mb-4">
                                {{ optional($last->user)->name }} |
                                {{ \App\Helpers\DateHelper::formatBanglaDateTime($last->created_at) }}
                            </p>

                            <p class="text-gray-700">
                                {{ \Illuminate\Support\Str::limit(strip_tags($last->news_description), 200) }}
                            </p>
                        </div>
                    @endif

                    {{-- Desktop Ad --}}
                    <div class="hidden md:flex items-start gap-3 bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition mt-2">
                        @if ($ad && $ad->ad_image)
                            <a href="{{ $ad->ad_url ?? '#' }}" target="_blank">
                                <img src="{{ asset('storage/' . $ad->ad_image) }}" alt="Ad" class="object-fill w-full">
                            </a>
                        @elseif ($ad && $ad->ad_code)
                            {!! $ad->ad_code !!}
                        @else
                            <img src="{{ asset('storage/fallback-ad/home-section-below.png') }}" alt="Fallback Ad" class="object-fill w-full">
                        @endif
                    </div>
                </div>

                {{-- Remaining News --}}
                <div class="md:col-span-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    @foreach($others as $newsItem)
                        <div class="flex items-start gap-3 p-3 @if (!$loop->last) border-b border-gray-200 @endif">
                            <div class="flex-1">
                                <a href="{{ route('news.show', $newsItem->slug) }}">
                                    <h4 class="text-md font-bold leading-tight news_title">
                                        {{ $newsItem->news_title }}
                                    </h4>
                                </a>
                            </div>
                            <img src="{{ asset('storage/' . $newsItem->news_thumbnail) }}"
                                 alt="{{ $newsItem->news_title }}"
                                 class="w-24 h-20 object-cover rounded">
                        </div>
                    @endforeach
                </div>

                {{-- Mobile Ad --}}
                <div class="md:hidden text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition ">
                    @if ($ad && $ad->ad_image)
                        <a href="{{ $ad->ad_url ?? '#' }}" target="_blank">
                            <img src="{{ asset('storage/' . $ad->ad_image) }}" alt="Ad" class="object-fill w-full">
                        </a>
                    @elseif ($ad && $ad->ad_code)
                        {!! $ad->ad_code !!}
                    @else
                        <img src="{{ asset('storage/fallback-ad/home-section-below.png') }}" alt="Fallback Ad" class="object-fill w-full">
                    @endif
                </div>
            </div>
        @else
            <p class="text-center text-gray-500">ক্যাটাগরি একটিভ করতে হবে, বা এই ক্যাটাগরিতে পোস্ট করুন</p>
        @endif
    </section>
</div>
