<div>
    @if($leadSettings && $leadSettings->enabled)
        @if($leadSettings->design === 'design1')
            @include('partials.front.lead-news', ['leadNews' => $leadNews, 'subLeadNews' => $subLeadNews])
        @elseif($leadSettings->design === 'design2')
            <livewire:frontend.theme2.lead-news />
        @endif
    @endif


    {{-- Loop through dynamic sections from DB --}}
@foreach($sections as $section)
    @switch($section->component)
        @case('section-card')
            <livewire:frontend.section-card 
                :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
                :categorySlug="$section->category?->slug" />
            @break

        @case('grid-section-card')
            <livewire:frontend.grid-section-card 
                :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
                :categorySlug="$section->category?->slug" />
            @break

        @case('middle-grid-section')
            <livewire:frontend.middle-grid-section 
                :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
                :categorySlug="$section->category?->slug" />
            @break

        @case('middle-grid-section-with-sidebar')
            <livewire:frontend.middle-grid-section-with-sidebar 
                :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
                :categorySlug="$section->category?->slug" />
            @break

        @case('middle-lower-grid-section')
            <livewire:frontend.middle-lower-grid-section 
                :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
                :categorySlug="$section->category?->slug" />
            @break

        @case('culture-trends-section')
        <livewire:frontend.theme2.culture-trends-section 
            :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
            :categorySlug="$section->category?->slug" />
        @break

        @case('simple-section-card')
        <livewire:frontend.theme2.section-card 
            :title="$section->title ? $section->title : ($section->category?->name ?? '')" 
            :categorySlug="$section->category?->slug" />
        @break

        @case('four-column-category-section')
            <livewire:frontend.four-column-category-section 
                :title="$section->title ?? 'Categories'" />
            @break

        @case('video-section')
            <livewire:frontend.video-section 
                :title="$section->title ?? 'Videos'" />
            @break

        @case('photo-news-section')
            <livewire:frontend.photo-news-section 
                :title="$section->title ?? 'Photos'" />
            @break
    @endswitch
@endforeach

</div>
