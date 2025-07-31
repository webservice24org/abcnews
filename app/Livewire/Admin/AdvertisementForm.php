<?php

namespace App\Livewire\Admin;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class AdvertisementForm extends Component
{
    use WithFileUploads;

    public $ad_name, $ad_image, $ad_code, $is_global = false, $status = true;
    public $selectedCategories = [];
    public $selectedSubCategories = [];
    public $adId;
    public $existing_ad_image = null;

    public $widgetOptions = [
        'Home Header Bottom',
        'Home Right Sidebar One',
        'Home Right Sidebar Two',
        'Home Above Live',
        'Home Above National',
        'Home Above Entertainment',
        'Home Above Photo Gallery',
        'Single Page Below Article',
        'Single Page Sidebar One',
        'Single Page Sidebar Two',
        'Categoty Below Menu',
        'Categoty Sidebar One',
        'Categoty Sidebar Two',
        'Categoty Before Footer',
    ];

    public function mount($id = null)
    {
        $this->adId = $id;

        if ($this->adId) {
            $ad = Advertisement::with(['categories', 'subCategories'])->findOrFail($this->adId);

            $this->ad_name = $ad->ad_name;
            $this->existing_ad_image = $ad->ad_image;
            $this->ad_code = $ad->ad_code;
            $this->is_global = $ad->is_global;
            $this->status = $ad->status;
            $this->existing_ad_image = $ad->ad_image;
            $this->selectedCategories = $ad->categories->pluck('id')->toArray();
            $this->selectedSubCategories = $ad->subCategories->pluck('id')->toArray();
        }
    }


   

    /*
    public function save()
    {
        $this->validate([
            'ad_name' => 'required|string|max:255',
            'ad_image' => 'nullable|image|max:1024', 
            'ad_code' => 'nullable|string',
            'selectedCategories' => 'array',
            'selectedSubCategories' => 'array',
        ]);

        $ad = Advertisement::create([
            'ad_name' => $this->ad_name,
            'ad_image' => $this->ad_image ? $this->ad_image->store('ads', 'public') : null,
            'ad_code' => $this->ad_code,
            'is_global' => $this->is_global,
            'status' => $this->status,
        ]);

        $ad->categories()->sync($this->selectedCategories);
        $ad->subcategories()->sync($this->selectedSubCategories);

       $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Advertisement saved successfully!',
        ]);

        $this->reset();

    }
        */
    public function save()
    {
        $this->validate([
            'ad_name' => 'required|string|max:255',
            'ad_image' => 'nullable|image|max:1024',
            'ad_code' => 'nullable|string',
            'selectedCategories' => 'array',
            'selectedSubCategories' => 'array',
        ]);

        // Check if editing or creating new
        if ($this->adId) {
            $ad = Advertisement::findOrFail($this->adId);

            // If new image is uploaded, delete old one
            if ($this->ad_image && is_object($this->ad_image)) {
                if ($ad->ad_image && Storage::disk('public')->exists($ad->ad_image)) {
                    Storage::disk('public')->delete($ad->ad_image);
                }

                $ad->ad_image = $this->ad_image->store('ads', 'public');
                $ad->save(); // Save the new image path
            }


            $ad->update([
                'ad_name' => $this->ad_name,
                'ad_code' => $this->ad_code,
                'is_global' => $this->is_global,
                'status' => $this->status,
            ]);
        } else {
            $ad = Advertisement::create([
                'ad_name' => $this->ad_name,
                'ad_image' => $this->ad_image ? $this->ad_image->store('ads', 'public') : null,
                'ad_code' => $this->ad_code,
                'is_global' => $this->is_global,
                'status' => $this->status,
            ]);
        }

        $ad->categories()->sync($this->selectedCategories);
        $ad->subcategories()->sync($this->selectedSubCategories);

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => $this->adId ? 'Advertisement updated successfully!' : 'Advertisement saved successfully!',
        ]);

        $this->reset();
        $this->adId = null;
    }

    public function render()
    {
        return view('livewire.admin.advertisement-form', [
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ]);
    }
}
