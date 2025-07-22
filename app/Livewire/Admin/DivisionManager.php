<?php

namespace App\Livewire\Admin;

use App\Models\Division;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class DivisionManager extends Component
{
    use WithPagination;

    public $name;
    public $slug;
    public $editingDivisionId = null;
    public $editingName;
    public $editingSlug;

    protected $listeners = ['deleteConfirmed'];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:divisions,name,' . ($this->editingDivisionId ?? 'NULL'),
            'slug' => 'nullable|string|max:255|unique:divisions,slug,' . ($this->editingDivisionId ?? 'NULL'),
        ];
    }

    public function saveDivision()
    {
        $this->validate();

        Division::create([
            'name' => $this->name,
            'slug' => $this->slug ?: Str::slug($this->name), // auto-generate slug if empty
        ]);

        $this->reset('name', 'slug');

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
        $this->editingSlug = $division->slug;
    }

    public function updateDivision()
    {
        $this->validate([
            'editingName' => 'required|string|max:255|unique:divisions,name,' . $this->editingDivisionId,
            'editingSlug' => 'nullable|string|max:255|unique:divisions,slug,' . $this->editingDivisionId,
        ]);

        $division = Division::findOrFail($this->editingDivisionId);
        $division->update([
            'name' => $this->editingName,
            'slug' => $this->editingSlug ?: \Str::slug($this->editingName), // auto-generate slug if empty
        ]);

        $this->reset('editingDivisionId', 'editingName', 'editingSlug');

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
