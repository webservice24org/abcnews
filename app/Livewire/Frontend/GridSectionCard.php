<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\Category;

class GridSectionCard extends Component
{
    public string $title;
    public string $categorySlug = '';
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
                    ->take(9)
                    ->get()
                : collect();
        } else {
            $this->news = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontend.grid-section-card');
    }
}