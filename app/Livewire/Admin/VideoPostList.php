<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\VideoPost;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class VideoPostList extends Component
{
    use WithPagination;

    public $videos;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    

    public function mount()
    {
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->videos = VideoPost::latest()->get();
    }

    public function delete($id)
    {
        $video = VideoPost::findOrFail($id);

        if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Video post saved successfully!']);
        $this->loadVideos();
    }

    public function toggleStatus($id)
    {
        $video = VideoPost::findOrFail($id);
        $video->status = !$video->status;
        $video->save();

        $this->loadVideos();
    }


    public function render()
    {
        $videos = VideoPost::when($this->search, function ($query) {
        $query->where('video_title', 'like', '%' . $this->search . '%');
    })
    ->latest()
    ->paginate(10); 


        return view('livewire.admin.video-post-list', compact('videos'));
    }


}