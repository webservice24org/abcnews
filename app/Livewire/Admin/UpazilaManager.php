<?php

namespace App\Livewire\Admin;

use App\Models\Upazila;
use App\Models\District;
use Livewire\Component;
use Livewire\WithPagination;

class UpazilaManager extends Component
{
    use WithPagination;

    
    protected $listeners = ['deleteConfirmed'];

    public $district_id, $name, $slug;
    public $editingUpazilaId = null;
    public $editingName, $editingDistrictId, $editingSlug;


   public function saveUpazila()
    {
        $this->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255|unique:upazilas,name',
            'slug' => 'nullable|string|max:255|unique:upazilas,slug',
        ]);

        Upazila::create([
            'district_id' => $this->district_id,
            'name' => $this->name,
            'slug' => $this->slug, // optional slug
        ]);

        $this->reset('district_id', 'name', 'slug');
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Upazila added successfully.']);
    }


    public function editUpazila($id)
    {
        $upazila = Upazila::findOrFail($id);
        $this->editingUpazilaId = $id;
        $this->editingName = $upazila->name;
        $this->editingDistrictId = $upazila->district_id;
        $this->editingSlug = $upazila->slug;
    }


    public function updateUpazila()
{
    $this->validate([
        'editingDistrictId' => 'required|exists:districts,id',
        'editingName' => 'required|string|max:255|unique:upazilas,name,' . $this->editingUpazilaId,
        'editingSlug' => 'nullable|string|max:255|unique:upazilas,slug,' . $this->editingUpazilaId,
    ]);

    $upazila = Upazila::findOrFail($this->editingUpazilaId);
    $upazila->update([
        'district_id' => $this->editingDistrictId,
        'name' => $this->editingName,
        'slug' => $this->editingSlug,
    ]);

    $this->reset('editingUpazilaId', 'editingName', 'editingDistrictId', 'editingSlug');
    $this->dispatch('toast', ['type' => 'success', 'message' => 'Upazila updated successfully.']);
}


     public function confirmDeleteUpazila($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function deleteConfirmed($id)
    {
        Upazila::findOrFail($id)->delete();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Upazila deleted successfully.',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.upazila-manager', [
            'upazilas' => Upazila::with('district')->latest()->paginate(10),
            'districts' => \App\Models\District::all(),
        ]);
    }
}

