<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionManager extends Component
{
    use WithPagination;

    public $name, $permissionId, $isEdit = false;

    protected function ensureAdmin()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin'])) {
            abort(403, 'Unauthorized.');
        }
    }

    public function render()
    {
        

        return view('livewire.users.permission-manager', [
            'permissions' => Permission::orderBy('name')->paginate(10)
        ]);
    }

    public function store()
    {
        $this->ensureAdmin();
        $this->validate(['name' => 'required|unique:permissions,name']);

        Permission::create(['name' => $this->name]);
        $this->dispatch('toast', type: 'success', message: 'Permission created successfully.');

        $this->resetForm();
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $permission = Permission::findOrFail($id);
        $this->permissionId = $id;
        $this->name = $permission->name;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->ensureAdmin();
        $this->validate([
            'name' => 'required|unique:permissions,name,' . $this->permissionId,
        ]);

        Permission::findOrFail($this->permissionId)->update(['name' => $this->name]);

        $this->dispatch('toast', type: 'success', message: 'Permission updated successfully.');
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        $this->ensureAdmin();
        $this->dispatch('confirm-delete', $id);
    }

    #[\Livewire\Attributes\On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $this->ensureAdmin();
        Permission::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Permission deleted successfully.');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->permissionId = null;
        $this->isEdit = false;

        $this->resetPage();
    }
}