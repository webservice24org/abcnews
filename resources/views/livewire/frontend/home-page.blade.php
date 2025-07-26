<div>
   
    @include('partials.front.lead-news', ['leadNews' => $leadNews, 'subLeadNews' => $subLeadNews])

    
    <livewire:frontend.section-card :title="'জাতীয় সংবাদ'" :news="$nationalNews" />

    <livewire:frontend.section-card :title="'আন্তর্জাতিক সংবাদ'" :news="$internationalNews" />

    <livewire:frontend.grid-section-card title="অর্থনীতি" :news="$economyNews" />

    <livewire:frontend.middle-grid-section title="বিনোদন" categorySlug="entertainment" />



    

    
</div>
