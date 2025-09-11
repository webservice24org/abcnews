<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\VideoPost;

class VideoCarouselSection extends Component
{
    public string $title = 'Featured Videos';
    public int $limit = 12;

    public function render()
    {
        $videos = VideoPost::where('status', true)
            ->latest()
            ->take($this->limit)
            ->get();

        return view('livewire.frontend.video-carousel-section', compact('videos'));
    }
}
