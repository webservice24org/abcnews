<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\District;
use App\Models\News\Post;
use Livewire\WithPagination;

class DistrictNewsSection extends Component
{
    use WithPagination;

    public District $district;
    public $topLeft;
    public $topRight;

    public function mount($slug)
    {
        $this->district = District::with(['division', 'upazilas'])->where('slug', $slug)->firstOrFail();

        // Get first 6 items (topLeft + topRight)
        $topItems = Post::whereHas('upazila.district', function ($q) use ($slug) {
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
        $excludedIds = collect([$this->topLeft])
            ->merge($this->topRight)
            ->pluck('id')
            ->toArray();

        $gridNews = Post::where('district_id', $this->district->id)
            ->where('status', 'published')
            ->whereNotIn('id', $excludedIds)
            ->latest()
            ->paginate(6);

        return view('livewire.frontend.district-news-section', [
            'district' => $this->district,
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
        ])->layout('layouts.frontend')->title($this->district->district_name);
    }
}