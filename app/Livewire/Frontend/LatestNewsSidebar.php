<?php

namespace App\Livewire\Frontend;

use App\Models\News\Post;
use Livewire\Component;

class LatestNewsSidebar extends Component
{
    public function render()
    {
        $latestNews = Post::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.frontend.latest-news-sidebar', compact('latestNews'));
    }
}
