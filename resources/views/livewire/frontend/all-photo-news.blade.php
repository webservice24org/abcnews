<div class="max-w-7xl mx-auto mt-6 grid grid-cols-1 md:grid-cols-12 gap-6 px-4">

    {{-- Left Column (Main Content) --}}
    <div class="md:col-span-8">

        <h2 class="text-2xl font-bold text-red-600 border-b pb-2 mb-4">ফটো গ্যালারি</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($photoNewsList as $news)
                <a href="{{ route('photo-news.show', $news->id) }}" class="block group bg-white rounded shadow overflow-hidden hover:shadow-md transition">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $news->main_thumbnail) }}" alt="{{ $news->title }}"
                            class="w-full h-48 object-cover">
                        <div class="absolute inset-0 flex justify-center items-center group-hover:bg-opacity-50 transition">
                            <i class="fas fa-images text-white text-3xl"></i>
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-sm font-semibold text-gray-800 group-hover:text-red-600">
                            {{ $news->title }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $photoNewsList->links() }}
        </div>
    </div>

    {{-- Right Column (Sidebar) --}}
    <div class="md:col-span-4">
        <livewire:frontend.popular-news-sidebar />
    </div>
</div>
