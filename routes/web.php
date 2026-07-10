<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Warga\Dashboard as WargaDashboard;
use App\Livewire\Warga\PengajuanForm;
use App\Livewire\Warga\RiwayatPengajuan;
use App\Livewire\Staff\Dashboard as StaffDashboard;
use App\Livewire\Staff\PengajuanDetail;
use App\Livewire\Staff\PengajuanIndex;
use App\Livewire\Staff\MasterSurat;
use App\Livewire\Kades\Dashboard as KadesDashboard;
use App\Livewire\Kades\PersetujuanIndex;

Route::get('/', function () {
    return redirect()->route('login');
});

// Warga routes
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/', WargaDashboard::class)->name('dashboard');
    Route::get('/pengajuan/buat', PengajuanForm::class)->middleware('verified')->name('pengajuan.create');
    Route::get('/pengajuan/riwayat', RiwayatPengajuan::class)->name('pengajuan.index');
    Route::get('/profile', \App\Livewire\Warga\Profile::class)->name('profile');
});

// Staff routes
Route::middleware(['auth', 'role:staff|kepala_desa'])->group(function () {
    Route::get('/dashboard', StaffDashboard::class)->name('dashboard');
    Route::get('/pengajuan', PengajuanIndex::class)->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', PengajuanDetail::class)->name('pengajuan.show');
    Route::get('/master-surat', MasterSurat::class)->name('master-surat');
    Route::get('/data-warga', \App\Livewire\Staff\DataWarga::class)->name('data-warga');
    Route::get('/laporan', \App\Livewire\Kades\LaporanIndex::class)->name('laporan.index');
    Route::get('/laporan/cetak', function (\Illuminate\Http\Request $request) {
        $query = \App\Models\PengajuanSurat::with(['user', 'jenisSurat']);

        if ($request->start) $query->whereDate('created_at', '>=', $request->start);
        if ($request->end) $query->whereDate('created_at', '<=', $request->end);
        if ($request->status) $query->where('status', $request->status);
        if ($request->jenis) $query->where('jenis_surat_id', $request->jenis);

        $data = $query->latest()->get();
        $stats = [
            'total' => $data->count(),
            'disetujui' => $data->where('status', 'selesai')->count(),
            'ditolak' => $data->where('status', 'ditolak')->count(),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan', [
            'pengajuan' => $data,
            'stats' => $stats,
            'startDate' => $request->start,
            'endDate' => $request->end,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Desa_Pandak_Daun.pdf');
    })->name('laporan.cetak');
});

// Kades routes
Route::middleware(['auth', 'role:kepala_desa'])->prefix('kades')->name('kades.')->group(function () {
    Route::get('/', KadesDashboard::class)->name('dashboard');
    Route::get('/persetujuan', PersetujuanIndex::class)->name('persetujuan.index');

    // Manajemen Sistem
    Route::get('/users', \App\Livewire\Kades\UserManager::class)->name('users.index');
    Route::get('/roles', \App\Livewire\Kades\RoleManager::class)->name('roles.index');
});

// Shared PDF Print Route
Route::middleware(['auth'])->group(function () {
    Route::get('/surat/{pengajuan}/cetak', function (\App\Models\PengajuanSurat $pengajuan) {
        // Hanya owner, staff, atau kades yang boleh cetak
        $user = auth()->user();
        if ($user->id !== $pengajuan->user_id && !$user->hasRole(['staff', 'kepala_desa'])) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan surat sudah selesai
        if ($pengajuan->status !== 'selesai') {
            abort(404, 'Surat belum selesai diproses.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat', ['pengajuan' => $pengajuan]);

        return $pdf->stream('Surat_' . $pengajuan->jenisSurat->kode . '_' . $pengajuan->user->name . '.pdf');
    })->name('surat.cetak');
});
