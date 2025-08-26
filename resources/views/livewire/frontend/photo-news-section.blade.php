<section class="mt-20 ">
    <div class="flex justify-between items-center border-b-3 mb-4" style="border-color: {{ $color->sec_border_color ?? '#e7000b' }};">
        <h2 class="text-2xl font-bold p-2 inline-block" style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }}; color: {{ $color->sec_title_color ?? '#fff' }};">ফটো নিউজ</h2>       
        
        <a href="{{ route('photo-news.index') }}" class="text-sm hover:bg-red-700 px-4 py-1 rounded shadow-sm transition" style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }}; color:{{$color->cat_btn_color ?? '#e7000b'}}">আরও দেখুন</a>
       

    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Left Column (Slider for latest photo news gallery) --}}
       <div>
    @if ($first && $first->images->count())
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                @foreach ($first->images as $index => $img)
                    <div class="hidden duration-700 ease-in-out" 
                         data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $img->image) }}"
                             class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                             alt="{{ $img->caption ?? 'slide-' . $index }}">
                        @if ($img->caption)
                            <div class="absolute bottom-0 left-0 right-0 bg-black/60 text-white px-4 py-2 text-sm">
                                {{ $img->caption }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
                @foreach ($first->images as $index => $img)
                    <button type="button"
                            class="w-3 h-3 rounded-full"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"
                            data-carousel-slide-to="{{ $index }}">
                    </button>
                @endforeach
            </div>

            <!-- Controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4"
                    data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50">
                    ‹
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4"
                    data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50">
                    ›
                </span>
            </button>
        </div>

        <h2 class="text-xl font-bold mb-2 news_title">{{ $first->title }}</h2>
    @endif
</div>



        {{-- Right Column (Next 6 Photo News Cards) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($others as $news)
                <a href="{{ route('photo-news.show', $news->id) }}" class="block rounded overflow-hidden group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $news->main_thumbnail) }}" alt="{{ $news->title }}"
                            class="w-full h-50 object-cover transform group-hover:scale-105 transition">
                        <div class="absolute inset-0 flex justify-center items-center group-hover:bg-opacity-60 transition">
                            <i class="fas fa-images text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="p-2">
                        <h4 class="text-sm font-semibold news_title">{{ $news->title }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    


</section>



@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carouselEl = document.getElementById('default-carousel');
        if (carouselEl) {
            const carousel = new Carousel(carouselEl, {
                interval: 3000,   // autoplay every 3s
                ride: "carousel"  // start automatically
            });
        }
    });
</script>

@endpush