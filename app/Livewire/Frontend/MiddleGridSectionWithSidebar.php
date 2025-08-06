<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use App\Models\Advertisement;
use App\Models\Division;
use Livewire\Component;

class MiddleGridSectionWithSidebar extends Component
{
    public string $title;
    public string $categorySlug;
    public $ad = null;

    public function render()
    {
        $category = Category::where('slug', $this->categorySlug)->first();

        $allNews = $category
            ? $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->take(8)
                ->get()
            : collect();

        $middleNews = $allNews->slice(0, 1)->first();
        $leftNews = $allNews->slice(1, 7);

        $divisions = Division::all();

       
        if ($category) {
            $this->ad = Advertisement::whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category->id);
                })
                ->where('ad_name', 'Category Home Section Footer')
                ->where('status', true)
                ->latest()
                ->first();
        }


        return view('livewire.frontend.middle-grid-section-with-sidebar', compact(
            'category',
            'middleNews',
            'leftNews',
            'divisions'
        ));
    }
}
