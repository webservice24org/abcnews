<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Category;

class OneNewsRightSection extends Component
{
    public string $title;
    public string $categorySlug;
    public $news;

    public function mount(string $title, string $categorySlug = '')
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;

        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)
                ->where('status', 1)
                ->first();

            $this->news = $category
                ? $category->newsPosts()
                    ->where('status', 'published')
                    ->latest()
                    ->first()
                : null;
        } else {
            $this->news = null;
        }
    }

    public function render()
    {
        return view('livewire.frontend.one-news-right-section');
    }
}
