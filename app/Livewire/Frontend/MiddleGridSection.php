<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use App\Models\Advertisement;
use Livewire\Component;

class MiddleGridSection extends Component
{
    public string $title;
    public string $categorySlug;
    public $ad = null;

    public function render()
    {
        $category = Category::where('slug', $this->categorySlug)->where('status', 1)->first();

        $allNews = $category
            ? $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->take(13)
                ->get()
            : collect();

        $leftNews   = $allNews->slice(1, 4);
        $middleNews = $allNews->first();
        $rightNews  = $allNews->slice(5, 4);

        if ($category) {
            $this->ad = Advertisement::whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category->id);
                })
                ->where('ad_name', 'Category Home Section Footer')
                ->where('status', true)
                ->latest()
                ->first();
        }

        // Pass $allNews so Blade can check empty state
        return view('livewire.frontend.middle-grid-section', compact(
            'allNews',
            'leftNews',
            'middleNews',
            'rightNews'
        ));
    }
}
