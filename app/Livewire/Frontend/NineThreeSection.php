<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use Livewire\Component;

class NineThreeSection extends Component
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
                ->take(9)
                ->get()
            : collect();

        $topMain     = $allNews->slice(0, 1)->first();   // big top left
        $leftGrid    = $allNews->slice(1, 2);            // 2x2 grid under main
        $rightTop    = $allNews->slice(3, 1)->first();   // right column top
        $rightSmall  = $allNews->slice(4, 2);            // right column small news

        return view('livewire.frontend.nine-three-section', compact(
            'topMain', 'leftGrid', 'rightTop', 'rightSmall'
        ));
    }
}
