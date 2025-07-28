<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        {{-- Main Content --}}
        <div class="md:col-span-8 space-y-6">

            {{-- Breadcrumb --}}
            <div class="flex flex-wrap items-center text-sm text-gray-500 gap-2">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600">
                    {{-- Home Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v7a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
                    </svg>
                </a>

                @foreach ($news->categories as $cat)
                    <span>/</span>
                    <a href="{{ route('category.show', $cat->slug) }}" class="hover:text-red-600">
                        {{ $cat->name }}
                    </a>
                @endforeach

                @foreach ($news->subcategories as $sub)
                    <span>/</span>
                    <a href="{{ route('subcategory.show', $sub->slug) }}" class="hover:text-red-600">
                        {{ $sub->name }}
                    </a>
                @endforeach
            </div>



            {{-- Title --}}
            <h1 class="text-3xl font-bold text-black">{{ $news->news_title }}</h1>

            {{-- Author & Date --}}
            <div class="flex items-center text-sm text-gray-600">
                @if ($news->user && $news->user->profile?->profile_photo)
                    <img src="{{ asset('storage/' . $news->user->profile->profile_photo) }}" class="h-8 w-8 rounded-full mr-2" alt="{{ $news->user->name }}">
                @endif
                <span>
                    <strong>{{ $news->user->name ?? 'Unknown' }}</strong> | 
                   প্রকাশ: {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at) }}
                   
                </span>
            </div>

            {{-- Thumbnail --}}
            @if ($news->news_thumbnail)
                <img src="{{ asset('storage/' . $news->news_thumbnail) }}" alt="{{ $news->news_title }}"
                     class="w-full rounded shadow-sm my-4">
            @endif

            {{-- Description --}}
            <div class="news-show-descp">
                {!! $news->news_description !!}
            </div>

            {{-- Tags --}}
            @if($news->tags->isNotEmpty())
                <div class="mt-4">
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($news->tags as $tag)
                            <a href=""
                            class="text-xs bg-gray-100 border border-gray-300 px-2 py-1 rounded hover:bg-red-600 hover:text-white transition">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="hidden md:flex  items-start gap-3 bg-white border border-gray-200 rounded-lg p-1 shadow-sm hover:shadow-md transition mt-2">
                <img src="{{ asset('storage/ads/national-categoryad.png') }}" alt="add" class="object-fill">
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="md:col-span-4">
            @livewire('frontend.popular-news-sidebar')
            @livewire('frontend.latest-news-sidebar')
            <livewire:frontend.news-archive-search />


        </div>

        
    </div>
    
    @if($relatedPosts->isNotEmpty())
        <section class="mt-10 bg-white shadow rounded p-4">
            <h3 class="text-xl font-bold text-black border-b border-red-600 pb-2 mb-6">
                {{ $primaryCategory->name ?? 'সংবাদ' }} নিয়ে আরও পড়ুন
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedPosts as $post)
                    <div>
                        <a href="{{ route('news.show', $post->slug) }}">
                            <img src="{{ asset('storage/' . $post->news_thumbnail) }}"
                                alt="{{ $post->news_title }}"
                                class="w-full h-40 object-cover rounded mb-2">
                            <h4 class="text-md font-semibold text-black hover:text-blue-600 leading-snug">
                                {{ \Illuminate\Support\Str::limit($post->news_title, 70) }}
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $post->created_at->format('M d, Y') }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
