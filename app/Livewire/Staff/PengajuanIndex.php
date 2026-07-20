<?php

namespace App\Livewire\Staff;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Pengajuan Masuk - APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB',
    'header' => 'Semua Pengajuan Masuk',
    'sidebar' => 'components.sidebar.main'
])]
class PengajuanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $jenisSuratFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingJenisSuratFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = PengajuanSurat::with(['user', 'jenisSurat'])->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->jenisSuratFilter) {
            $query->where('jenis_surat_id', $this->jenisSuratFilter);
        }

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%');
            });
        }

        $pengajuan = $query->paginate(15);
        $jenisSurat = JenisSurat::all();

        return view('livewire.staff.pengajuan-index', [
            'pengajuan' => $pengajuan,
            'jenisSuratList' => $jenisSurat,
        ]);
    }
}
