<div>
    @can('verifikasi-pengajuan')
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-2 text-indigo-400 hover:text-indigo-300 transition-colors w-max">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Dashboard
            </a>

            @if ($pengajuan->status === 'selesai')
                <a href="{{ route('surat.cetak', $pengajuan->id) }}" target="_blank"
                    class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Unduh Berkas PDF
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Info Pemohon -->
            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Informasi Pemohon</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Nama Lengkap</div>
                            <div class="font-medium text-white">{{ $pengajuan->user->name }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">NIK</div>
                            <div class="font-medium text-white">{{ $pengajuan->user->nik }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">No. HP / WhatsApp</div>
                            <div class="font-medium text-white">{{ $pengajuan->user->phone }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Alamat</div>
                            <div class="font-medium text-white">{{ $pengajuan->user->address }}</div>
                            <div class="text-sm text-slate-400">RT {{ $pengajuan->user->rt }} / RW
                                {{ $pengajuan->user->rw }}</div>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Detail Pengajuan</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Tanggal Masuk</div>
                            <div class="font-medium text-white">{{ $pengajuan->created_at->format('d F Y, H:i') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Jenis Surat</div>
                            <div class="font-medium text-white">{{ $pengajuan->jenisSurat->nama }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 mb-1">Keperluan</div>
                            <div class="p-3 bg-slate-800/50 rounded border border-slate-700 text-sm text-slate-300">
                                {{ $pengajuan->keperluan }}
                            </div>
                        </div>

                        @if (is_array($pengajuan->data_tambahan) && count($pengajuan->data_tambahan) > 0)
                            <div class="pt-2">
                                <div class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wider">Data Tambahan
                                </div>
                                <div class="space-y-3 bg-slate-800/30 p-3 rounded border border-slate-700/50">
                                    @foreach ($pengajuan->data_tambahan as $key => $value)
                                        @php
                                            // Cari label aslinya jika ada di form_fields
                                            $label = $key;
                                            $form_fields = is_array($pengajuan->jenisSurat->form_fields)
                                                ? $pengajuan->jenisSurat->form_fields
                                                : [];
                                            foreach ($form_fields as $field) {
                                                if ($field['name'] === $key) {
                                                    $label = $field['label'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <div>
                                            <div class="text-[10px] text-slate-500 uppercase tracking-wide">
                                                {{ $label }}</div>
                                            <div class="text-sm font-medium text-white">{{ $value ?: '-' }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Dokumen & Aksi -->
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card p-6">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Dokumen Persyaratan</h3>

                    @if (is_array($pengajuan->dokumen_syarat) && count($pengajuan->dokumen_syarat) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($pengajuan->dokumen_syarat as $jenis => $path)
                                <div class="border border-slate-700 rounded-lg overflow-hidden bg-slate-800/50">
                                    <div
                                        class="px-4 py-2 border-b border-slate-700 flex justify-between items-center bg-slate-800">
                                        <span
                                            class="text-sm font-medium text-white capitalize">{{ str_replace('_', ' ', $jenis) }}</span>
                                        <a href="{{ Storage::url($path) }}" target="_blank"
                                            class="text-xs text-indigo-400 hover:text-indigo-300">Lihat Penuh</a>
                                    </div>
                                    <div class="h-48 relative group">
                                        <img src="{{ Storage::url($path) }}" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <a href="{{ Storage::url($path) }}" target="_blank"
                                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg text-sm font-medium transition-colors flex gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Perbesar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-lg text-amber-400 text-sm">
                            Pemohon tidak menyertakan dokumen lampiran.
                        </div>
                    @endif
                </div>

                <!-- Form Status -->
                <div class="glass-card p-6">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Status & Tindakan</h3>

                    <form wire:submit="updateStatus">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Ubah Status Pengajuan</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="status" value="menunggu" class="peer sr-only">
                                    <div
                                        class="px-3 py-2 border border-slate-700 rounded-lg text-center text-sm font-medium text-slate-400 peer-checked:bg-amber-500/20 peer-checked:text-amber-400 peer-checked:border-amber-500/50 hover:bg-slate-800 transition-colors">
                                        Menunggu
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="status" value="diproses" class="peer sr-only">
                                    <div
                                        class="px-3 py-2 border border-slate-700 rounded-lg text-center text-sm font-medium text-slate-400 peer-checked:bg-blue-500/20 peer-checked:text-blue-400 peer-checked:border-blue-500/50 hover:bg-slate-800 transition-colors">
                                        Diproses
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="status" value="ditolak" class="peer sr-only">
                                    <div
                                        class="px-3 py-2 border border-slate-700 rounded-lg text-center text-sm font-medium text-slate-400 peer-checked:bg-red-500/20 peer-checked:text-red-400 peer-checked:border-red-500/50 hover:bg-slate-800 transition-colors">
                                        Ditolak
                                    </div>
                                </label>
                            </div>
                        </div>

                        @if ($status === 'ditolak')
                            <div class="mb-4" wire:transition>
                                <label class="block text-sm font-medium text-red-400 mb-2">Alasan Penolakan (Wajib)</label>
                                <textarea wire:model="catatan" rows="3"
                                    class="input-field border-red-500/50 focus:border-red-500 focus:ring-red-500"
                                    placeholder="Jelaskan mengapa pengajuan ini ditolak..."></textarea>
                                @error('catatan')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="btn-primary flex items-center gap-2">
                                <span wire:loading.remove wire:target="updateStatus">Simpan Perubahan</span>
                                <span wire:loading wire:target="updateStatus">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <p class="text-red-500">Anda tidak memiliki akses untuk melihat halaman ini</p>
    @endcan
</div>
