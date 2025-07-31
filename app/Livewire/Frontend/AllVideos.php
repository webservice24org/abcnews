<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\VideoPost;

class AllVideos extends Component
{
    use WithPagination;

    public function render()
    {
        $videos = VideoPost::latest()->paginate(12); // 4x3 layout

        return view('livewire.frontend.all-videos', [
            'videos' => $videos
        ])->layout('layouts.frontend')->title('সব ভিডিও');
    }
}