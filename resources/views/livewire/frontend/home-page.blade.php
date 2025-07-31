<div>
   
    @include('partials.front.lead-news', ['leadNews' => $leadNews, 'subLeadNews' => $subLeadNews])


    <livewire:frontend.section-card title="জাতীয় সংবাদ" :news="$nationalNews" categorySlug="national" />


    <livewire:frontend.section-card :title="'আন্তর্জাতিক সংবাদ'" :news="$internationalNews" categorySlug="international" />
    
    <livewire:frontend.middle-grid-section title="রাজনীতি" categorySlug="politics" />
    
    <livewire:frontend.grid-section-card title="অর্থনীতি" :news="$economyNews" categorySlug="economics" />
    

    <livewire:frontend.middle-grid-section-with-sidebar title="সারা দেশ" categorySlug="country" />


    <livewire:frontend.middle-grid-section title="বিনোদন" categorySlug="entertainment" />
    
    <livewire:frontend.middle-lower-grid-section title="খেলাধুলা" categorySlug="sports" />
    
    <livewire:frontend.section-card :title="'স্বাস্থ্য সংবাদ'" :news="$health" categorySlug="health" />
   
    <livewire:frontend.four-column-category-section />



    

    
</div>
