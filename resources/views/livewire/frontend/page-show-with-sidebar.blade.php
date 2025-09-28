<div class="py-8 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto ">
    <div class="col-span-2 bg-white shadow rounded p-6 space-y-4">
        @if($page->page_thumbnail)
            <img src="{{ asset('storage/' . $page->page_thumbnail) }}" 
                 alt="{{ $page->title }}" 
                 class="mb-6 w-full h-auto">
        @endif

        <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>

        <div class="prose max-w-none">
            {!! $page->description !!}
        </div>

        {{-- Show contact form only on contact-us page --}}
        @if($page->slug === 'contact-us')
            <div class="mt-6">
                <livewire:frontend.contact-form />
            </div>
        @endif
    </div>

    <div class="col-span-1">
       <livewire:frontend.popular-news-sidebar />
       <livewire:frontend.news-archive-search />
    </div>
</div>
