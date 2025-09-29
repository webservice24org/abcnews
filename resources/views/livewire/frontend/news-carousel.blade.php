<section class="mb-10 bg-white rounded shadow-sm hover:shadow-md p-4 max-w-5xl mx-auto px-4 py-4"> 
<div class="w-full bg-sky-300 py-10">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Section header --}}
        <div class="flex items-center justify-between border-b border-gray-600 mb-6">
            <h2 class="text-xl font-bold text-black px-2">
                <a href="{{ route('category.show', ['slug' => $categorySlug]) }}">
                    {{ $title }}
                </a>
            </h2>
            <div class="flex space-x-2 mb-1">
                <button class="swiper-button-prev-news bg-gray-700 hover:bg-gray-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fa-regular fa-square-caret-left"></i>
                </button>
                <button class="swiper-button-next-news bg-gray-700 hover:bg-gray-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fa-regular fa-square-caret-right"></i>
                </button>
            </div>
        </div>

        {{-- Carousel --}}
        @if($news->count())
            <div class="swiper news-swiper">
                <div class="swiper-wrapper">
                    @foreach($news as $item)
                        <div class="swiper-slide !w-auto">
                            <a href="{{ route('news.show', $item->slug) }}" class="block group w-64">
                                <div class="overflow-hidden rounded-lg">
                                    <img src="{{ asset('storage/'.$item->news_thumbnail) }}"
                                         alt="{{ $item->news_title }}"
                                         class="w-full h-40 object-cover transform transition duration-500 group-hover:scale-105">
                                </div>
                                <h3 class="mt-2 font-semibold text-black section_title">
                                    {{ \Illuminate\Support\Str::words($item->news_title, 8, '...') }}
                                </h3>
                                <p class="text-sm text-black">
                                    {{ \Illuminate\Support\Str::words(strip_tags($item->news_description), 12, '...') }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-gray-400 text-center">No news available in this category.</p>
        @endif

    </div>
</div>
</section>
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.news-swiper', {
            slidesPerView: 4,
            spaceBetween: 15,
            navigation: {
                nextEl: '.swiper-button-next-news',
                prevEl: '.swiper-button-prev-news',
            },
            autoplay: true,
            breakpoints: {
                320: { slidesPerView: 1 },
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 4 },
            }
        });
    </script>
@endpush
