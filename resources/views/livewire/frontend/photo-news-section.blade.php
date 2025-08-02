<section class="mt-20 ">
    <div class="flex justify-between items-center border-b-3 border-red-700 mb-4">
        <h2 class="text-2xl font-bold text-white bg-red-600 p-2 inline-block">ফটো নিউজ</h2>       
        
        <a href="{{ route('photo-news.index') }}" class="text-sm text-white bg-red-600 hover:bg-red-700 px-4 py-1 rounded shadow-sm transition">আরও দেখুন</a>
       

    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Left Column (Slider for latest photo news gallery) --}}
        <div>
            {{-- Left Column: Tailwind Carousel --}}
            @if ($first && $first->images->count())
                

                <div x-data="{
                        current: 0,
                        images: {{ $first->images->toJson() }},
                        interval: null,
                        start() {
                            this.interval = setInterval(() => {
                                this.current = (this.current + 1) % this.images.length
                            }, 3000);
                        },
                        stop() {
                            clearInterval(this.interval);
                        }
                    }"
                    x-init="start"
                    class="relative overflow-hidden rounded shadow"
                >
                    <template x-for="(img, index) in images" :key="index">
                        <div
                            x-show="current === index"
                            class="transition duration-500 ease-in-out"
                        >
                            <img :src="'/storage/' + img.image" class="w-full h-100 object-cover rounded" alt="">
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white px-4 py-2 text-sm" x-text="img.caption"></div>
                        </div>
                    </template>

                    <!-- Navigation -->
                    <div class="absolute inset-y-0 left-0 flex items-center">
                        <button @click="current = (current - 1 + images.length) % images.length"
                            class="bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-2 rounded-full ml-2">
                            ‹
                        </button>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button @click="current = (current + 1) % images.length"
                            class="bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-2 rounded-full mr-2">
                            ›
                        </button>
                    </div>

                    <!-- Dots -->
                    <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-1">
                        <template x-for="(img, index) in images" :key="index">
                            <div
                                :class="{'bg-white': current === index, 'bg-gray-500': current !== index}"
                                class="w-2 h-2 rounded-full"
                            ></div>
                        </template>
                    </div>
                </div>
                <h2 class="text-xl font-bold mb-2 text-red-600">{{ $first->title }}</h2>
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
                        <h4 class="text-sm font-semibold text-gray-800 hover:text-red-500">{{ $news->title }}</h4>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    


</section>



