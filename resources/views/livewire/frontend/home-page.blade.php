<div>
    <h1 class="text-3xl font-bold mb-4">Latest News</h1>

    @foreach ($news as $item)
        <div class="mb-6 border-b pb-4">
            <a href="{{ route('news.show', $item->slug) }}" class="text-2xl text-blue-600 hover:underline">
                {{ $item->news_title }}
            </a>
            <p class="text-gray-600 text-sm">{{ $item->created_at->format('d M Y') }}</p>
            <p class="mt-2">{{ \Illuminate\Support\Str::limit(strip_tags($item->news_description), 150) }}</p>
        </div>
    @endforeach

    {{ $news->links() }}
</div>
