<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use App\Models\Advertisement;
use Livewire\Component;

class SectionCard extends Component
{
    public string $title;
    public $news;
    public string $categorySlug = '';
    public $ad = null;

    public function mount(string $title, $news, string $categorySlug = '')
    {
        $this->title = $title;
        $this->news = $news;
        $this->categorySlug = $categorySlug;

        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                $this->ad = Advertisement::whereHas('categories', function ($query) use ($category) {
                        $query->where('categories.id', $category->id);
                    })
                    ->where('ad_name', 'Category Home Section Footer')
                    ->where('status', true)
                    ->latest()
                    ->first();
            }
        }

        
    }

    public function render()
    {
        return view('livewire.frontend.section-card');
    }
}
