<div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-5xl mx-auto px-4 py-4">
    
    {{-- Left column (2 news) --}}
    <div class="md:col-span-1 space-y-4">
        @foreach($leftNews as $news)
            <div class="border-b pb-3">
                <a href="{{ route('news.show', $news->slug) }}" class="block group">
                    <div class="overflow-hidden rounded-md">
                        <img src="{{ $news->news_thumbnail 
                            ? asset('storage/' . $news->news_thumbnail) 
                            : $defaultImage }}"
                            alt="{{ $news->news_title }}"
                            class="w-full h-32 object-cover transform transition duration-500 group-hover:scale-105 group-hover:brightness-90">
                    </div>
                    <h3 class="font-semibold text-gray-800 pt-2 news_title transition">
                        {{ $news->news_title }}
                    </h3>
                </a>
                <p class="text-sm text-gray-600">
                    {{ \Illuminate\Support\Str::words(strip_tags($news->news_description), 20, '...') }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- Middle column (latest lead news) --}}
    <div class="md:col-span-2">
        @if($middleLead)
            <div class="overflow-hidden rounded-lg">
                <a href="{{ route('news.show', $middleLead->slug) }}" class="block group">
                    <div class="overflow-hidden rounded-lg">
                        <img src="{{ $middleLead->news_thumbnail 
                            ? asset('storage/' . $middleLead->news_thumbnail) 
                            : $defaultImage }}" 
                            alt="{{ $middleLead->news_title }}"
                            class="w-full h-64 object-cover transform transition duration-500 group-hover:scale-105 group-hover:brightness-90">
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-2 news_title  transition">
                            {{ $middleLead->news_title }}
                        </h3>
                        <p class="text-gray-700">
                            {{ \Illuminate\Support\Str::words(strip_tags($middleLead->news_description), 20, '...') }}
                        </p>
                    </div>
                </a>
            </div>
        @endif
    </div>

    {{-- Right column (4 sub-leads) --}}
    <div class="md:col-span-1 space-y-4">
        @foreach($rightSubLeads as $sub)
            <div class="border-b pb-2">
                <a href="{{ route('news.show', $sub->slug) }}" class="block group">
                    <h3 class="font-semibold text-gray-800 news_title  transition">
                        {{ $sub->news_title }}
                    </h3>
                </a>
                <p class="text-sm text-gray-600">
                    {{ \Illuminate\Support\Str::words(strip_tags($sub->news_description), 15, '...') }}
                </p>
            </div>
        @endforeach
    </div>

</div>
