<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Str;

class DistrictManager extends Component
{
    use WithPagination;

    public $division_id, $name, $slug;
    public $editingDistrictId, $editingName, $editingDivisionId, $editingSlug;

    
    protected $listeners = ['deleteConfirmed'];

    public function rules()
    {
        return [
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255|unique:districts,name',
            'slug' => 'nullable|string|max:255|unique:districts,slug',
        ];
    }


    public function saveDistrict()
    {
        $this->validate();

        District::create([
            'division_id' => $this->division_id,
            'name' => $this->name,
            'slug' => $this->slug, // Allow custom or null (auto-generated)
        ]);

        $this->reset(['division_id', 'name', 'slug']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'District added successfully.']);
    }


    public function editDistrict($id)
    {
        $district = District::findOrFail($id);
        $this->editingDistrictId = $district->id;
        $this->editingName = $district->name;
        $this->editingDivisionId = $district->division_id;
        $this->editingSlug = $district->slug;
    }

    public function updateDistrict()
    {
        $this->validate([
            'editingDivisionId' => 'required|exists:divisions,id',
            'editingName' => 'required|string|max:255|unique:districts,name,' . $this->editingDistrictId,
            'editingSlug' => 'nullable|string|max:255|unique:districts,slug,' . $this->editingDistrictId,
        ]);

        $district = District::findOrFail($this->editingDistrictId);
        $district->update([
            'division_id' => $this->editingDivisionId,
            'name' => $this->editingName,
            'slug' => $this->editingSlug, // Allow custom or null (auto-generated)
        ]);

        $this->reset(['editingDistrictId', 'editingDivisionId', 'editingName', 'editingSlug']);
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

