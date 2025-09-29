<?php

namespace App\Livewire\Frontend\Theme2;

use Livewire\Component;
use App\Models\News\Post;

class LeadNewsAlt extends Component
{
    public $mainNews;
    public $leftNews = [];
    public $rightNews = [];
    public $bottomNews = [];

    public function mount()
    {
        // Get up to 12 lead posts for layout
        $allLeadNews = Post::where('status', 'published')
            ->where('is_lead', true)
            ->latest()
            ->take(12)
            ->get();

        $this->mainNews   = $allLeadNews->first();  
        $this->leftNews   = $allLeadNews->skip(1)->take(2);  
        $this->rightNews  = $allLeadNews->skip(3)->take(5);  
        $this->bottomNews = $allLeadNews->skip(8)->take(4);  
    }

    public function render()
    {
        return view('livewire.frontend.theme2.lead-news-alt');
    }
}

