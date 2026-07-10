<?php

namespace App\Livewire\Warga;

use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Riwayat Pengajuan - SIMS',
    'header' => 'Riwayat Pengajuan',
    'sidebar' => 'components.sidebar.main'
])]
class RiwayatPengajuan extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = PengajuanSurat::with('jenisSurat')
            ->where('user_id', Auth::id())
            ->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('jenisSurat', function ($sub) {
                    $sub->where('nama', 'like', '%' . $this->search . '%');
                })->orWhere('nomor_surat', 'like', '%' . $this->search . '%');
            });
        }

        $pengajuan = $query->paginate(10);

        return view('livewire.warga.riwayat-pengajuan', [
            'pengajuan' => $pengajuan,
        ]);
    }
}
