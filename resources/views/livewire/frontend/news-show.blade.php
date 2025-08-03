<div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        {{-- Main Content --}}
        <div class="md:col-span-8 space-y-6">

            {{-- Breadcrumb --}}
            <div class="flex flex-wrap items-center text-sm text-gray-500 gap-2 bg-gray-100 p-2">
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
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600 mt-4">

                {{-- Author Info --}}
                <div class="flex items-center mb-2 md:mb-0">
                    
                    <img src="{{ asset('storage/profiles/2c6EeHpwkCRzLBoFn7EjiBwEYhWDymWr7Mo2ht2y.jpg') }}" class="w-16 h-16" />
                    <span>
                        <strong>{{ $news->user->name ?? 'Unknown' }}</strong> | 
                        প্রকাশ: {{ \App\Helpers\DateHelper::formatBanglaDateTime($news->created_at) }}
                    </span>
                </div>

                {{-- Social Share Icons --}}
                <div class="flex items-center gap-3 text-xl text-gray-700">

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                    target="_blank" class="hover:text-blue-600" title="Share on Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    {{-- X (Twitter) --}}
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($news->news_title) }}"
                    target="_blank" class="hover:text-black" title="Share on X">
                        <i class="fab fa-x-twitter"></i>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ urlencode(Request::fullUrl()) }}"
                    target="_blank" class="hover:text-green-600" title="Share on WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    {{-- Copy Link --}}
                    <button onclick="navigator.clipboard.writeText('{{ Request::fullUrl() }}'); showToast('success', 'Link copied!');"
                            class="hover:text-blue-500" title="Copy link">
                        <i class="fas fa-link"></i>
                    </button>
                    <a href="{{ route('news.print', $news->slug) }}" target="_blank"
                    class="inline-flex items-center gap-1 px-4 py-1 border text-sm rounded hover:bg-gray-100 text-gray-600 border-gray-400">
                        <i class="fas fa-print"></i> প্রিন্ট
                    </a>

                </div>
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
            <livewire:frontend.popular-news-sidebar />
            <livewire:frontend.latest-news-sidebar />
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
                                {{ \App\Helpers\DateHelper::formatBanglaDateTime($post->created_at) }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
