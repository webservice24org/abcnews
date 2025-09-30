<div class="max-w-5xl mx-auto px-4 py-4 shadow-sm bg-white rounded">
    {{-- Section header --}}
    <div class="flex items-center justify-between mb-6 pb-2 sectionHeader">
        <a href="{{ route('category.show', $categorySlug) }}"
               class="text-black hoverEffect">
        <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
        </a>
        <a href="{{ route('category.show', $categorySlug) }}"
           class="text-blue-600 text-sm hover:underline">
            আরও দেখুন
        </a>
    </div>

@if($bigNews)
    <div class="grid grid-cols-12 gap-4">
        {{-- Left: big card --}}
        <div class="col-span-12 md:col-span-6 bg-sky-300 hover:bg-sky-400 transition p-2 rounded-lg leadCard">
            <a href="{{ route('news.show', $bigNews->slug) }}" class="leadBlock block">
                <img
                    src="{{ $bigNews->news_thumbnail ? asset('storage/' . $bigNews->news_thumbnail) : ($defaultImage ?? '') }}"
                    alt="{{ $bigNews->news_title }}"
                    class="w-full h-60 object-cover"
                >
                <div class="mt-3">
                    <h2 class="text-lg font-bold mb-2 hover:underline news_title">{{ $bigNews->news_title }}</h2>
                    <p class="text-gray-600 mb-2">
                        {{ \Illuminate\Support\Str::words(strip_tags($bigNews->news_description), 40, '...') }}
                    </p>
                    <span class="text-gray-500 text-sm">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($bigNews->created_at, false) }}
                    </span>
                </div>
            </a>
        </div>

        {{-- Right: up to 4 small cards --}}
        <div class="col-span-12 md:col-span-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($smallNews as $news)
                <a href="{{ route('news.show', $news->slug) }}"
                   class="flex md:block gap-3 overflow-hidden p-2 rightBlock bg-sky-300 rounded-lg hover:bg-sky-400 transition">
                    <img
                        src="{{ $news->news_thumbnail ? asset('storage/' . $news->news_thumbnail) : ($defaultImage ?? '') }}"
                        alt="{{ $news->news_title }}"
                        class="w-24 h-20 object-cover md:w-full md:h-28"
                    >
                    <div class="flex-1 p-0 md:p-2">
                        <h2 class="md:text-base font-semibold leading-tight mb-2 news_title hover:underline">
                            {{ $news->news_title }}
                        </h2>
                        <span class="text-gray-500 text-sm">
                            {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at, false) }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@else
    @php
        $category = \App\Models\Category::where('slug', $categorySlug)->first();
    @endphp

    @if(!$category || $category->status == 0)
        <p class="text-red-500 text-sm">এই বিভাগ বর্তমানে নিষ্ক্রিয়।</p>
    @else
        <p class="text-gray-500 text-sm">এই বিভাগে কোনো খবর পাওয়া যায়নি।</p>
    @endif
@endif

