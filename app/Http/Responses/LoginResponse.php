<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->hasRole('staff')) {
            $home = route('dashboard');
        } elseif ($user->hasRole('kepala_desa')) {
            $home = route('kades.dashboard');
        } else {
            $home = route('warga.dashboard');
        }

        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect($home); // UBAH: Hapus metode intended()
    }
}
