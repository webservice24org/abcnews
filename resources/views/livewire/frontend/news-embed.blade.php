<div class="p-4 border rounded shadow-md">
    @if($news->news_thumbnail)
        <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}" class="mb-3 w-full rounded">
    @endif

    <h2 class="text-xl font-bold mb-2">{{ $news->news_title }}</h2>
    <p class="text-sm text-gray-500 mb-2">{{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at, false) }}</p>

    <div class="prose max-w-none">
        {{ \Illuminate\Support\Str::limit(strip_tags($middleNews->news_description), 180) }}
    </div>

    <div class="mt-3">
        <a href="{{ route('news.show', $news->slug) }}" target="_blank" class="text-sm text-pink-700 underline">
            বিস্তারিত পড়ুন
        </a>
    </div>
</div>
