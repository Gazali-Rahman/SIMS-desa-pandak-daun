<?php

namespace App\Livewire\Kades;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Laporan Pengajuan - SIMS',
    'header' => 'Laporan Layanan Administrasi',
    'sidebar' => 'components.sidebar.main'
])]
class LaporanIndex extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $status = '';
    public $jenis_surat_id = '';

    public function mount()
    {
        // Default to current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }
    public function updatingEndDate()
    {
        $this->resetPage();
    }
    public function updatingStatus()
    {
        $this->resetPage();
    }
    public function updatingJenisSuratId()
    {
        $this->resetPage();
    }

    public function getQueryProperty()
    {
        return PengajuanSurat::with(['user', 'jenisSurat'])
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->jenis_surat_id, fn($q) => $q->where('jenis_surat_id', $this->jenis_surat_id));
    }

    public function render()
    {
        $query = $this->query;

        $stats = [
            'total' => (clone $query)->count(),
            'disetujui' => (clone $query)->where('status', 'selesai')->count(),
            'ditolak' => (clone $query)->where('status', 'ditolak')->count(),
        ];

        return view('livewire.kades.laporan-index', [
            'pengajuan' => $query->latest()->paginate(15),
            'stats' => $stats,
            'jenisSuratList' => JenisSurat::all(),
        ]);
    }
}
