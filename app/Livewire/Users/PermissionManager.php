<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionManager extends Component
{

    protected function ensureAdmin()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            abort(403, 'Unauthorized.');
        }
    }

    public $name, $permissionId, $isEdit = false;
    public $permissions;

    public function mount()
    {
        $this->ensureAdmin();
        $this->loadPermissions();
    }

    public function render()
    {
        return view('livewire.users.permission-manager');
    }

    public function loadPermissions()
    {
        $this->permissions = Permission::orderBy('name')->get();
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

        $permission = Permission::findOrFail($this->permissionId);
        $permission->update(['name' => $this->name]);

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
        Permission::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Permission deleted successfully.');
        $this->loadPermissions();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->permissionId = null;
        $this->isEdit = false;
        $this->loadPermissions();
    }
}
