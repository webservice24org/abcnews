<section class="mb-10">
    {{-- Subcategory Name with Parent Category --}}
    <div class="mb-6 flex flex-wrap items-center gap-2 border-b-3 border-red-700">
        {{-- Parent Category Name with link --}}
        <a href="{{ route('category.show', ['slug' => $subcategory->category->slug]) }}"
        class="text-2xl font-bold text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 pb-2 ps-2 pt-2 pr-4 transition">
            {{ $subcategory->category->name }}
        </a>

        {{-- Subcategory Name --}}
        <h2 class="text-2xl font-bold text-white bg-red-600 pb-2 ps-2 pt-2 pr-4">
            {{ $subcategory->name }}
        </h2>
    </div>

        @if($topLeft)
            <div class="mb-10">
        {{-- Top Section --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
            {{-- Top Left --}}
                <div class="md:col-span-6">
                    @if($topLeft)
                        <div>
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
                    @endif
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
                                {{ \App\Helpers\DateHelper::formatBanglaDateTime($item->created_at) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Top Right Ad --}}
            <div class="md:col-span-3 space-y-4">
                <div class="flex items-start gap-3 pb-3 ">
                    <div class="flex-1">
                        <div class="flex text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition ">
                            @php
                                $subCatSideOne = $subcategory->ads->filter(fn($ad) =>
                                    $ad->ad_name === 'Sub Category Sidebar One' && $ad->status == 1
                                )->first();

                                $subGlobalSideOne = \App\Models\Advertisement::where('ad_name', 'Sub Category Global Sidebar One')
                                    ->where('is_global', 1)
                                    ->where('status', 1)
                                    ->first();
                            @endphp

                                
                            @if ($subCatSideOne)
                                @if ($subCatSideOne->ad_image)
                                    <a href="{{ $subCatSideOne->ad_url ?? '#' }}" target="_blank">
                                        <img src="{{ asset('storage/' . $subCatSideOne->ad_image) }}" alt="{{$subCatSideOne->ad_name}}" class="object-fill">
                                    </a>
                                @elseif ($subCatSideOne->ad_code)
                                    {!! $subCatSideOne->ad_code !!}
                                @endif

                            @elseif ($subGlobalSideOne)
                                @if ($subGlobalSideOne->ad_image)
                                    <a href="{{ $subGlobalSideOne->ad_url ?? '#' }}" target="_blank">
                                        <img src="{{ asset('storage/' . $subGlobalSideOne->ad_image) }}" alt="{{$subGlobalSideOne->ad_name}}" class="object-fill">
                                    </a>
                                @elseif ($subGlobalSideOne->ad_code)
                                    {!! $subGlobalSideOne->ad_code !!}
                                @endif

                            @else
                                <img src="{{ asset('storage/fallback-ad/ad-450-456.png') }}" alt="Fallback Ad" class="object-fill">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Section --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            {{-- Grid Left --}}
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

                @if($gridNews->count() >= 6)
                    <div class="mt-6">
                        {{ $gridNews->links() }}
                    </div>
                @endif

                <div class="hidden md:flex items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-1">
                    @php
                        $catSideBelowGrid = $subcategory->ads->filter(fn($ad) =>
                            $ad->ad_name === 'Sub Category Below Grid' && $ad->status == 1
                        )->first();

                        $globalBelowGridAd = \App\Models\Advertisement::where('ad_name', 'Sub Category Global Below Grid')
                            ->where('is_global', 1)
                            ->where('status', 1)
                            ->first();
                    @endphp

                    
                    @if ($catSideBelowGrid)
                        @if ($catSideBelowGrid->ad_image)
                            <a href="{{ $catSideBelowGrid->ad_url ?? '#' }}" target="_blank">
                                <img src="{{ asset('storage/' . $catSideBelowGrid->ad_image) }}" alt="{{$catSideBelowGrid->ad_name}}" class="object-fill">
                            </a>
                        @elseif ($catSideBelowGrid->ad_code)
                            {!! $catSideBelowGrid->ad_code !!}
                        @endif

                    @elseif ($globalBelowGridAd)
                        @if ($globalBelowGridAd->ad_image)
                            <a href="{{ $globalBelowGridAd->ad_url ?? '#' }}" target="_blank">
                                <img src="{{ asset('storage/' . $globalBelowGridAd->ad_image) }}" alt="{{$globalBelowGridAd->ad_name}}" class="object-fill">
                            </a>
                        @elseif ($globalBelowGridAd->ad_code)
                            {!! $globalBelowGridAd->ad_code !!}
                        @endif

                    @else
                        {{-- Fallback image --}}
                        <img src="{{ asset('storage/fallback-ad/home-section-below.png') }}" alt="Fallback Ad" class="object-fill">
                    @endif
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div class="md:col-span-4">
                <livewire:frontend.popular-news-sidebar />
                @php
                    $catSideTwo = $subcategory->ads->filter(fn($ad) =>
                        $ad->ad_name === 'Sub Category Sidebar Two' && $ad->status == 1
                    )->first();

                    $globalSideTwoAd = \App\Models\Advertisement::where('ad_name', 'Sub Category Global Sidebar Two')
                        ->where('is_global', 1)
                        ->where('status', 1)
                        ->first();
                @endphp

                <div class="text-center bg-white border border-gray-200 p-1 shadow-sm hover:shadow-md transition my-4">
                    @if ($catSideTwo)
                        @if ($catSideTwo->ad_image)
                            <a href="{{ $catSideTwo->ad_url ?? '#' }}" target="_blank">
                                <img src="{{ asset('storage/' . $catSideTwo->ad_image) }}" alt="{{$catSideTwo->ad_name}}" class="object-fill">
                            </a>
                        @elseif ($catSideTwo->ad_code)
                            {!! $catSideTwo->ad_code !!}
                        @endif

                    @elseif ($globalSideTwoAd)
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
                <br>
                <livewire:frontend.news-archive-search />
        </div>
    </div>
        @else
            <p class="text-center text-xl text-gray-500">No news found in <span class="text-red-600">{{ $subcategory->name }}</span> Sub Category.</p>
        @endif
    
</section>
