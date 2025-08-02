<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\PhotoNews;
use Livewire\WithPagination;

class AllPhotoNews extends Component
{
    use WithPagination;

    public function render()
    {
        $photoNewsList = PhotoNews::where('status', 'published')
            ->latest()
            ->paginate(12); // ✅ 12 items per page

        return view('livewire.frontend.all-photo-news', [
            'photoNewsList' => $photoNewsList,
        ])->layout('layouts.frontend')->title('ফটো গ্যালারি');
    }
}