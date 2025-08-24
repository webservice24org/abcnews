<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettingForm extends Component
{
    use WithFileUploads;

    public $siteSetting;

    public $header_logo;
    public $footer_logo;
    public $print_logo;
    public $favicon;

    public function mount()
    {
        $this->siteSetting = SiteSetting::first() ?? new SiteSetting();
        $this->header_logo = $this->siteSetting->header_logo;
        $this->footer_logo = $this->siteSetting->footer_logo;
        $this->print_logo = $this->siteSetting->print_logo;
        $this->favicon = $this->siteSetting->favicon;
    }

    public function save()
    {
        // Header Logo
        if (is_object($this->header_logo)) {
            if ($this->siteSetting->header_logo) {
                Storage::disk('public')->delete($this->siteSetting->header_logo);
            }

            $this->siteSetting->header_logo = $this->header_logo->store('logos', 'public');
        }

        // Footer Logo
        if (is_object($this->footer_logo)) {
            if ($this->siteSetting->footer_logo) {
                Storage::disk('public')->delete($this->siteSetting->footer_logo);
            }

            $this->siteSetting->footer_logo = $this->footer_logo->store('logos', 'public');
        }

        // Print Logo
        if (is_object($this->print_logo)) {
            if ($this->siteSetting->print_logo) {
                Storage::disk('public')->delete($this->siteSetting->print_logo);
            }

            $this->siteSetting->print_logo = $this->print_logo->store('logos', 'public');
        }

        // Favicon
        if (is_object($this->favicon)) {
            if ($this->siteSetting->favicon) {
                Storage::disk('public')->delete($this->siteSetting->favicon);
            }

            $this->siteSetting->favicon = $this->favicon->store('logos', 'public');
        }

        $this->siteSetting->save();

        $this->dispatch('toast', type: 'success', message: 'Site settings updated successfully!');

    }


    public function render()
    {
        return view('livewire.admin.site-setting-form');
    }
}
