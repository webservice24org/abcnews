<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\SubCategory;

class MiddleLowerGridSection extends Component
{
    use WithPagination;

    public string $title;
    public string $categorySlug;
    public $subcategories; 

    public function render()
    {
        $category = Category::with(['subCategories' => function ($q) {
                $q->where('status', 1);
            }])
            ->where('slug', $this->categorySlug)
            ->where('status', 1)
            ->first();

        $this->subcategories = $category ? $category->subCategories : collect();

        $allNews = $category
            ? $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->take(9)
                ->get()
            : collect();

        $middleNews = $allNews->slice(0, 1)->first(); 
        $leftNews   = $allNews->slice(1, 2);                
        $rightNews  = $allNews->slice(3, 2);                
        $bottomNews = $allNews->slice(5, 4);                

        return view('livewire.frontend.middle-lower-grid-section', compact(
            'middleNews', 'leftNews', 'rightNews', 'bottomNews'
        ));
    }
}