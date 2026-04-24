<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component
{
    public int $step = 1;
    
    // Step 1: Data Utama
    public string $nik = '';
    public string $name = '';
    public string $phone = '';
    
    // Step 2: Alamat
    public string $address = '';
    public string $rt = '';
    public string $rw = '';
    
    // Step 3: Akun
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'nik' => ['required', 'string', 'size:16', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'address' => ['required', 'string', 'max:255'],
                'rt' => ['required', 'string', 'max:3'],
                'rw' => ['required', 'string', 'max:3'],
            ]);
        }
        
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function register()
    {
        $this->validate([
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'nik' => $this->nik,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'email' => $this->email ?: null,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('warga');

        Auth::login($user);

        return redirect()->route('warga.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
