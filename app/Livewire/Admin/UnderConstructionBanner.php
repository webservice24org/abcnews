<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\UnderConstruction;

class UnderConstructionBanner extends Component
{
    public $banner_id;
    public $banner_text;
    public $start_time;
    public $end_time;

    public $updateMode = false;

    
    protected $rules = [
        'banner_text' => 'required|string|max:255',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
        'status' => 'boolean',
    ];

    public $status = true;


    public function render()
    {
        $banners = UnderConstruction::orderBy('created_at', 'desc')->get();
        return view('livewire.admin.under-construction-banner', compact('banners'));
    }


    // Reset form
    private function resetInput()
    {
        $this->banner_id = null;
        $this->banner_text = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->status = true; // ✅ reset to active by default
    }


    // Create new banner
   public function store()
    {
        $this->validate();

        UnderConstruction::create([
            'banner_text' => $this->banner_text,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status, // ✅ Save status
        ]);

        $this->dispatch('toast', type: 'success', message: 'Banner created successfully.');
        $this->resetInput();
    }


    // Edit banner
    public function edit($id)
    {
        $banner = UnderConstruction::findOrFail($id);
        $this->banner_id = $id;
        $this->banner_text = $banner->banner_text;
        $this->start_time = $banner->start_time->format('Y-m-d\TH:i');
        $this->end_time = $banner->end_time->format('Y-m-d\TH:i');
        $this->status = $banner->status; // ✅ Load status into Livewire
        $this->updateMode = true;
    }


    // Update banner
    public function update()
    {
        $this->validate();

        if ($this->banner_id) {
            $banner = UnderConstruction::find($this->banner_id);
            $banner->update([
                'banner_text' => $this->banner_text,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'status' => $this->status, // ✅ Save status
            ]);

            $this->dispatch('toast', type: 'success', message: 'Banner updated successfully');
            $this->resetInput();
            $this->updateMode = false;
        }
    }

    public function toggleStatus($id)
    {
        $banner = UnderConstruction::findOrFail($id);
        $banner->status = !$banner->status;
        $banner->save();

        $this->dispatch('toast', type: 'success', message: 'Status updated successfully');
    }

    // Delete banner
    public function delete($id)
    {
        if ($id) {
            UnderConstruction::find($id)->delete();
            $this->dispatch('toast', type: 'success', message: 'Banner deleted successfully');
        }
    }

    // Cancel edit
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
}

