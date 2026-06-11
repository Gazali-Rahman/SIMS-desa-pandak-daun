<?php

namespace App\Livewire\Staff;

use App\Models\JenisSurat;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app', [
    'title' => 'Master Jenis Surat - SIMS',
    'header' => 'Master Jenis Surat',
    'sidebar' => 'components.sidebar.main'
])]
class MasterSurat extends Component
{
    public $jenisSuratList;

    public $isModalOpen = false;
    public $isEditMode = false;

    public $surat_id;
    public $nama;
    public $kode;
    public $deskripsi;
    public $icon;
    
    // Dynamic form fields and requirements
    public $syarat_dokumen = [];
    public $form_fields = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->jenisSuratList = JenisSurat::all();
    }

    public function addField()
    {
        $this->form_fields[] = ['name' => '', 'label' => '', 'type' => 'text'];
    }

    public function removeField($index)
    {
        unset($this->form_fields[$index]);
        $this->form_fields = array_values($this->form_fields);
    }

    public function addSyarat()
    {
        $this->syarat_dokumen[] = ['name' => '', 'label' => ''];
    }

    public function removeSyarat($index)
    {
        unset($this->syarat_dokumen[$index]);
        $this->syarat_dokumen = array_values($this->syarat_dokumen);
    }

    /**
     * Normalize old syarat format (associative boolean array) to new format (array of objects)
     */
    private function normalizeSyarat($syaratData)
    {
        if (empty($syaratData)) return [];
        
        $normalized = [];
        // Check if it's the old format (associative array with boolean values)
        // A simple heuristic is checking if the first element is a boolean or if keys are strings like 'ktp'
        $isOldFormat = false;
        foreach ($syaratData as $key => $value) {
            if (is_bool($value)) {
                $isOldFormat = true;
                break;
            }
        }

        if ($isOldFormat) {
            foreach ($syaratData as $key => $is_required) {
                if ($is_required) {
                    $normalized[] = [
                        'name' => $key,
                        'label' => ucwords(str_replace('_', ' ', $key))
                    ];
                }
            }
            return $normalized;
        }

        // It's the new format, just return it
        return is_array($syaratData) ? $syaratData : [];
    }

    public function openModal($id = null)
    {
        $this->resetFields();
        if ($id) {
            $this->isEditMode = true;
            $surat = JenisSurat::find($id);
            $this->surat_id = $surat->id;
            $this->nama = $surat->nama;
            $this->kode = $surat->kode;
            $this->deskripsi = $surat->deskripsi;
            $this->icon = $surat->icon;

            $syaratRaw = is_array($surat->syarat) ? $surat->syarat : json_decode($surat->syarat, true) ?? [];
            $this->syarat_dokumen = $this->normalizeSyarat($syaratRaw);

            $this->form_fields = is_array($surat->form_fields) ? $surat->form_fields : json_decode($surat->form_fields, true) ?? [];
        } else {
            $this->isEditMode = false;
            $this->icon = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
        }
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->surat_id = null;
        $this->nama = '';
        $this->kode = '';
        $this->deskripsi = '';
        $this->icon = '';
        $this->syarat_dokumen = [];
        $this->form_fields = [];
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10',
            'deskripsi' => 'nullable|string',
            'icon' => 'required|string',
            'form_fields.*.name' => 'required|string',
            'form_fields.*.label' => 'required|string',
            'form_fields.*.type' => 'required|string',
            'syarat_dokumen.*.label' => 'required|string',
        ]);

        // Format names to lowercase snake_case automatically
        foreach ($this->form_fields as &$field) {
            $field['name'] = strtolower(str_replace(' ', '_', $field['name']));
        }
        
        foreach ($this->syarat_dokumen as &$doc) {
            if (empty($doc['name'])) {
                // Auto generate name from label if empty
                $doc['name'] = strtolower(str_replace(' ', '_', $doc['label']));
            } else {
                $doc['name'] = strtolower(str_replace(' ', '_', $doc['name']));
            }
        }

        if ($this->isEditMode) {
            $surat = JenisSurat::find($this->surat_id);
            $surat->update([
                'nama' => $this->nama,
                'kode' => strtoupper($this->kode),
                'deskripsi' => $this->deskripsi,
                'icon' => $this->icon,
                'syarat' => $this->syarat_dokumen,
                'form_fields' => $this->form_fields,
            ]);
            session()->flash('message', 'Jenis surat berhasil diperbarui.');
        } else {
            JenisSurat::create([
                'nama' => $this->nama,
                'kode' => strtoupper($this->kode),
                'deskripsi' => $this->deskripsi,
                'icon' => $this->icon,
                'syarat' => $this->syarat_dokumen,
                'form_fields' => $this->form_fields,
                'is_active' => true,
            ]);
            session()->flash('message', 'Jenis surat berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->loadData();
    }

    public function toggleStatus($id)
    {
        $surat = JenisSurat::find($id);
        $surat->update([
            'is_active' => !$surat->is_active
        ]);
        $this->loadData();
        session()->flash('message', 'Status surat berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.staff.master-surat');
    }
}
