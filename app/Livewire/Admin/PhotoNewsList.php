<?php

namespace App\Livewire\Admin;

use App\Models\PhotoNews;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class PhotoNewsList extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $deleteId = null;

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function delete()
    {
        $news = PhotoNews::findOrFail($this->deleteId);

        // Delete main thumbnail
        if ($news->main_thumbnail && Storage::disk('public')->exists($news->main_thumbnail)) {
            Storage::disk('public')->delete($news->main_thumbnail);
        }

        // Delete associated images
        foreach ($news->images as $image) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $news->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Photo News deleted successfully.');
    }

    public function render()
    {
        $photoNewsList = PhotoNews::latest()->paginate(10);

        return view('livewire.admin.photo-news-list', compact('photoNewsList'));
    }
}
