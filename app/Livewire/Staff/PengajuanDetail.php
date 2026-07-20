<?php

namespace App\Livewire\Staff;

use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Detail Pengajuan - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Verifikasi Berkas Pengajuan',
    'sidebar' => 'components.sidebar.main'
])]
class PengajuanDetail extends Component
{
    public PengajuanSurat $pengajuan;

    public string $status;
    public string $catatan = '';

    public function mount(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan->load(['user', 'jenisSurat']);
        $this->status = $this->pengajuan->status;
        $this->catatan = $this->pengajuan->catatan ?? '';
    }

    public function updateStatus()
    {
        $this->validate([
            'status' => 'required|in:menunggu,diproses,ditolak',
            'catatan' => 'required_if:status,ditolak',
        ]);

        $this->pengajuan->update([
            'status' => $this->status,
            'catatan' => $this->status === 'ditolak' ? $this->catatan : null,
        ]);

        $this->pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($this->pengajuan));

        session()->flash('message', 'Status pengajuan berhasil diperbarui.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.staff.pengajuan-detail');
    }
}
