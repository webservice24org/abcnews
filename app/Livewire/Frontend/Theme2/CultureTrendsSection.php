<?php

namespace App\Livewire\Frontend\Theme2;
use Livewire\Component;
use App\Models\News\Post;
use App\Models\Category;

class CultureTrendsSection extends Component
{
    public $posts;
    public string $title;
    public string $categorySlug;

    public function mount(string $title, string $categorySlug)
    {
        $this->title = $title;
        $this->categorySlug = $categorySlug;
        $category = Category::where('slug', $categorySlug)->where('status', 1)->first();

        if ($category) {
            $this->posts = $category->newsPosts()
                ->where('status', 'published')
                ->latest()
                ->take(4)
                ->get();
        } else {
            $this->posts = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontend.theme2.culture-trends-section');
    }
}
