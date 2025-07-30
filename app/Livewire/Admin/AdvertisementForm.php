<?php

namespace App\Livewire\Admin;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdvertisementForm extends Component
{
    use WithFileUploads;

    public $ad_name, $ad_image, $ad_code, $is_global = false, $status = true;
    public $selectedCategories = [];
    public $selectedSubCategories = [];

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

    public function render()
    {
        return view('livewire.admin.advertisement-form', [
            'categories' => Category::all(),
            'subcategories' => SubCategory::all(),
        ]);
    }
}
