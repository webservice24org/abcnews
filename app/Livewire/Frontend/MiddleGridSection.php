<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use Livewire\Component;

class MiddleGridSection extends Component
{
    public string $title;
    public string $categorySlug;

    public function render()
    {
        $category = Category::where('slug', $this->categorySlug)->first();

        $allNews = $category
            ? $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->take(13)
                ->get()
            : collect();

        $leftNews = $allNews->slice(1, 6);
        $middleNews = $allNews->slice(0, 1)->first();
        $rightNews = $allNews->slice(7, 6);

        return view('livewire.frontend.middle-grid-section', compact(
            'leftNews',
            'middleNews',
            'rightNews'
        ));
    }
}
