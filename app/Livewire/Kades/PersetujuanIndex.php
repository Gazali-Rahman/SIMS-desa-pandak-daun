<?php

namespace App\Livewire\Kades;

use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Persetujuan Surat - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Persetujuan Kepala Desa',
    'sidebar' => 'components.sidebar.main'
])]
class PersetujuanIndex extends Component
{
    use WithPagination;

    public $search = '';

    // For rejection modal
    public $showRejectModal = false;
    public $rejectId = null;
    public $catatan = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setuju(PengajuanSurat $pengajuan)
    {
        // Kades approves the request
        $pengajuan->generateNomorSuratAndApprove();

        // Kirim email notifikasi ke warga
        try {
            \Illuminate\Support\Facades\Mail::to($pengajuan->user->email)->send(new \App\Mail\SuratSelesaiMail($pengajuan));
        } catch (\Exception $e) {
            // Log error if mail fails but don't break the approval process
            \Illuminate\Support\Facades\Log::error('Failed to send approval email: ' . $e->getMessage());
        }

        $pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($pengajuan));

        session()->flash('message', 'Surat berhasil disetujui.');
    }

    public function confirmReject($id)
    {
        $this->rejectId = $id;
        $this->catatan = '';
        $this->showRejectModal = true;
    }

    public function tolak()
    {
        $this->validate([
            'catatan' => 'required|min:5'
        ]);

        $pengajuan = PengajuanSurat::find($this->rejectId);
        if ($pengajuan) {
            $pengajuan->update([
                'status' => 'ditolak',
                'catatan' => $this->catatan,
            ]);

            $pengajuan->user->notify(new \App\Notifications\StatusPengajuanNotification($pengajuan));

            session()->flash('message', 'Surat telah ditolak.');
        }

        $this->showRejectModal = false;
        $this->rejectId = null;
    }

    public function cancelReject()
    {
        $this->showRejectModal = false;
        $this->rejectId = null;
    }



    public function render()
    {
        $query = PengajuanSurat::with(['user', 'jenisSurat'])
            ->where('status', 'diproses')
            ->latest();

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%');
            });
        }

        $pengajuan = $query->paginate(10);

        return view('livewire.kades.persetujuan-index', [
            'pengajuan' => $pengajuan,
        ]);
    }
}
