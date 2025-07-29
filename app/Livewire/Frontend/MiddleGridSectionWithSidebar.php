<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use Livewire\Component;
use App\Models\Division;

class MiddleGridSectionWithSidebar extends Component
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
                ->take(7)
                ->get()
            : collect();

        $middleNews = $allNews->slice(0, 1)->first();
        $leftNews = $allNews->slice(1, 6);

        $divisions = Division::all(); // 👈 Add this

        return view('livewire.frontend.middle-grid-section-with-sidebar', compact(
            'category',
            'middleNews',
            'leftNews',
            'divisions' // 👈 Add this
        ));
    }
}
