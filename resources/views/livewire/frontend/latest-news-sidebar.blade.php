<div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-2">
    <h3 class="text-lg font-bold text-white mb-4 p-2 " style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }}; color: {{ $color->sec_title_color ?? '#fff' }};">সর্বশেষ প্রকাশিত</h3>

    @foreach($latestNews as $news)
        <div class="flex items-start gap-3 mb-3 pt-1 pb-1 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
            <div class="flex-1">
                <a href="{{ route('news.show', $news->slug) }}" class="text-md font-bold news_title">
                    {{ \Illuminate\Support\Str::limit($news->news_title, 80) }}
                </a>
            </div>
            <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}" class="w-18 h-14 object-cover rounded">
        </div>
    @endforeach


</div>
