<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-5">

    {{-- Lead News (8 columns) --}}
    <div class="md:col-span-6">
        @if($leadNews)
            <div>
                <img src="{{ asset('storage/' . $leadNews->news_thumbnail) }}" alt="{{ $leadNews->news_title }}" class="w-full h-auto mb-4">

                {{-- Categories --}}
                <p class="text-sm text-red-600 font-bold mb-1">
                    @foreach($leadNews->categories as $category)
                        {{ $category->name }}@if(!$loop->last), @endif
                    @endforeach
                </p>

                {{-- Title --}}
                <a href="{{ route('news.show', $leadNews->slug) }}" class="text-2xl font-bold leading-snug mb-1 hover:text-blue-600">
                    {{ $leadNews->news_title }}
                </a>

                {{-- Author & Date --}}
                <p class="text-gray-500 text-sm mb-4">
                    By {{ optional($leadNews->user)->name }} | {{ $leadNews->created_at->format('M d, Y') }}
                </p>
                <p class="mt-3 text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($leadNews->news_description), 180) }}
                    </p>
            </div>
        @endif
    </div>

    {{-- Sub Lead News (4 columns) --}}
    <div class="md:col-span-3 space-y-4">
        @foreach($subLeadNews as $news)
            <div class="flex justify-between items-start gap-3 @if (!$loop->last) border-b border-gray-200 @endif">
                {{-- Text Content (left side) --}}
                <div class="flex-1">
                    {{-- Category Name(s) --}}
                    <p class="text-xs text-red-600 font-semibold">
                        @foreach($news->categories as $category)
                            {{ $category->name }}@if(!$loop->last), @endif
                        @endforeach
                    </p>

                    {{-- Title --}}
                    <a href="{{ route('news.show', $news->slug) }}">
                        <h4 class="text-md font-bold leading-tight hover:text-blue-600">
                            {{ $news->news_title }}
                        </h4>
                    </a>

                   
                </div>

                {{-- Thumbnail on the right --}}
                <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}" class="w-24 h-20 object-cover rounded">
            </div>
        @endforeach
    </div>

    <div class="md:col-span-3 space-y-4">
        <img src="{{ asset('storage/ads/latest-post-ad.png') }}" alt="Ad" class="object-fill">
        <livewire:frontend.division-map />
    </div>

</div>
