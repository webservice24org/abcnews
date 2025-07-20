<?php

namespace App\Livewire\Admin;

use App\Models\Division;
use Livewire\Component;
use Livewire\WithPagination;

class DivisionManager extends Component
{
    use WithPagination;

    public $name, $editingName, $editingDivisionId = null;
     
    protected $listeners = ['deleteConfirmed'];

    protected $rules = [
        'name' => 'required|string|max:255|unique:divisions,name',
    ];

    public function saveDivision()
    {
        $this->validate();

        Division::create(['name' => $this->name]);
        $this->reset('name');

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Division added successfully.'
        ]);
    }

    public function editDivision($id)
    {
        $division = Division::findOrFail($id);
        $this->editingDivisionId = $division->id;
        $this->editingName = $division->name;
    }

    public function updateDivision()
    {
        $this->validate([
            'editingName' => 'required|string|max:255|unique:divisions,name,' . $this->editingDivisionId,
        ]);

        $division = Division::findOrFail($this->editingDivisionId);
        $division->update(['name' => $this->editingName]);

        
        $this->editingDivisionId = null;
        $this->editingName = '';

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Division updated successfully.'
        ]);
    }


    public function confirmDeleteDivision($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    public function deleteConfirmed($id)
    {
        Division::findOrFail($id)->delete();

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Division deleted successfully.'
        ]);
    }

    public function render()
    {
        $divisions = Division::latest()->paginate(10);
        return view('livewire.admin.division-manager', compact('divisions'));
    }
}
