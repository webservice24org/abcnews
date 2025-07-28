<?php

namespace App\Livewire\Frontend;

use App\Models\NewsPost;
use Livewire\Component;

class LatestNewsSidebar extends Component
{
    public function render()
    {
        $latestNews = NewsPost::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.frontend.latest-news-sidebar', compact('latestNews'));
    }
}
