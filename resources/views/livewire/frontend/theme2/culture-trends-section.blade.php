<div class="section max-w-5xl mx-auto px-4 py-4">
    {{-- Section Title --}}
    @if($title)
        <div class="flex items-center justify-between mb-6 pb-2 border-b border-gray-200 sectionHeader">
            <a href="{{ route('category.show', $categorySlug) }}"
               class="text-black hoverEffect">
            <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
            </a>
            <a href="{{ route('category.show', $categorySlug) }}"
               class="text-blue-600 text-sm hover:underline">
                আরও দেখুন →
            </a>
        </div>
    @endif

   
    @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div class="single_post flex flex-col overflow-hidden p-2 md:p-0 culBlock">
                    <a href="{{ route('news.show', $post->slug) }}">
                        <img
                            src="{{ $post->news_thumbnail ? asset('storage/' . $post->news_thumbnail) : ($defaultImage ?? '') }}"
                            alt="{{ $post->news_title }}"
                            class="w-full h-48 object-cover"
                        >
                    </a>
                    <h2 class="text-base font-semibold leading-tight mt-2 news_title">
                        <a href="{{ route('news.show', $post->slug) }}">
                            {{ $post->news_title }}
                        </a>
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($post->created_at, false) }}
                    </p>
                </div>
            @endforeach
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


</div>
