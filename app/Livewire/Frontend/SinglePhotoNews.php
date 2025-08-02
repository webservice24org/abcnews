<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use App\Models\PhotoNews;

class SinglePhotoNews extends Component
{
    public $photoNews;

    public function mount($id)
    {
        $this->photoNews = PhotoNews::with('images')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.frontend.single-photo-news', [
            'photoNews' => $this->photoNews,
        ])->layout('layouts.frontend')->title($this->photoNews->title);
    }
}