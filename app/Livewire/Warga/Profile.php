<?php

namespace App\Livewire\Warga;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Profil Saya - SIMS',
    'header' => 'Profil Pengguna',
    'sidebar' => 'components.sidebar.main'
])]
class Profile extends Component
{
    public $name;
    public $email;
    public $nik;
    public $phone;
    public $address;
    public $rt;
    public $rw;
    public $village;
    public $district;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nik = $user->nik;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->rt = $user->rt;
        $this->rw = $user->rw;
        $this->village = $user->village;
        $this->district = $user->district;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'nik' => 'nullable|string|size:16|unique:users,nik,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'village' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'nik' => $this->nik,
            'phone' => $this->phone,
            'address' => $this->address,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'village' => $this->village,
            'district' => $this->district,
        ]);

        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.warga.profile');
    }
}
