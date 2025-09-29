<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\Category;
use App\Models\SubCategory;

class GridSectionCard extends Component
{
    public string $title;
    public string $categorySlug = '';
    public $news;
    public $subcategories;

    public function mount(string $title, string $categorySlug = '')
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;

        if (!empty($categorySlug)) {
            $category = Category::with(['subCategories' => function ($q) {
                $q->where('status', 1); // only active subcategories
            }])
            ->where('slug', $categorySlug)
            ->where('status', 1)
            ->first();

            if ($category) {
                $this->news = $category->newsPosts()
                    ->where('status', 'published')
                    ->latest()
                    ->take(9)
                    ->get();

                $this->subcategories = $category->subCategories;
            } else {
                $this->news = collect();
                $this->subcategories = collect();
            }
        } else {
            $this->news = collect();
            $this->subcategories = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontend.grid-section-card');
    }
}
