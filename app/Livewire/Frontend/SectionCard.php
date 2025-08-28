<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use App\Models\Advertisement;
use Livewire\Component;

class SectionCard extends Component
{
    public string $title;
    public string $categorySlug = '';
    public $news;
    public $ad = null;

    public function mount(string $title, string $categorySlug = '')
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;

        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)
                ->where('status', 1)
                ->first();

            if ($category) {
                // Load posts dynamically
                $this->news = $category->newsPosts()
                    ->where('status', 'published')
                    ->latest()
                    ->take(8)
                    ->get();

                // Load advertisement
                $this->ad = Advertisement::whereHas('categories', function ($query) use ($category) {
                        $query->where('categories.id', $category->id);
                    })
                    ->where('ad_name', 'Category Home Section Footer')
                    ->where('status', true)
                    ->latest()
                    ->first();
            } else {
                $this->news = collect(); // empty collection if category not found
            }
        } else {
            $this->news = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontend.section-card');
    }
}

