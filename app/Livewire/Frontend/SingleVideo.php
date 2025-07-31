<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\VideoPost;

class SingleVideo extends Component
{
    public $video;

    public function mount($id)
    {
        $this->video = VideoPost::findOrFail($id);
    }

    public function render()
    {
        $relatedVideos = VideoPost::where('id', '!=', $this->video->id)
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.frontend.single-video', [
            'video' => $this->video,
            'relatedVideos' => $relatedVideos,
        ])->layout('layouts.frontend')
        ->title($this->video->video_title);
    }

    

}