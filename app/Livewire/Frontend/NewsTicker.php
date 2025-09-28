<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Category;

class NewsTicker extends Component
{
    public $news;
    public $uid;

    public function mount()
    {
        $this->uid = 'news-ticker-' . uniqid();

        $category = Category::where('slug', 'breaking-news')->first();

        $this->news = $category
            ? $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->take(12)
                ->get()
            : collect();
    }

    public function render()
    {
        return view('livewire.frontend.news-ticker', [
            'news' => $this->news,
            'uid' => $this->uid,
        ]);
    }
}
