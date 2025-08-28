
    <section class="mb-10">
        {{-- Section Header --}}
        <div class="flex justify-between items-center border-b-3 mb-4"
             style="border-color: {{ $color->sec_border_color ?? '#e7000b' }};">
            <h2 class="text-2xl font-bold p-2"
                style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }};
                       color: {{ $color->sec_title_color ?? '#fff' }};">
                {{ $title }}
            </h2>

            @if (!empty($categorySlug))
                <a href="{{ route('category.show', ['slug' => $categorySlug]) }}"
                   class="text-sm hover:bg-red-700 px-4 py-1 rounded shadow-sm transition"
                   style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }};
                          color:{{$color->cat_btn_color ?? '#fff'}}">
                    আরও দেখুন
                </a>
            @endif
        </div>

        {{-- News Grid --}}
        @if ($news && $news->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <div class="border rounded-lg shadow-sm hover:shadow-md transition">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <img src="{{ asset('storage/' . $item->news_thumbnail) }}"
                             class="w-full h-48 object-cover rounded-t"
                             alt="{{ $item->news_title }}">
                    </a>
                    <div class="p-4">
                        <a href="{{ route('news.show', $item->slug) }}"
                           class="text-lg font-semibold news_title block">
                            {{ $item->news_title }}
                        </a>

                        <p class="mt-2 text-gray-700">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->news_description), 100) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            {{-- No Posts --}}
            <p class="text-center text-gray-500 py-6">ক্যাটাগরি একটিভ করতে হবে, বা এই ক্যাটাগরিতে পোস্ট করুন</p>
        @endif
    </section>


