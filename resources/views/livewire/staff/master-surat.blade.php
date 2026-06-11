<div>
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="font-bold text-white text-lg">Daftar Layanan Surat</h3>
                <p class="text-sm text-slate-400">Kelola jenis surat yang tersedia untuk diajukan oleh warga.</p>
            </div>
            @can('tambah-jenis-surat')
                <button wire:click="openModal" class="btn-primary flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Jenis Surat
                </button>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/50 text-slate-400 text-sm border-b border-slate-700/50">
                        <th class="py-4 px-6 font-medium">NAMA SURAT</th>
                        <th class="py-4 px-6 font-medium">KODE</th>
                        <th class="py-4 px-6 font-medium">PERSYARATAN</th>
                        <th class="py-4 px-6 font-medium">STATUS</th>
                        <th class="py-4 px-6 font-medium text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($jenisSuratList as $item)
                        <tr class="border-b border-slate-700/50 hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $item->icon }}"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-white">{{ $item->nama }}</div>
                                        <div class="text-xs text-slate-400 truncate max-w-xs">{{ $item->deskripsi }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-300 font-mono">{{ $item->kode }}</td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1">
                                    @php
                                        $syaratList = is_array($item->syarat) ? $item->syarat : (json_decode($item->syarat, true) ?? []);
                                    @endphp
                                    @foreach($syaratList as $key => $value)
                                        @if(is_array($value) && isset($value['label']))
                                            <span class="text-[10px] px-2 py-0.5 bg-slate-700 rounded border border-slate-600 text-slate-300">{{ $value['label'] }}</span>
                                        @elseif($value === true)
                                            <span class="text-[10px] px-2 py-0.5 bg-slate-700 rounded border border-slate-600 text-slate-300 uppercase">{{ str_replace('_', ' ', $key) }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <button wire:click="toggleStatus({{ $item->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border transition-colors hover:opacity-80
                                    {{ $item->is_active ? 'bg-green-500/20 text-green-400 border-green-500/30' : 'bg-slate-700 text-slate-400 border-slate-600' }}">
                                    <div
                                        class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-green-400' : 'bg-slate-400' }}">
                                    </div>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="py-4 px-6 text-right">
                                @can('edit-jenis-surat')
                                    <button wire:click="openModal({{ $item->id }})"
                                        class="text-indigo-400 hover:text-indigo-300 transition-colors p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
            <form wire:submit="save" class="glass-card w-full max-w-2xl max-h-[90vh] flex flex-col animate-[fadeIn_0.2s_ease-out]">
                <div class="p-6 border-b border-slate-700 shrink-0">
                    <h3 class="text-xl font-bold text-white">
                        {{ $isEditMode ? 'Edit Jenis Surat' : 'Tambah Jenis Surat Baru' }}
                    </h3>
                </div>

                <div class="p-6 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Nama Surat</label>
                            <input type="text" wire:model="nama" class="input-field"
                                placeholder="Contoh: Surat Keterangan Domisili">
                            @error('nama')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Kode Surat</label>
                            <input type="text" wire:model="kode" class="input-field uppercase"
                                placeholder="Contoh: SKD">
                            <div class="text-xs text-slate-500 mt-1">Digunakan untuk format penomoran otomatis.</div>
                            @error('kode')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Icon (SVG Path)</label>
                            <input type="text" wire:model="icon" class="input-field font-mono text-xs"
                                placeholder="M9 12h...">
                            <div class="text-xs text-slate-500 mt-1">Copy dari Heroicons.com (d attribut).</div>
                            @error('icon')
                                <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Singkat</label>
                            <textarea wire:model="deskripsi" rows="2" class="input-field"
                                placeholder="Penjelasan mengenai fungsi surat ini..."></textarea>
                        </div>

                        <div class="md:col-span-2 mt-2 border-t border-slate-700 pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-medium text-slate-300">Persyaratan Dokumen</label>
                                <button type="button" wire:click="addSyarat"
                                    class="px-3 py-1 bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500/30 rounded text-xs font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Syarat
                                </button>
                            </div>

                            @if (empty($syarat_dokumen))
                                <div
                                    class="text-xs text-slate-500 text-center py-4 bg-slate-800/30 rounded border border-slate-700/50">
                                    Tidak ada dokumen yang diwajibkan.
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($syarat_dokumen as $index => $doc)
                                        <div class="flex gap-3 items-center bg-slate-800/50 p-3 rounded-lg border border-slate-700">
                                            <div class="flex-1">
                                                <input type="text"
                                                    wire:model="syarat_dokumen.{{ $index }}.label"
                                                    class="input-field text-sm"
                                                    placeholder="Nama Dokumen (Cth: Surat Kuasa, Fotocopy KTP)">
                                                @error("syarat_dokumen.$index.label")
                                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="button" wire:click="removeSyarat({{ $index }})"
                                                class="p-2 text-red-400 hover:text-red-300 hover:bg-red-400/10 rounded transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="md:col-span-2 mt-4 border-t border-slate-700 pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-sm font-medium text-slate-300">Form Isian Tambahan
                                    (Opsional)</label>
                                <button type="button" wire:click="addField"
                                    class="px-3 py-1 bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500/30 rounded text-xs font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Inputan
                                </button>
                            </div>

                            @if (empty($form_fields))
                                <div
                                    class="text-xs text-slate-500 text-center py-4 bg-slate-800/30 rounded border border-slate-700/50">
                                    Tidak ada inputan tambahan. Warga hanya akan mengisi "Keperluan".
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($form_fields as $index => $field)
                                        <div
                                            class="flex gap-3 items-start bg-slate-800/50 p-3 rounded-lg border border-slate-700">
                                            <div class="flex-1 space-y-3">
                                                <div>
                                                    <input type="text"
                                                        wire:model="form_fields.{{ $index }}.label"
                                                        class="input-field text-sm"
                                                        placeholder="Label Input (Cth: Jumlah Penghasilan)">
                                                    @error("form_fields.$index.label")
                                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="flex gap-3">
                                                    <div class="w-1/2">
                                                        <input type="text"
                                                            wire:model="form_fields.{{ $index }}.name"
                                                            class="input-field text-xs font-mono"
                                                            placeholder="nama_field (tanpa spasi)">
                                                        @error("form_fields.$index.name")
                                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="w-1/2">
                                                        <select wire:model="form_fields.{{ $index }}.type"
                                                            class="input-field text-sm">
                                                            <option value="text">Teks Pendek</option>
                                                            <option value="number">Angka</option>
                                                            <option value="date">Tanggal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" wire:click="removeField({{ $index }})"
                                                class="p-2 text-red-400 hover:text-red-300 hover:bg-red-400/10 rounded transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-700 shrink-0 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal"
                        class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm font-medium transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="btn-primary px-5 py-2.5">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
