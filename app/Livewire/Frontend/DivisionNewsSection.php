<?php

namespace App\Livewire\Frontend;

use App\Models\Division;
use App\Models\NewsPost;
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
        $this->division = Division::where('slug', $slug)->firstOrFail();

        $query = NewsPost::whereHas('district.division', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
        ->where('status', 'published')
        ->latest();

        $this->topLeft = $query->first();
        $this->topRight = (clone $query)->skip(1)->take(4)->get();
    }

    public function render()
    {
        $gridNews = NewsPost::whereHas('district.division', function ($q) {
            $q->where('id', $this->division->id);
        })
        ->where('status', 'published')
        ->latest()
        ->skip(5)
        ->paginate(6);

        return view('livewire.frontend.division-news-section', [
            'division' => $this->division,
            'topLeft' => $this->topLeft,
            'topRight' => $this->topRight,
            'gridNews' => $gridNews,
        ])->layout('layouts.frontend')->title($this->division->division_name);
    }
}
