<?php

namespace App\Livewire\Frontend\Theme2;

use Livewire\Component;
use App\Models\Category;

class SectionCard extends Component
{
    public string $title;
    public string $categorySlug;

    // View data
    public $bigNews = null;
    public $smallNews = [];

    public function mount(string $title, string $categorySlug): void
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;

        // Find category
        $category = Category::where('slug', $this->categorySlug)->first();

        if (! $category) {
            $this->bigNews = null;
            $this->smallNews = collect();
            return;
        }

        // Pull max 5 posts via pivot: 1 big + 4 small (handles <5 automatically)
        $posts = $category->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        $this->bigNews   = $posts->first();
        $this->smallNews = $posts->skip(1)->take(4);
    }

    public function render()
    {
        return view('livewire.frontend.theme2.section-card');
    }
}

