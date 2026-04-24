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
        $count = PengajuanSurat::where('jenis_surat_id', $pengajuan->jenis_surat_id)
            ->where('status', 'selesai')
            ->whereYear('created_at', date('Y'))
            ->count() + 1;

        $kode = $pengajuan->jenisSurat->kode ?? 'SRT';
        $urutan = str_pad($count, 3, '0', STR_PAD_LEFT);

        $map = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $romawiBulan = $map[date('n')];
        $tahun = date('Y');

        $nomorSurat = "140/$urutan/$kode/$romawiBulan/$tahun";

        $pengajuan->update([
            'status' => 'selesai',
            'nomor_surat' => $nomorSurat,
        ]);

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
