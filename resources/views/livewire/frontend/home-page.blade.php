<div>
   
    @include('partials.front.lead-news', ['leadNews' => $leadNews, 'subLeadNews' => $subLeadNews])

    
    <livewire:frontend.section-card title="জাতীয় সংবাদ" :news="$nationalNews" categorySlug="national" />


    <livewire:frontend.section-card :title="'আন্তর্জাতিক সংবাদ'" :news="$internationalNews" categorySlug="international" />

    <livewire:frontend.grid-section-card title="অর্থনীতি" :news="$economyNews" categorySlug="economics" />

    <livewire:frontend.middle-grid-section title="বিনোদন" categorySlug="entertainment" />



    

    
</div>
