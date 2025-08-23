<?php

namespace App\Livewire\Frontend\Theme2;

use Livewire\Component;
use App\Models\News\Post;


class LeadNews extends Component
{
    public $leadNews;
    public $rightTopNews = [];
    public $bottomNews = [];

    public function mount()
    {
        // Get all lead news (max 9 to avoid heavy query)
        $allLeadNews = Post::where('status', 'published')
            ->where('is_lead', true)
            ->latest()
            ->take(9)
            ->get();

        // Assign safely
        $this->leadNews     = $allLeadNews->first();
        $this->rightTopNews = $allLeadNews->skip(1)->take(4);
        $this->bottomNews   = $allLeadNews->skip(5)->take(4);
    }

    public function render()
    {
        return view('livewire.frontend.theme2.lead-news');
    }
}


