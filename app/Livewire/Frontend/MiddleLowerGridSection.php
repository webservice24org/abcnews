<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class MiddleLowerGridSection extends Component
{
    use WithPagination;
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

        $middleNews = $allNews->slice(0, 1)->first();       // 1 news in the middle
        $leftNews = $allNews->slice(1, 2);                  // 2 news on the left
        $rightNews = $allNews->slice(3, 2);                 // 2 news on the right
        $bottomNews = $allNews->slice(5, 4);                // 4 news in grid below

        return view('livewire.frontend.middle-lower-grid-section', compact(
            'middleNews', 'leftNews', 'rightNews', 'bottomNews'
        ));
    }
}