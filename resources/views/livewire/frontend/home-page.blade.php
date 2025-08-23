<div>
   
    @if($theme === 'theme1')
        <div class="theme1">
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

            <livewire:frontend.video-section />

            <livewire:frontend.photo-news-section />
        </div>
    @elseif($theme === 'theme2')
        <div class="theme2">
            <livewire:frontend.theme2.lead-news />
            <livewire:frontend.theme2.section-card
                :title="'পলিটিক্যাল পালস'"
                categorySlug="political-puls"
            />

            <livewire:frontend.theme2.culture-trends-section
                :title="'কালচার & ট্রেন্ডস'"
                categorySlug="culture-trends"
            />


        </div>
        @else
        <div class="theme3">
            <p>theme three content</p>

        </div>
    @endif





    

    
</div>
