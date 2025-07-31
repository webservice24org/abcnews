<div class="my-6">
    <a href="{{ route('videos.all') }}">
        <h2 class="text-xl font-bold border-b pb-2 mb-4 text-red-600">ভিডিও</h2>
    </a>


     @php
        $last = $videos->first();
        $others = $videos->skip(1)->take(6);
    @endphp
    @if ($videos->count())
        <div class="grid md:grid-cols-2 gap-4">
            {{-- Left Column: Latest video --}}
            <div class="relative group">
                <a href="{{ route('video.show', $last->id) }}">
                    <img src="{{ asset('storage/' . $last->thumbnail) }}" class="w-full h-100 object-cover rounded">

                    <div class="absolute inset-0 flex justify-center items-center  group-hover:bg-opacity-70 transition">
                        <i class="fas fa-play-circle text-red-500 text-5xl"></i>
                    </div>
                </a>
                <a href="{{ route('video.show', $last->id) }}" class="hover:text-red-500">
                    <h3 class="mt-2 text-2xl font-semibold hover:text-red-500 text-black">{{ $last->video_title }}</h3>
                </a>
            </div>

            {{-- Right Column: Next 6 videos --}}
           <div class="grid grid-cols-3 gap-4">
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
                            <h4 class="text-md font-medium hover:text-red-500 text-black">{{ $video->video_title }}</h4>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    @endif
</div>
