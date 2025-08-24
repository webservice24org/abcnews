<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\Advertisement;
use Illuminate\Support\Facades\Storage;

class AdList extends Component
{
    public $ads;
    public $showPreviewModal = false;
    public $previewAd;

    public function mount()
    {
        $this->ads = Advertisement::with(['categories', 'subCategories'])->get();
    }

    public function toggleStatus($adId)
    {
        $ad = Advertisement::find($adId);
        $ad->status = !$ad->status;
        $ad->save();

        $this->ads = Advertisement::with(['categories', 'subCategories'])->get();
    }

    public function preview($adId)
    {
        $this->previewAd = Advertisement::with(['categories', 'subCategories'])->find($adId);
        $this->showPreviewModal = true;
    }



    public function delete($adId)
    {
        $ad = Advertisement::findOrFail($adId);

        
        if ($ad->ad_image && Storage::disk('public')->exists($ad->ad_image)) {
            Storage::disk('public')->delete($ad->ad_image);
        }

       
        $ad->categories()->detach();
        $ad->subcategories()->detach();

        
        $ad->delete();

        
        $this->ads = Advertisement::with(['categories', 'subCategories'])->get();

        $this->dispatch('toast', type: 'success', message: 'Advertisement deleted successfully');

    }


    public function render()
    {
        return view('livewire.admin.ad-list');
    }
}

