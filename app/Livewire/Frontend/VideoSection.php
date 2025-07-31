<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\VideoPost;

class VideoSection extends Component
{
    public function render()
    {
        $videos = VideoPost::where('status', true)
            ->latest()
            ->take(7)
            ->get();

        return view('livewire.frontend.video-section', [
            'videos' => $videos
        ]);
    }
}