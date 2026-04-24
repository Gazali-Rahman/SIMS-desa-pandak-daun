<?php

namespace App\Livewire\Kades;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Manajemen Pengguna - SIMS',
    'header' => 'Manajemen Pengguna',
    'sidebar' => 'components.sidebar.main'
])]
class UserManager extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';

    public $selectedUser = null;
    public $newRole = '';
    public $showRoleModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function openRoleModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUser = $user;
        $this->newRole = $user->roles->first()->name ?? '';
        $this->showRoleModal = true;
    }

    public function changeRole()
    {
        $this->validate([
            'newRole' => 'required|exists:roles,name',
        ]);

        if ($this->selectedUser) {
            $this->selectedUser->syncRoles([$this->newRole]);
            session()->flash('message', 'Role pengguna berhasil diperbarui.');
            $this->showRoleModal = false;
        }
    }

    public function render()
    {
        $query = User::with('roles')
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });

        if ($this->roleFilter) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->roleFilter);
            });
        }

        return view('livewire.kades.user-manager', [
            'users' => $query->latest()->paginate(10),
            'roles' => Role::all(),
        ]);
    }
}
