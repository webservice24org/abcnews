<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\Category;

class NewsCarousel extends Component
{
    public string $title;
    public string $categorySlug = '';
    public $news;

    public function mount(string $title = '', string $categorySlug = '')
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;

        if ($this->categorySlug) {
            $category = Category::where('slug', $this->categorySlug)
                ->where('status', 1)
                ->first();

            $this->news = $category
                ? $category->newsPosts()
                    ->where('status', 'published')
                    ->latest()
                    ->take(12) // limit news
                    ->get()
                : collect();
        } else {
            $this->news = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontend.news-carousel');
    }
}