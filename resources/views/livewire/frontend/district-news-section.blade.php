<section class="mb-10">
    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center gap-2 border-b-3 border-red-700">
        <h2 class="text-2xl font-bold text-white bg-red-600 pb-2 ps-2 pt-2 pr-4">
            {{ $district->district_name }}
        </h2>
    </div>

    @if($topLeft)
        <div class="mb-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
                {{-- Top Left --}}
                <div class="md:col-span-6">
                    <img src="{{ asset('storage/' . $topLeft->news_thumbnail) }}" class="w-full h-auto rounded mb-3">
                    <a href="{{ route('news.show', $topLeft->slug) }}">
                        <h2 class="text-2xl font-bold text-black hover:text-blue-700 mb-2">{{ $topLeft->news_title }}</h2>
                    </a>
                    <p class="text-sm text-gray-600 mb-2">{{ $topLeft->created_at->format('M d, Y') }}</p>
                    <p class="text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($topLeft->news_description), 150) }}
                    </p>
                </div>

                {{-- Top Right --}}
                <div class="md:col-span-3 space-y-4">
                    @foreach($topRight as $item)
                        <div class="flex items-start gap-3 @if (!$loop->last) border-b border-gray-200 @endif pb-3">
                            <img src="{{ asset('storage/' . $item->news_thumbnail) }}" class="w-24 h-20 object-cover rounded">
                            <div class="flex-1">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <h4 class="text-md font-semibold text-black hover:text-blue-700 ">
                                        {{ $item->news_title }}
                                    </h4>
                                </a>
                                <p class="text-xs text-gray-500">
                                    {{ $item->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ad --}}
                <div class="md:col-span-3 space-y-4">
                    <div class="flex text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition">
                        <img src="{{ asset('storage/ads/cate-vertical.png') }}" alt="add" class="object-cover">
                    </div>
                </div>
            </div>

            {{-- Grid News --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <div class="md:col-span-8 space-y-6">
                    @foreach($gridNews as $item)
                        <div class="flex gap-4 border-b pb-4">
                            <img src="{{ asset('storage/' . $item->news_thumbnail) }}" class="w-32 h-24 object-cover rounded">
                            <div class="flex-1">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <h3 class="text-lg font-bold text-black hover:text-blue-700">
                                        {{ $item->news_title }}
                                    </h3>
                                </a>
                                <p class="text-sm text-gray-500">
                                    {{ $item->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->news_description), 200) }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        {{ $gridNews->links() }}
                    </div>

                    <div class="hidden md:flex items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-1">
                        <img src="{{ asset('storage/ads/Advertisement.png') }}" alt="add" class="object-fill">
                    </div>
                </div>

                <div class="md:col-span-4">
                    @livewire('frontend.popular-news-sidebar')
                    <livewire:frontend.news-archive-search />
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-xl text-gray-500">
            No news found in <span class="text-red-600">{{ $district->district_name }}</span>
        </p>
    @endif
</section>
