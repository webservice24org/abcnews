<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserList extends Component
{

    protected function ensureAdmin()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            abort(403, 'Unauthorized.');
        }
    }


    public $users;

    // New user modal controls
    public $showCreateModal = false;
    public $newName, $newEmail, $newPassword, $newPasswordConfirmation, $newSelectedRoles = [];

    public function create()
    {
        $this->ensureAdmin();
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function store()
    {
        $this->ensureAdmin();
        $this->validate([
            'newName' => 'required|string|max:255',
            'newEmail' => 'required|email|unique:users,email',
            'newPassword' => 'required|min:6|same:newPasswordConfirmation',
        ]);

        $user = User::create([
            'name' => $this->newName,
            'email' => $this->newEmail,
            'password' => Hash::make($this->newPassword),
            'is_active' => false, 
        ]);


        $roleNames = Role::whereIn('id', $this->newSelectedRoles)->pluck('name');
        $user->syncRoles($roleNames);

        $this->dispatch('toast', type: 'success', message: 'User created successfully.');
        $this->resetForm();
        $this->loadUsers();
    }

    


    // Editing
    public $editUserId, $name, $email, $selectedRoles = [], $showEditModal = false;
    public $allRoles;

    public function mount()
    {
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            abort(403, 'You are not authorized to access this section.');
        }

        $this->loadUsers();
        $this->allRoles = Role::orderBy('name')->get();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $this->editUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->showEditModal = true;
    }

    public function updateUser()
    {
        $this->ensureAdmin();
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->editUserId,
        ]);

        $user = User::findOrFail($this->editUserId);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $roleNames = Role::whereIn('id', $this->selectedRoles)->pluck('name');
        $user->syncRoles($roleNames); 

        $this->dispatch('toast', type: 'success', message: 'User updated successfully.');
        $this->resetForm();
        $this->loadUsers();
    }


    public function resetForm()
    {
        // Edit modal
        $this->editUserId = null;
        $this->name = '';
        $this->email = '';
        $this->selectedRoles = [];
        $this->showEditModal = false;

        // Create modal
        $this->newName = '';
        $this->newEmail = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
        $this->newSelectedRoles = [];
        $this->showCreateModal = false;
    }

    public function render()
    {
        return view('livewire.users.user-list');
    }

    public function toggleStatus($userId)
    {
        $this->ensureAdmin();
        $user = User::findOrFail($userId);

        // Only allow if current user is admin/super admin
        if (!auth()->user()->hasAnyRole(['Super Admin', 'Admin'])) {
            abort(403, 'Unauthorized');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $this->dispatch('toast', type: 'success', message: 'User status updated.');
        $this->loadUsers();
    }

    

}

