<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-2">
    <h3 class="text-lg font-bold text-white mb-4 p-2" style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }}; color: {{ $color->sec_title_color ?? '#fff' }};">সর্বাধিক পঠিত</h3>

    @foreach($popularNews as $news)
        <div class="flex items-start gap-3 mb-3 pt-1 pb-1 @if (!$loop->last) border-b border-gray-200 @endif">
            <div class="flex-1">
                <a href="{{ route('news.show', $news->slug) }}" class="text-md font-bold news_title">
                    {{ $news->news_title }}
                </a>
            </div>
            <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}" class="w-18 h-14 object-cover rounded">
        </div>
    @endforeach

    <livewire:frontend.subscriber-form />

    <livewire:frontend.division-map />

</div>
