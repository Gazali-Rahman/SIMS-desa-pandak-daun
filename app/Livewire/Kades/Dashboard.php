<?php

namespace App\Livewire\Kades;

use App\Models\PengajuanSurat;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Dashboard Kepala Desa - SIMS',
    'header' => 'Dashboard Kepala Desa',
    'sidebar' => 'components.sidebar.main'
])]
class Dashboard extends Component
{
    public function setuju(PengajuanSurat $pengajuan)
    {
        $pengajuan->generateNomorSuratAndApprove();

        // Kirim email notifikasi ke warga
        try {
            \Illuminate\Support\Facades\Mail::to($pengajuan->user->email)->send(new \App\Mail\SuratSelesaiMail($pengajuan));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        $pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($pengajuan));

        session()->flash('message', 'Surat berhasil disetujui.');
    }

    public function render()
    {
        $stats = [
            'perlu_ttd' => PengajuanSurat::where('status', 'diproses')->count(),
            'total_disetujui' => PengajuanSurat::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->where('status', 'selesai')->count(),
        ];

        // Jenis surat terbanyak
        $terbanyak = PengajuanSurat::select('jenis_surat_id', DB::raw('count(*) as total'))
            ->with('jenisSurat')
            ->groupBy('jenis_surat_id')
            ->orderByDesc('total')
            ->first();

        $stats['surat_terbanyak'] = $terbanyak ? $terbanyak->jenisSurat->nama : '-';

        $antrean = PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', 'diproses')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.kades.dashboard', [
            'stats' => $stats,
            'antrean' => $antrean,
        ]);
    }
}
