<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\VideoPost;
use Illuminate\Support\Facades\Storage;

class VideoPostForm extends Component
{
    use WithFileUploads;

    public $video_title, $video_description, $video_link, $thumbnail, $existing_thumbnail, $status = true;
    public $videoId;

    public function mount($id = null)
    {
        if ($id) {
            $video = VideoPost::findOrFail($id);
            $this->videoId = $video->id;
            $this->video_title = $video->video_title;
            $this->video_description = $video->video_description;
            $this->video_link = $video->video_link;
            $this->existing_thumbnail = $video->thumbnail;
            $this->status = $video->status;
        }
    }



    public function save()
    {
        $this->validate([
            'video_title' => 'required|string|max:255',
            'video_link' => 'required',
            'thumbnail' => 'nullable|image|max:1024',
        ]);

        if ($this->videoId) {
            $video = VideoPost::findOrFail($this->videoId);

            if ($this->thumbnail && is_object($this->thumbnail)) {
                if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                    Storage::disk('public')->delete($video->thumbnail);
                }

                $video->thumbnail = $this->thumbnail->store('videos', 'public');
            }

            $video->update([
                'video_title' => $this->video_title,
                'video_description' => $this->video_description,
                'video_link' => $this->video_link,
                'status' => $this->status,
            ]);
        } else {
            $video = VideoPost::create([
                'video_title' => $this->video_title,
                'video_description' => $this->video_description,
                'video_link' => $this->video_link,
                'thumbnail' => $this->thumbnail ? $this->thumbnail->store('videos', 'public') : null,
                'status' => $this->status,
            ]);
        }

        $this->reset();
        $this->dispatch('toast', type: 'success', message: 'Video post saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.video-post-form');
    }
}