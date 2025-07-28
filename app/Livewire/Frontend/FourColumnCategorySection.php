<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Category;

class FourColumnCategorySection extends Component
{
    public function render()
    {
        $categorySlugs = [
            'information-technology',
            'media',
            'education',
            'openion',
        ];

        $sections = [];

        foreach ($categorySlugs as $slug) {
            $category = Category::where('slug', $slug)->first();

            $newsPosts = $category
                ? $category->newsPosts()
                    ->where('status', 'published')
                    ->latest()
                    ->take(6)
                    ->get()
                : collect();

            $sections[] = [
                'category' => $category,
                'latest' => $newsPosts->first(),
                'others' => $newsPosts->slice(1),
            ];
        }

        return view('livewire.frontend.four-column-category-section', [
            'sections' => $sections,
        ]);
    }
}