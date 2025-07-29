<?php

namespace App\Livewire\Frontend;

use App\Models\Upazila;
use App\Models\NewsPost;
use Livewire\Component;
use Livewire\WithPagination;

class UpazilaNewsSection extends Component
{
    use WithPagination;

    public Upazila $upazila;
    public $topLeft;
    public $topRight;

    public function mount($slug)
    {
        $this->upazila = Upazila::with(['district.division'])->where('slug', $slug)->firstOrFail();

        // Fetch first 6 posts for top section
        $topItems = NewsPost::where('upazila_id', $this->upazila->id)
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $this->topLeft = $topItems->first();
        $this->topRight = $topItems->slice(1, 5);
    }

    public function render()
    {
        // Collect top post IDs to exclude from pagination
        $excludedIds = collect([$this->topLeft])
            ->merge($this->topRight)
            ->pluck('id')
            ->toArray();

        $gridNews = NewsPost::where('upazila_id', $this->upazila->id)
            ->where('status', 'published')
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->paginate(6);

        return view('livewire.frontend.upazila-news-section', [
            'upazila' => $this->upazila,
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
        ])->layout('layouts.frontend')->title($this->upazila->upazila_name);
    }
}
