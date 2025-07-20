<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\District;
use App\Models\Division;

class DistrictManager extends Component
{
    use WithPagination;

    public $division_id, $name;
    public $editingDistrictId, $editingName, $editingDivisionId;
    
    protected $listeners = ['deleteConfirmed'];

    public function rules()
    {
        return [
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255|unique:districts,name',
        ];
    }

    public function saveDistrict()
    {
        $this->validate();

        District::create([
            'division_id' => $this->division_id,
            'name' => $this->name,
        ]);

        $this->reset(['division_id', 'name']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'District added successfully.']);
    }

    public function editDistrict($id)
    {
        $district = District::findOrFail($id);
        $this->editingDistrictId = $district->id;
        $this->editingName = $district->name;
        $this->editingDivisionId = $district->division_id;
    }

    public function updateDistrict()
    {
        $this->validate([
            'editingDivisionId' => 'required|exists:divisions,id',
            'editingName' => 'required|string|max:255|unique:districts,name,' . $this->editingDistrictId,
        ]);

        $district = District::findOrFail($this->editingDistrictId);
        $district->update([
            'division_id' => $this->editingDivisionId,
            'name' => $this->editingName,
        ]);

        $this->reset(['editingDistrictId', 'editingDivisionId', 'editingName']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'District updated successfully.']);
    }

    
    public function confirmDeleteDistrict($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function deleteConfirmed($id)
    {
        District::findOrFail($id)->delete();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'District deleted successfully.'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.district-manager', [
            'divisions' => Division::all(),
            'districts' => District::with('division')->latest()->paginate(10),
        ]);
    }
}

