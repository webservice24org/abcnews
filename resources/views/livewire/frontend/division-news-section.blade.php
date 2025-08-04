<section class="mb-10">

    {{-- Breadcrumb and Division Header --}}
    <div class="mb-4">
        {{-- Breadcrumb --}}
        <div class="flex items-center text-sm text-gray-500 mb-2 bg-gray-100 p-2">
            <a href="{{ route('home') }}" class="hover:text-red-600 flex items-center gap-1">
                {{-- Home Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7m-9 0v10m4 0V9m5 3l2 2m0 0l-9 9-9-9" />
                </svg>
                হোম
            </a>
            <span class="mx-2">/</span>
            <span class="text-red-600 font-semibold">{{ $division->name }}</span>
        </div>

        {{-- Division Name with Location Icon --}}
        <div class="flex items-center gap-2 border-b-3 border-red-700 pb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 12.414A4 4 0 1116.657 9.657l4.243 4.243a4 4 0 01-5.657 5.657z" />
            </svg>
            <h2 class="text-2xl font-bold text-white bg-red-600 px-4 py-1 rounded">
                {{ $division->name }}
            </h2>
        </div>
    </div>
    {{-- Districts List --}}
    @if ($division->districts->count())
        <div class="mt-2 mb-6 flex flex-wrap gap-2">
            @foreach ($division->districts as $district)
                <a href="{{ route('district.show', $district->slug) }}"
                class="bg-gray-100 border border-gray-300 text-sm px-3 py-1 rounded hover:bg-red-600 hover:text-white transition">
                    {{ $district->name }}
                </a>
            @endforeach
        </div>
    @endif



    @if($topLeft)
        <div class="mb-10">

            {{-- Top Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
                {{-- Top Left --}}
                <div class="md:col-span-6">
                    <img src="{{ asset('storage/' . $topLeft->news_thumbnail) }}" class="w-full h-auto rounded mb-3">
                    <a href="{{ route('news.show', $topLeft->slug) }}">
                        <h2 class="text-2xl font-bold text-black hover:text-blue-700 mb-2">{{ $topLeft->news_title }}</h2>
                    </a>
                    <p class="text-sm text-gray-600 mb-2">
                        {{ \App\Helpers\DateHelper::formatBanglaDateTime($topLeft->created_at) }}
                    </p>
                    <p class="text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($topLeft->news_description), 150) }}
                    </p>
                </div>

                {{-- Top Right --}}
                <div class="md:col-span-3 space-y-4">
                    @foreach($topRight as $item)
                        <div class="flex items-start gap-3 border-b border-gray-200 pb-3">
                            <img src="{{ asset('storage/' . $item->news_thumbnail) }}" class="w-24 h-20 object-cover rounded">
                            <div class="flex-1">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <h4 class="text-md font-semibold text-black hover:text-blue-700">
                                        {{ $item->news_title }}
                                    </h4>
                                </a>
                                <p class="text-xs text-gray-500">
                                    {{ \App\Helpers\DateHelper::formatBanglaDateTime($item->created_at) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ad --}}
                <div class="md:col-span-3">
                    <img src="{{ asset('storage/ads/cate-vertical.png') }}" class="w-full object-cover" alt="ad">
                </div>
            </div>

            {{-- Grid List --}}
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
                                    {{ \App\Helpers\DateHelper::formatBanglaDateTime($item->created_at) }}
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

                {{-- Sidebar --}}
                <div class="md:col-span-4">
                    @livewire('frontend.popular-news-sidebar')
                    <livewire:frontend.news-archive-search />
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-xl text-gray-500">No news found in <span class="text-red-600">{{ $division->division_name }}</span>.</p>
    @endif

</section>
