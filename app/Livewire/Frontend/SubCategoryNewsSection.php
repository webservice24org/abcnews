<?php

namespace App\Livewire\Frontend;

use App\Models\NewsPost;
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

        $query = $this->subcategory->newsPosts()
            ->where('status', 1)
            ->latest();

        $this->topLeft = $query->first();
        $this->topRight = $query->skip(1)->take(4)->get();
    }

    public function render()
    {
        $gridNews = $this->subcategory->newsPosts()
            ->where('status', 1)
            ->latest()
            ->skip(5)
            ->paginate(6);

        return view('livewire.frontend.sub-category-news-section', [
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
            'subcategory' => $this->subcategory,
        ])->layout('layouts.frontend')->title($this->subcategory->name);
    }
}
