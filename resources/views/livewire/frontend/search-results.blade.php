<div class="search-result container">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="md:col-span-8 space-y-6">
            <h1 class="text-2xl font-semibold mb-4">অনুসন্ধান</h1>

                <p class="mb-4 text-gray-600">Showing results for: <strong>{{ $query }}</strong></p>

                @if ($results->count())
                    <div class="md:col-span-8 space-y-4">
                        @foreach ($results as $post)
                            <div class="flex flex-col md:flex-row border-b pb-4">
                                <img src="{{ asset('storage/' . $post->news_thumbnail) }}"
                                    alt="{{ $post->news_title }}"
                                    class="w-full md:w-40 h-auto object-cover mr-4 mb-2 md:mb-0">

                                <div>
                                    <h2 class="text-lg font-bold mb-1">
                                        <a href="{{ route('news.show', $post->slug) }}" class="hover:text-red-600">
                                            {{ $post->news_title }}
                                        </a>
                                    </h2>
                                    <p class="text-gray-700 text-sm">
                                        {{ Str::limit(strip_tags($post->news_description), 150) }}
                                    </p>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $results->links() }}
                    </div>
                @else
                    <p class="text-gray-600">No results found.</p>
                @endif
        </div>
        <div class="md:col-span-4">
            <livewire:frontend.news-archive-search />
            <livewire:frontend.popular-news-sidebar />
            <livewire:frontend.latest-news-sidebar />
            @php

                $globalSideTwoAd = \App\Models\Advertisement::where('ad_name', 'Global Sidebar Two')
                    ->where('is_global', 1)
                    ->where('status', 1)
                    ->first();
            @endphp

            <div class="text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition my-4">
                

                @if ($globalSideTwoAd)
                    {{-- Global ad --}}
                    @if ($globalSideTwoAd->ad_image)
                        <a href="{{ $globalSideTwoAd->ad_url ?? '#' }}" target="_blank">
                            <img src="{{ asset('storage/' . $globalSideTwoAd->ad_image) }}" alt="{{$globalSideTwoAd->ad_name}}" class="object-fill">
                        </a>
                    @elseif ($globalSideTwoAd->ad_code)
                        {!! $globalSideTwoAd->ad_code !!}
                    @endif

                @else
                    {{-- Fallback image --}}
                    <img src="{{ asset('storage/fallback-ad/ad-450-456.png') }}" alt="Fallback Ad" class="object-fill">
                @endif


            </div>

        </div>
    </div>
    
</div>
