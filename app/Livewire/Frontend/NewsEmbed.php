<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\News\Post;

class NewsEmbed extends Component
{
    public $news;

    public function mount($slug)
    {
        $this->news = Post::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.news-embed')
            ->layout('layouts.embed'); // use a minimal layout for iframe
    }
}
