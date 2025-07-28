<section class="mb-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($sections as $section)
            <div class="bg-white rounded shadow overflow-hidden flex flex-col h-full">
                {{-- Card Header --}}
                <div class="bg-red-600 text-white px-4 py-2 font-bold text-lg">
                    {{ $section['category']->name }}
                </div>

                {{-- Card Body --}}
                <div class="p-4 flex-grow">
                    @if($section['latest'])
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $section['latest']->news_thumbnail) }}" class="w-full h-40 object-cover rounded mb-2">
                            <a href="{{ route('news.show', $section['latest']->slug) }}">
                                <h3 class="font-semibold text-black hover:text-red-600">
                                    {{ $section['latest']->news_title }}
                                </h3>
                            </a>
                        </div>
                    @endif

                    @foreach($section['others'] as $item)
                        <div class="@if(!$loop->last) border-b border-gray-300 pb-2 mb-2 @endif">
                            <a href="{{ route('news.show', $item->slug) }}">
                                <p class="text-sm text-black hover:text-red-600">{{ $item->news_title }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Card Footer --}}
                <div class="bg-gray-100 px-4 py-2 text-right">
                    <a href="{{ route('category.show', ['slug' => $section['category']->slug]) }}"
                       class="text-sm text-red-600 hover:underline font-medium">
                        আরও দেখুন →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
