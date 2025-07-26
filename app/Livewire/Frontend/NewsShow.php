<?php

namespace App\Livewire\Frontend;

use App\Models\NewsPost;
use Livewire\Component;

class NewsShow extends Component
{
    public $slug;
    public $news;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->news = NewsPost::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
            $this->news->increment('view_count');
    }

    public function render()
    {
        return view('livewire.frontend.news-show', [
            'news' => $this->news,
        ])->layout('layouts.frontend')
          ->title($this->news->news_title);
    }
}

