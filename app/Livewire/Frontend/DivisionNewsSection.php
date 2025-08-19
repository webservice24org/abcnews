<?php

namespace App\Livewire\Frontend;

use App\Models\Division;
use App\Models\News\Post;
use Livewire\Component;
use Livewire\WithPagination;

class DivisionNewsSection extends Component
{
    use WithPagination;

    public Division $division;
    public $topLeft;
    public $topRight;

    public function mount($slug)
    {
        $this->division = Division::with('districts')->where('slug', $slug)->firstOrFail();

        // Get first 6 posts (1 for topLeft, 5 for topRight)
        $topItems = Post::whereHas('district.division', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
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

        $gridNews = Post::whereHas('district.division', function ($q) {
                $q->where('id', $this->division->id);
            })
            ->where('status', 'published')
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->paginate(7);

        return view('livewire.frontend.division-news-section', [
            'division' => $this->division,
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
        ])->layout('layouts.frontend')->title($this->division->division_name);
    }
}