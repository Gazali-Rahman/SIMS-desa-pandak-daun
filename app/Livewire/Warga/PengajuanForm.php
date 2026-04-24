<?php

namespace App\Livewire\Warga;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Ajukan Surat - SIMS',
    'header' => 'Pengajuan Surat Baru',
    'sidebar' => 'components.sidebar.main'
])]
class PengajuanForm extends Component
{
    use WithFileUploads;

    public int $step = 1;

    // Step 1: Pilih Surat
    public $jenis_surat_id = null;

    // Step 2: Form Dinamis
    public string $keperluan = '';
    public $data_tambahan = [];

    // Step 3: Upload Dokumen
    public $dokumen = [];

    public function getJenisSuratProperty()
    {
        return JenisSurat::where('is_active', true)->get();
    }

    public function getSelectedSuratProperty()
    {
        if (!$this->jenis_surat_id) return null;
        return JenisSurat::find($this->jenis_surat_id);
    }

    public function selectSurat($id)
    {
        $this->jenis_surat_id = $id;
        $this->data_tambahan = [];
        $this->dokumen = [];
        $this->nextStep();
    }

    public function nextStep()
    {
        if ($this->step === 2) {
            $rules = [
                'keperluan' => 'required|min:5',
            ];

            $surat = $this->selectedSurat;
            if ($surat && is_array($surat->form_fields)) {
                foreach ($surat->form_fields as $field) {
                    $rules['data_tambahan.' . $field['name']] = 'required';
                }
            }

            $this->validate($rules, [
                'data_tambahan.*.required' => 'Kolom ini wajib diisi.'
            ]);
        } elseif ($this->step === 3) {
            $rules = [];
            $surat = $this->selectedSurat;

            if ($surat && is_array($surat->syarat)) {
                foreach ($surat->syarat as $key => $is_required) {
                    if ($is_required) {
                        $rules['dokumen.' . $key] = 'required|image|max:2048';
                    }
                }
            }

            $this->validate($rules, [
                'dokumen.*.required' => 'Dokumen ini wajib diunggah.',
                'dokumen.*.image' => 'File harus berupa gambar.',
                'dokumen.*.max' => 'Ukuran maksimal 2MB.'
            ]);
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        $paths = [];
        $surat = $this->selectedSurat;

        // Upload dynamic files
        if ($surat && is_array($surat->syarat)) {
            foreach ($surat->syarat as $key => $is_required) {
                if ($is_required && isset($this->dokumen[$key])) {
                    $paths[$key] = $this->dokumen[$key]->store("pengajuan/$key", 'public');
                }
            }
        }

        // Simpan ke database
        $pengajuan = PengajuanSurat::create([
            'user_id' => Auth::id(),
            'jenis_surat_id' => $this->jenis_surat_id,
            'keperluan' => $this->keperluan,
            'data_tambahan' => $this->data_tambahan,
            'dokumen_syarat' => $paths,
            'status' => 'menunggu',
        ]);

        // Notify Staff and Kades
        $admins = \App\Models\User::role(['staff', 'kepala_desa'])->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\PengajuanBaruNotification($pengajuan));

        session()->flash('message', 'Pengajuan surat berhasil dikirim.');
        return redirect()->route('warga.dashboard');
    }

    public function render()
    {
        return view('livewire.warga.pengajuan-form', [
            'jenisSuratList' => $this->jenisSurat,
            'selectedSuratData' => $this->selectedSurat
        ]);
    }
}
