<?php

namespace App\Livewire\Kades;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Manajemen Role - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Manajemen Role & Hak Akses',
    'sidebar' => 'components.sidebar.main'
])]
class RoleManager extends Component
{
    public $roles;
    public $showRoleModal = false;
    public $showPermissionModal = false;

    // Role form
    public $roleId = null;
    public $roleName = '';

    // Permission form
    public $selectedRole = null;
    public $selectedPermissions = [];
    public $permissionsList = [];

    public function mount()
    {
        $this->loadRoles();
        $this->permissionsList = Permission::all();
    }

    public function loadRoles()
    {
        $this->roles = Role::with('permissions')->get();
    }

    public function createRole()
    {
        $this->resetValidation();
        $this->roleId = null;
        $this->roleName = '';
        $this->showRoleModal = true;
    }

    public function editRole($id)
    {
        $this->resetValidation();
        $role = Role::findOrFail($id);

        // Prevent editing default core roles to avoid breaking the system
        if (in_array($role->name, ['warga', 'staff', 'kepala_desa'])) {
            session()->flash('error', 'Role utama sistem tidak dapat diubah namanya.');
            return;
        }

        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->showRoleModal = true;
    }

    public function saveRole()
    {
        $this->validate([
            'roleName' => 'required|min:3|unique:roles,name,' . $this->roleId
        ]);

        if ($this->roleId) {
            $role = Role::find($this->roleId);
            $role->update(['name' => strtolower(str_replace(' ', '_', $this->roleName))]);
            session()->flash('message', 'Role berhasil diperbarui.');
        } else {
            Role::create(['name' => strtolower(str_replace(' ', '_', $this->roleName))]);
            session()->flash('message', 'Role baru berhasil ditambahkan.');
        }

        $this->showRoleModal = false;
        $this->loadRoles();
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['warga', 'staff', 'kepala_desa'])) {
            session()->flash('error', 'Role utama sistem tidak dapat dihapus.');
            return;
        }

        $role->delete();
        session()->flash('message', 'Role berhasil dihapus.');
        $this->loadRoles();
    }

    public function managePermissions($id)
    {
        $this->selectedRole = Role::findOrFail($id);
        $this->selectedPermissions = $this->selectedRole->permissions->pluck('name')->toArray();
        $this->showPermissionModal = true;
    }

    public function savePermissions()
    {
        if ($this->selectedRole) {
            $this->selectedRole->syncPermissions($this->selectedPermissions);
            session()->flash('message', 'Hak akses berhasil diperbarui.');
            $this->showPermissionModal = false;
            $this->loadRoles();
        }
    }

    public function render()
    {
        return view('livewire.kades.role-manager');
    }
}
