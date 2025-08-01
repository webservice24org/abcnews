<div class="grid md:grid-cols-12 gap-6">
    {{-- Left 8-column: Video --}}
    <div class="md:col-span-8">
        <div class="aspect-w-16 aspect-h-9">
            <iframe class="h-110 w-full" src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($video->video_link, 'v=') }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            
        </div>

        <h1 class="text-2xl font-semibold my-3 text-black">{{ $video->video_title }}</h1>
        <p class="text-gray-700 text-2xl">{{ $video->video_description }}</p>
        <p class="text-gray-700 text-sm">প্রকাশ: {{ \App\Helpers\DateHelper::formatBanglaDateTime($video->created_at) }}</p>

        <div class="mt-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Related Videos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($relatedVideos as $related)
                    <div class="space-y-2">
                        <a href="{{ route('video.show', $related->id) }}">
                            <div class="relative w-full aspect-video rounded overflow-hidden">
                                <img src="{{ asset('storage/' . $related->thumbnail) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 flex justify-center items-center hover:bg-opacity-60 transition">
                                    <i class="fas fa-play-circle text-red-500 text-2xl"></i>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('video.show', $related->id) }}">
                            <h4 class="text-md font-medium text-black">{{ $related->video_title }}</h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        
    </div>

    {{-- Right 4-column: Sidebar --}}
    <div class="md:col-span-4">
        <livewire:frontend.popular-news-sidebar />
    </div>
</div>
