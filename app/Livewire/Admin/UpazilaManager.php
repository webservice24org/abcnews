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

    public $district_id, $name;
    public $editingUpazilaId = null;
    public $editingName, $editingDistrictId;

    public function saveUpazila()
    {
        $this->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255|unique:upazilas,name',
        ]);

        Upazila::create([
            'district_id' => $this->district_id,
            'name' => $this->name,
        ]);

        $this->reset('district_id', 'name');
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Upazila added successfully.']);
    }

    public function editUpazila($id)
    {
        $upazila = Upazila::findOrFail($id);
        $this->editingUpazilaId = $id;
        $this->editingName = $upazila->name;
        $this->editingDistrictId = $upazila->district_id;
    }

    public function updateUpazila()
    {
        $this->validate([
            'editingDistrictId' => 'required|exists:districts,id',
            'editingName' => 'required|string|max:255|unique:upazilas,name,' . $this->editingUpazilaId,
        ]);

        $upazila = Upazila::findOrFail($this->editingUpazilaId);
        $upazila->update([
            'district_id' => $this->editingDistrictId,
            'name' => $this->editingName,
        ]);

        $this->reset('editingUpazilaId', 'editingName', 'editingDistrictId');
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

