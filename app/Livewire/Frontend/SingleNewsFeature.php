<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Category;

class SingleNewsFeature extends Component
{
    public string $title;
    public string $categorySlug;

    public function render()
    {
        $category = Category::where('slug', $this->categorySlug)->first();

        $news = $category
            ? $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->first()
            : null;

        return view('livewire.frontend.single-news-feature', [
            'news' => $news
        ]);
    }
}