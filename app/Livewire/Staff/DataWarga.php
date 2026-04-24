<?php

namespace App\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Data Warga - SIMS',
    'header' => 'Data Penduduk / Warga',
    'sidebar' => 'components.sidebar.main'
])]
class DataWarga extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $warga = User::role('warga')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.staff.data-warga', [
            'warga' => $warga,
        ]);
    }
}
