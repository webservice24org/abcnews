<section class="container mx-auto py-6 px-4">
    <h2 class="text-2xl font-bold mb-4 text-black">
        {{ \App\Helpers\DateHelper::formatBanglaDateTime($parsedDate) }} এর সংবাদের তালিকা
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        {{-- News List --}}
        <div class="md:col-span-8 space-y-4">
            @forelse ($newsList as $news)
                <div class="flex border rounded shadow-sm hover:shadow-md transition">
                    <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}"
                         class="w-36 h-24 object-cover rounded-l">
                    <div class="p-3 flex-1">
                        <a href="{{ route('news.show', $news->slug) }}"
                           class="text-lg font-bold text-black hover:text-red-600 block">
                            {{ $news->news_title }}
                        </a>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ \Illuminate\Support\Str::limit(strip_tags($news->news_description), 100) }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">এই তারিখে কোনো সংবাদ পাওয়া যায়নি।</p>
            @endforelse

            <div>
                {{ $newsList->links() }}
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="md:col-span-4 space-y-4">
            <livewire:frontend.news-archive-search />
            <livewire:frontend.latest-news-sidebar />
        </div>
    </div>
</section>
