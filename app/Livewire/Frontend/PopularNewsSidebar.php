<?php

namespace App\Livewire\Frontend;

use App\Models\News\Post;
use Livewire\Component;

class PopularNewsSidebar extends Component
{
    public function render()
    {
        $popularNews = Post::where('status', 'published')
            ->orderByDesc('view_count')
            ->take(5)
            ->get();

        return view('livewire.frontend.popular-news-sidebar', compact('popularNews'));
    }
}
