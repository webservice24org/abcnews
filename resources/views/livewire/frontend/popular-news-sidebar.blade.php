<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-2">
    <h3 class="text-lg font-bold text-white mb-4 p-2 bg-red-600">সর্বাধিক পঠিত</h3>

    @foreach($popularNews as $news)
        <div class="flex items-start gap-3 mb-3 pt-1 pb-1 @if (!$loop->last) border-b border-gray-200 @endif">
            <div class="flex-1">
                <a href="{{ route('news.show', $news->slug) }}" class="text-md font-bold hover:text-blue-800">
                    {{ $news->news_title }}
                </a>
            </div>
            <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}" class="w-18 h-14 object-cover rounded">
        </div>
    @endforeach

    <div class="flex text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition ">
        <img src="{{ asset('storage/ads/sidebar-lg.png') }}" alt="add" class="object-cover">
    </div>
    <livewire:frontend.division-map />

</div>
