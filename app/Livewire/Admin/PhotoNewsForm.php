<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PhotoNews;
use App\Models\PhotoNewsImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PhotoNewsForm extends Component
{
    use WithFileUploads;


    public $description;

    public $imageInputs = []; 
    public $photos = [];
    public $images = [];
    public $captions = [];

    public $status = 'draft';
    public $photoNewsId;
    public $title, $main_thumbnail, $existingThumbnail;

    public function mount($id = null)
{
    if ($id) {
        $news = PhotoNews::with('images')->findOrFail($id);
        $this->photoNewsId = $news->id;
        $this->title = $news->title;
        $this->existingThumbnail = $news->main_thumbnail;
        $this->description = $news->description;
        $this->status = $news->status;

        foreach ($news->images as $i => $img) {
            $this->imageInputs[] = $i; 
            $this->images[$i] = $img->image; 
            $this->captions[$i] = $img->caption;
        }
        

    }
}

    

    public function addImageInput()
    {
        $this->imageInputs[] = count($this->imageInputs);
    }

    public function removeImageInput($index)
    {
        unset($this->imageInputs[$index]);
        unset($this->photos[$index]);
        unset($this->captions[$index]);
    }

    

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'main_thumbnail' => 'required|image|max:2048',
            'photos.*' => 'required|image|max:2048',
            'captions.*' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $photoNews = PhotoNews::create([
            'title' => $this->title,
            'main_thumbnail' => $this->main_thumbnail->store('photo-news', 'public'),
            'description' => $this->description,
            'status' => $this->status,
        ]);

        foreach ($this->photos as $index => $photo) {
            $photoPath = $photo->store('photo-news/images', 'public');

            $photoNews->images()->create([
                'image' => $photoPath,
                'caption' => $this->captions[$index] ?? '',
            ]);
        }

        $this->dispatch('toast', type: 'success', message: 'Photo news created successfully!');
        return redirect()->route('admin.photo-news.index');
    }

    public function updateOrCreate()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'main_thumbnail' => 'nullable|image|max:2048',
            'photos.*' => 'nullable|image|max:2048',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $news = PhotoNews::findOrFail($this->photoNewsId);

        if ($this->main_thumbnail && is_object($this->main_thumbnail)) {
            if ($news->main_thumbnail && Storage::disk('public')->exists($news->main_thumbnail)) {
                Storage::disk('public')->delete($news->main_thumbnail);
            }

            $news->main_thumbnail = $this->main_thumbnail->store('photo-news', 'public');
        }

        $news->title = $this->title;
        $news->description = $this->description;
        $news->status = $this->status;
        $news->save();

        $existingImages = $news->images;

        foreach ($existingImages as $i => $oldImage) {
            $newPhoto = $this->photos[$i] ?? null;
            $caption = $this->captions[$i] ?? '';

            if ($newPhoto && is_object($newPhoto)) {
                if (Storage::disk('public')->exists($oldImage->image)) {
                    Storage::disk('public')->delete($oldImage->image);
                }

                $path = $newPhoto->store('photo-news/photos', 'public');
                $oldImage->update([
                    'image' => $path,
                    'caption' => $caption,
                ]);
            } else {
                $oldImage->update([
                    'caption' => $caption,
                ]);
            }
        }

        if (count($this->photos) > $existingImages->count()) {
            for ($i = $existingImages->count(); $i < count($this->photos); $i++) {
                if ($this->photos[$i] && is_object($this->photos[$i])) {
                    $path = $this->photos[$i]->store('photo-news/photos', 'public');
                    $caption = $this->captions[$i] ?? '';
                    $news->images()->create([
                        'image' => $path,
                        'caption' => $caption,
                    ]);
                }
            }
        }
        $this->dispatch('toast', type: 'success', message: 'Photo news updated successfully!');
        return redirect()->route('admin.photo-news.index');
    }


    public function deleteSavedImage($index)
    {
        $news = PhotoNews::findOrFail($this->photoNewsId);
        $imageModel = $news->images[$index] ?? null;

        if ($imageModel) {
            if (Storage::disk('public')->exists($imageModel->image)) {
                Storage::disk('public')->delete($imageModel->image);
            }

            $imageModel->delete();

            unset($this->images[$index]);
            unset($this->captions[$index]);
            unset($this->imageInputs[$index]);

            $this->images = array_values($this->images);
            $this->captions = array_values($this->captions);
            $this->imageInputs = array_values($this->imageInputs);
        }
    }



    public function render()
    {
        return view('livewire.admin.photo-news-form')
            ->title($this->photoNewsId ? 'Edit Photo News' : 'Create Photo News');
    }
}
