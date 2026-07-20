<?php

namespace App\Livewire\Staff;

use App\Models\PengajuanSurat;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Dashboard Staff - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Dashboard Staff',
    'sidebar' => 'components.sidebar.main'
])]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'hari_ini' => PengajuanSurat::whereDate('created_at', Carbon::today())->count(),
            'perlu_verifikasi' => PengajuanSurat::where('status', 'menunggu')->count(),
            'sedang_diproses' => PengajuanSurat::where('status', 'diproses')->count(),
            'selesai_bulan_ini' => PengajuanSurat::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->where('status', 'selesai')->count(),
        ];

        $pengajuanTerbaru = PengajuanSurat::with(['user', 'jenisSurat'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.staff.dashboard', [
            'stats' => $stats,
            'pengajuanTerbaru' => $pengajuanTerbaru,
        ]);
    }
}
