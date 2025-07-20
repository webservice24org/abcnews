<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleManager extends Component
{
    protected function ensureAdmin()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            abort(403, 'Unauthorized.');
        }
    }
    public $permissions; // All available permissions
    public $selectedPermissions = []; // Permission IDs selected for current role

    public $roles=[];
    public $roleId, $name;
    public $isEdit = false;

    public function loadRoles()
    {
        $this->ensureAdmin();
        $this->roles = Role::orderBy('name')->get();
    }

    public function mount()
    {
        $this->ensureAdmin();
        $this->loadRoles();
        $this->loadPermissions();
    }


    public function loadPermissions()
    {
        $this->ensureAdmin();
        $this->permissions = Permission::orderBy('name')->get();
    }


    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.users.role-manager');
    }

    public function resetForm()
    {
        $this->roleId = null;
        $this->name = '';
        $this->isEdit = false;
    }

    

    public function store()
    {
        $this->ensureAdmin();
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $this->name]);

        $this->dispatch('toast', type: 'success', message: 'Role created successfully.');
        $this->resetForm();
    }

   

    public function edit($id)
    {
        $this->ensureAdmin();
        $role = Role::findOrFail($id);

        $this->roleId = $id;
        $this->name = $role->name;
        $this->isEdit = true;

        $this->selectedPermissions = $role->permissions->pluck('id')->toArray(); // ✅ Load permissions
    }

    


    public function update()
    {
        $this->ensureAdmin();
      
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->roleId,
        ]);

        $role = Role::findOrFail($this->roleId);
        $role->update(['name' => $this->name]);

        $permissionNames = Permission::whereIn('id', $this->selectedPermissions)->pluck('name');
        $role->syncPermissions($permissionNames); // ✅ Fix is here

        $this->dispatch('toast', type: 'success', message: 'Role updated successfully.');
        $this->resetForm();
    }


    public function toggleSelectAll()
    {
        if ($this->allPermissionsSelected()) {
            $this->selectedPermissions = [];
        } else {
            $this->selectedPermissions = $this->permissions->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }
    }

    public function allPermissionsSelected()
    {
        return count($this->permissions) === count($this->selectedPermissions);
    }




    public function confirmDelete($id)
    {
        $this->ensureAdmin();
        $this->dispatch('confirm-delete', $id); 
    }

    #[\Livewire\Attributes\On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        Role::findOrFail($id)->delete();
        $this->dispatch('toast', type: 'success', message: 'Role deleted successfully.');
    }




}
