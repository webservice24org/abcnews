<?php

namespace App\Livewire\Frontend\Theme2;

use Livewire\Component;
use App\Models\Category;

class SectionCard extends Component
{
    public string $title;
    public string $categorySlug;

    public $bigNews = null;
    public $smallNews = [];

   public function mount(string $title, string $categorySlug): void
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;

        
        $category = Category::where('slug', $this->categorySlug)
                            ->where('status', 1) 
                            ->first();

        if (! $category) {
            $this->bigNews = null;
            $this->smallNews = collect();
            return;
        }

        $posts = $category->newsPosts()
                        ->where('status', 'published')
                        ->latest()
                        ->take(5)
                        ->get();

        $this->bigNews   = $posts->first();
        $this->smallNews = $posts->skip(1)->take(4);
    }


    public function render()
    {
        return view('livewire.frontend.theme2.section-card');
    }
}

