<?php

namespace App\Livewire\Frontend;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryNewsSection extends Component
{
    use WithPagination;

    public string $slug;
    public $category;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->category = Category::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        $allNews = $this->category
            ->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->get();

        $topLeft = $allNews->first();
        $topRight = $allNews->slice(1, 5);

        $paginatedNews = $this->category
            ->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->skip(6)
            ->paginate(6);

        return view('livewire.frontend.category-news-section', [
            'topLeft' => $topLeft,
            'topRight' => $topRight,
            'gridNews' => $paginatedNews,
            'category' => $this->category,
        ])->layout('layouts.frontend')->title($this->category->category_name);
    }
}
