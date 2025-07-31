<div class="bg-white rounded shadow p-2">
    <h1 class="text-2xl font-bold mb-4 text-red-600">সব ভিডিও</h1>

    @if ($videos->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($videos as $video)
                <div class="group">
                    <a href="{{ route('video.show', $video->id) }}" class="block relative overflow-hidden rounded shadow">
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->video_title }}"
                             class="w-full h-40 object-cover">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-play-circle text-white text-3xl"></i>
                        </div>
                    </a>
                    <h3 class="mt-2 text-sm font-medium text-black hover:underline">
                        <a href="{{ route('video.show', $video->id) }}">{{ $video->video_title }}</a>
                    </h3>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $videos->links() }}
        </div>
    @else
        <p class="text-gray-600">No videos found.</p>
    @endif
</div>
