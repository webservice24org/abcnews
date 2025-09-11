<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Category;

class FourCategorySection extends Component
{
    public array $categories = []; // e.g. ['us-canada', 'world', 'business', 'sport']

    public function render()
    {
        $categoryData = [];

        foreach ($this->categories as $slug) {
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                $news = $category->newsPosts()
                    ->where('status', 'published')
                    ->latest()
                    ->take(5)
                    ->get();

                $categoryData[] = [
                    'title' => $category->name,
                    'slug' => $category->slug,
                    'featured' => $news->first(),
                    'others' => $news->skip(1),
                ];
            }
        }

        return view('livewire.frontend.four-category-section', [
            'categoryData' => $categoryData
        ]);
    }
}
