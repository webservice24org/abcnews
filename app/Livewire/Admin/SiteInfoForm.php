<?php

namespace App\Livewire\Admin;

use App\Models\SiteInfo;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SiteInfoForm extends Component
{
    use WithFileUploads;

    public $siteInfo;
    public $site_name;
    public $tagline;
    public $meta_tags;
    public $meta_description;
    public $site_image;
    public $copyright_info;

    public function mount()
    {
        $this->siteInfo = SiteInfo::first() ?? new SiteInfo();
        $this->site_name = $this->siteInfo->site_name;
        $this->tagline = $this->siteInfo->tagline;
        $this->meta_tags = $this->siteInfo->meta_tags;
        $this->meta_description = $this->siteInfo->meta_description;
        $this->copyright_info = $this->siteInfo->copyright_info;
    }

    public function save()
    {
        $this->siteInfo->site_name = $this->site_name;
        $this->siteInfo->tagline = $this->tagline;
        $this->siteInfo->meta_tags = $this->meta_tags;
        $this->siteInfo->meta_description = $this->meta_description;
        $this->siteInfo->copyright_info = $this->copyright_info;

        if ($this->site_image && is_object($this->site_image)) {
            if ($this->siteInfo->site_image) {
                Storage::disk('public')->delete($this->siteInfo->site_image);
            }

            $this->siteInfo->site_image = $this->site_image->store('logos', 'public');
        }

        
        $this->siteInfo->save();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Site info updated successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.site-info-form');
    }
}
