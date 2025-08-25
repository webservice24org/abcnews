<section class="video-section">
   @if($theme === 'theme1')
    <div class="flex justify-between items-center border-b-3 mb-4" style="border-color: {{ $color->sec_border_color ?? '#e7000b' }};">
        <h2 class="text-2xl font-bold p-2 inline-block" style="background-color: {{ $color->sec_title_bg ?? '#e7000b' }}; color: {{ $color->sec_title_color ?? '#fff' }};">ভিডিও</h2>       
        
        <a href="{{ route('videos.all') }}" class="text-sm hover:bg-red-700 px-4 py-1 rounded shadow-sm transition" style="background-color:{{ $color->cat_btn_bg ?? '#e7000b' }}; color:{{$color->cat_btn_color ?? '#e7000b'}}">আরও দেখুন</a>
       

    </div>
    @elseif($theme === 'theme2')
    <div class="flex items-center justify-between mb-6 pb-2 border-b border-gray-200 sectionHeader" >
         <a href="{{ route('videos.all') }}" class="text-black hoverEffect">
            <h2 class="text-2xl font-bold text-gray-800">ভিডিও</h2>       
        </a>
        <a href="{{ route('videos.all') }}" class="text-blue-600 text-sm hover:underline" >আরও দেখুন →</a>
       

    </div>
    @else
        <div class="theme3">
            <p>theme three content</p>

        </div>
    @endif


     @php
        $last = $videos->first();
        $others = $videos->skip(1)->take(6);
    @endphp
    @if ($videos->count())
        <div class="grid md:grid-cols-2 gap-4">
            <div class="relative group videoBlock">
                <a href="{{ route('video.show', $last->id) }}">
                    <img src="{{ asset('storage/' . $last->thumbnail) }}" class="w-full object-cover rounded">

                    <div class="absolute inset-0 flex justify-center items-center  group-hover:bg-opacity-70 transition">
                        <i class="fas fa-play-circle text-red-500 text-5xl"></i>
                    </div>
                </a>
                <a href="{{ route('video.show', $last->id) }}">
                    <h2 class="mt-2 font-semibold hover:underline">{{ $last->video_title }}</h2>
                </a>
            </div>

           <div class="grid grid-cols-2 md:grid-cols-3 gap-4 rightVideoBlock">
    @foreach ($others as $video)
        <div class="space-y-2">
            <a href="{{ route('video.show', $video->id) }}">
                <div class="relative w-full aspect-video overflow-hidden rounded">
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 flex justify-center items-center hover:bg-opacity-60 transition">
                        <i class="fas fa-play-circle text-red-500 text-2xl"></i>
                    </div>
                </div>
            </a>
            <a href="{{ route('video.show', $video->id) }}">
                <h2 class="hover:underline font-semibold text-sm md:text-base">{{ $video->video_title }}</h2>
            </a>
        </div>
    @endforeach
</div>



        </div>
    @endif
</section>
