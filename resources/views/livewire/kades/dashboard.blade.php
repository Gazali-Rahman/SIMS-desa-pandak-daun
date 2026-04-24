<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">Dashboard Pimpinan</h1>
            <p class="text-slate-400 text-sm">Rekapitulasi dan persetujuan surat keluar</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 border-l-4 border-l-indigo-500">
            <div class="flex items-center justify-between mb-2">
                <div class="text-slate-400 text-sm font-medium">Perlu Tanda Tangan</div>
            </div>
            <div class="text-4xl font-bold text-white mb-2">{{ $stats['perlu_ttd'] }}</div>
            <p class="text-xs text-indigo-400">Dokumen menunggu persetujuan hari ini</p>
        </div>
        
        <div class="glass-card p-6 border-l-4 border-l-green-500">
            <div class="flex items-center justify-between mb-2">
                <div class="text-slate-400 text-sm font-medium">Total Disetujui (Bulan Ini)</div>
            </div>
            <div class="text-4xl font-bold text-white mb-2">{{ $stats['total_disetujui'] }}</div>
            <p class="text-xs text-green-400">Telah ditandatangani</p>
        </div>
        
        <div class="glass-card p-6 border-l-4 border-l-blue-500">
            <div class="flex items-center justify-between mb-2">
                <div class="text-slate-400 text-sm font-medium">Jenis Surat Terbanyak</div>
            </div>
            <div class="text-2xl font-bold text-white mb-2 truncate" title="{{ $stats['surat_terbanyak'] }}">
                {{ $stats['surat_terbanyak'] }}
            </div>
            <p class="text-xs text-blue-400">Paling sering diajukan warga</p>
        </div>
    </div>

    <!-- Recent Approvals Table -->
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-slate-700/50 flex justify-between items-center">
            <h3 class="font-bold text-white">Antrean Tanda Tangan Elektronik</h3>
            <a href="{{ route('kades.persetujuan.index') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300">Lihat Antrean Lengkap</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/50 text-slate-400 text-sm border-b border-slate-700/50">
                        <th class="py-3 px-6 font-medium">TANGGAL</th>
                        <th class="py-3 px-6 font-medium">PEMOHON</th>
                        <th class="py-3 px-6 font-medium">JENIS SURAT</th>
                        <th class="py-3 px-6 font-medium text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($antrean as $item)
                        <tr class="border-b border-slate-700/50 hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-6 text-slate-300 whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-white">{{ $item->user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $item->user->nik }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-300">{{ $item->jenisSurat->nama }}</td>
                            <td class="py-4 px-6 text-right">
                                <button wire:click="setuju({{ $item->id }})" wire:confirm="Anda yakin menyetujui surat ini?" class="inline-block px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition-colors">
                                    ACC Surat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 px-6 text-center text-slate-500">
                                Tidak ada surat yang menunggu persetujuan/tanda tangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
