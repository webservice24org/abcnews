<?php

namespace App\Livewire\Frontend;

use App\Models\News\Post;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithPagination;


class SubCategoryNewsSection extends Component
{
    use WithPagination;

    public SubCategory $subcategory;
    public $topLeft;
    public $topRight;

    public function mount(SubCategory $subcategory)
    {
        $this->subcategory = $subcategory;

        // Get top 6 items first
        $topItems = $this->subcategory->newsPosts()
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $this->topLeft = $topItems->first();
        $this->topRight = $topItems->slice(1, 5);
    }

    public function render()
    {
        // Get IDs to exclude
        $excludedIds = collect([$this->topLeft])
            ->merge($this->topRight)
            ->pluck('id')
            ->toArray();

        $gridNews = $this->subcategory->newsPosts()
            ->where('status', 'published')
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->paginate(6);

        return view('livewire.frontend.sub-category-news-section', [
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
            'subcategory' => $this->subcategory,
        ])->layout('layouts.frontend')->title($this->subcategory->name);
    }
}
