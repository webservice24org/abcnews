<div class="bg-white p-6 space-y-4 max-w-5xl mx-auto px-4 py-4"> 
    @if($page->page_thumbnail)
        <img src="{{ asset('storage/' . $page->page_thumbnail) }}" 
             alt="{{ $page->title }}" 
             class="mb-6 w-full h-auto">
    @endif

    <h1 class="text-3xl font-bold mb-4">{{ $page->title }}</h1>

    <div class="prose max-w-none">
        {!! $page->description !!}
    </div>

    {{-- Show contact form only if page is contact-us --}}
    @if($page->slug === 'contact-us')
        <div class="mt-6">
            <livewire:frontend.contact-form />
        </div>
    @endif
</div>
