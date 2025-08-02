<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\PhotoNews;

class PhotoNewsSection extends Component
{
    public function render()
    {
        $allPhotoNews = PhotoNews::with('images')
            ->where('status', 'published')
            ->latest()
            ->take(7)
            ->get();

        $first = $allPhotoNews->first();
        $others = $allPhotoNews->skip(1);

        return view('livewire.frontend.photo-news-section', compact('first', 'others'));
    }
}
