<?php

namespace App\Livewire\Frontend;

use App\Models\NewsPost;
use Livewire\Component;

class NewsShow extends Component
{
    public $slug;
    public $news;
    public $relatedPosts;
    public $primaryCategory;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->news = NewsPost::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $this->news->increment('view_count');

        // Try to get primary category
        $this->primaryCategory = $this->news->categories->first();

        if ($this->primaryCategory) {
            $this->relatedPosts = $this->primaryCategory
                ->newsPosts()
                ->where('status', 'published')
                ->where('id', '!=', $this->news->id)
                ->latest()
                ->take(4)
                ->get();
        } elseif ($this->news->subcategories->isNotEmpty()) {
            $subcategory = $this->news->subcategories->first();
            $this->primaryCategory = $subcategory->category ?? null;

            $this->relatedPosts = $subcategory
                ->newsPosts()
                ->where('status', 'published')
                ->where('id', '!=', $this->news->id)
                ->latest()
                ->take(4)
                ->get();
        } else {
            $this->relatedPosts = collect();
        }
    }

    public function render()
    {
        return view('livewire.frontend.news-show', [
            'news' => $this->news,
            'relatedPosts' => $this->relatedPosts,
            'primaryCategory' => $this->primaryCategory,
        ])->layout('layouts.frontend')
          ->title($this->news->news_title);
    }
}
