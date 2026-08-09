<div>
    @can('lihat-laporan')
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="glass-card p-6 border-t-4 border-t-indigo-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 font-medium">Total Pengajuan</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 border-t-4 border-t-green-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-500/20 text-green-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 font-medium">Selesai (ACC)</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['disetujui'] }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 border-t-4 border-t-amber-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 font-medium">Menunggu</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['menunggu'] }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6 border-t-4 border-t-red-500">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400 font-medium">Ditolak</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['ditolak'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Table -->
        <div class="glass-card p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-400">Dari:</label>
                        <input type="date" wire:model.live="startDate" class="input-field py-1.5 px-3 text-sm w-36">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-400">Sampai:</label>
                        <input type="date" wire:model.live="endDate" class="input-field py-1.5 px-3 text-sm w-36">
                    </div>
                    <select wire:model.live="status" class="input-field py-1.5 px-3 text-sm w-32">
                        <option value="">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="diproses">Diproses</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="menunggu">Menunggu</option>
                    </select>
                    <select wire:model.live="jenis_surat_id" class="input-field py-1.5 px-3 text-sm w-40">
                        <option value="">Semua Surat</option>
                        @foreach ($jenisSuratList as $js)
                            <option value="{{ $js->id }}">{{ $js->kode }}</option>
                        @endforeach
                    </select>
                </div>
                @can('cetak-laporan')
                    <a href="{{ route('laporan.cetak', ['start' => $startDate, 'end' => $endDate, 'status' => $status, 'jenis' => $jenis_surat_id]) }}"
                        target="_blank" class="btn-primary flex items-center gap-2 py-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak PDF
                    </a>
                @endcan
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-800/50 text-slate-400 text-xs uppercase tracking-wider border-b border-slate-700/50">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Warga / NIK</th>
                            <th class="py-3 px-4">Jenis Surat</th>
                            <th class="py-3 px-4">Nomor Surat</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-700/50">
                        @forelse($pengajuan as $item)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-3 px-4 text-slate-300">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-white">{{ $item->user->name }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $item->user->nik }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="text-slate-300">{{ $item->jenisSurat->nama }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-mono text-slate-400">{{ $item->nomor_surat ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if ($item->status == 'selesai')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/20">Selesai</span>
                                    @elseif($item->status == 'diproses')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/20">Diproses</span>
                                    @elseif($item->status == 'ditolak')
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/20">Ditolak</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/20">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Tidak ada data yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $pengajuan->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    @else
        <p>Anda tidak memiliki izin mengedit.</p>
    @endcan
</div>
