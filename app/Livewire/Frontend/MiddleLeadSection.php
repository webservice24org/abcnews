<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\News\Post;

class MiddleLeadSection extends Component
{
    public $middleLead;
    public $leftNews = [];
    public $rightSubLeads = [];

    public function mount()
    {
        // Get lead news (latest + 2 older for left column)
        $leadNews = Post::where('status', 'published')
            ->where('is_lead', true)
            ->latest()
            ->take(3)
            ->get();

        $this->middleLead = $leadNews->first();
        $this->leftNews   = $leadNews->skip(1)->take(2);

        // Get sub-lead news for right column
        $this->rightSubLeads = Post::where('status', 'published')
            ->where('is_sub_lead', true)
            ->latest()
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.middle-lead-section');
    }
}
