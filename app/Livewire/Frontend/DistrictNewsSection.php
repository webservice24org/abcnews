<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\District;
use App\Models\NewsPost;
use Livewire\WithPagination;

class DistrictNewsSection extends Component
{
    use WithPagination;

    public District $district;
    public $topLeft;
    public $topRight;

    public function mount($slug)
    {
        $this->district = District::where('slug', $slug)->firstOrFail();

        $query = NewsPost::where('district_id', $this->district->id)
            ->where('status', 'published')
            ->latest();

        $this->topLeft = $query->first();
        $this->topRight = (clone $query)->skip(1)->take(4)->get();
    }

    public function render()
    {
        $gridNews = NewsPost::where('district_id', $this->district->id)
            ->where('status', 'published')
            ->latest()
            ->skip(5)
            ->paginate(6);

        return view('livewire.frontend.district-news-section', [
            'district' => $this->district,
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
        ])->layout('layouts.frontend')->title($this->district->district_name);
    }
}
