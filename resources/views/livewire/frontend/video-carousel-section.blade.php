{{-- Full width black background --}}
<div class="w-full bg-black py-10">
    {{-- Container --}}
    <div class="max-w-5xl mx-auto px-4">

        {{-- Section title + nav --}}
        <div class="flex items-center justify-between border-b border-gray-600 mb-6">
            <h2 class="text-xl font-bold text-white px-2">
                {{ $title }}
            </h2>
            <div class="flex space-x-2 mb-1">
                <button class="swiper-button-prev-video bg-gray-700 hover:bg-gray-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fa-regular fa-square-caret-right"></i>
                </button>
                <button class="swiper-button-next-video bg-gray-700 hover:bg-gray-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fa-regular fa-square-caret-right"></i>
                </button>
            </div>
        </div>

        {{-- Carousel --}}
        <div class="swiper video-swiper">
            <div class="swiper-wrapper">
                @foreach($videos as $video)
                    <div class="swiper-slide !w-auto">
                        <a href="{{ route('video.show', $video->id) }}" class="block group w-64">
                            <div class="overflow-hidden rounded-lg">
                                <img src="{{ $video->thumbnail 
                                        ? asset('storage/'.$video->thumbnail) 
                                        : asset('images/default-video.jpg') }}"
                                     alt="{{ $video->video_title }}"
                                     class="w-full h-40 object-cover transform transition duration-500 group-hover:scale-105">
                            </div>
                            <h3 class="mt-2 font-semibold text-white section_title">
                                {{ \Illuminate\Support\Str::words($video->video_title, 8, '...') }}
                            </h3>
                            <p class="text-sm text-gray-300">
                                {{ \Illuminate\Support\Str::words(strip_tags($video->video_description), 12, '...') }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        new Swiper('.video-swiper', {
            slidesPerView: 4,
            spaceBetween: 15,
            navigation: {
                nextEl: '.swiper-button-next-video',
                prevEl: '.swiper-button-prev-video',
            },
            autoplay: false, // slider OFF by default
            breakpoints: {
                320: { slidesPerView: 1 },
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 4 },
            }
        });
    </script>
@endpush
