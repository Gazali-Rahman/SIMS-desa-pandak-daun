<?php

namespace App\Livewire\Warga;

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Dashboard Warga - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Dashboard',
    'sidebar' => 'components.sidebar.main'
])]
class Dashboard extends Component
{
    public function render()
    {
        $userId = Auth::id();

        $stats = [
            'total' => PengajuanSurat::where('user_id', $userId)->count(),
            'menunggu' => PengajuanSurat::where('user_id', $userId)->where('status', 'menunggu')->count(),
            'selesai' => PengajuanSurat::where('user_id', $userId)->where('status', 'selesai')->count(),
            'ditolak' => PengajuanSurat::where('user_id', $userId)->where('status', 'ditolak')->count(),
        ];

        $recentPengajuan = PengajuanSurat::with('jenisSurat')
            ->where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.warga.dashboard', [
            'stats' => $stats,
            'recentPengajuan' => $recentPengajuan,
        ]);
    }
}
