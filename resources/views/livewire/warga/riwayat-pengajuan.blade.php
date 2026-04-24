<div>
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="font-bold text-white text-lg">Daftar Pengajuan Anda</h3>
            
            <div class="flex gap-2">
                <select wire:model.live="statusFilter" class="input-field max-w-[150px] py-2 text-sm">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/50 text-slate-400 text-sm border-b border-slate-700/50">
                        <th class="py-4 px-6 font-medium">TANGGAL</th>
                        <th class="py-4 px-6 font-medium">JENIS SURAT</th>
                        <th class="py-4 px-6 font-medium">NO SURAT</th>
                        <th class="py-4 px-6 font-medium">STATUS</th>
                        <th class="py-4 px-6 font-medium">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($pengajuan as $item)
                        <tr class="border-b border-slate-700/50 hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 px-6 text-slate-300 whitespace-nowrap">
                                {{ $item->created_at->format('d M Y') }}<br>
                                <span class="text-xs text-slate-500">{{ $item->created_at->format('H:i') }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-300">
                                <div class="font-medium text-white">{{ $item->jenisSurat->nama }}</div>
                                <div class="text-xs text-slate-500 truncate max-w-xs">{{ $item->keperluan }}</div>
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                {{ $item->nomor_surat ?? '-' }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border
                                    {{ $item->status === 'menunggu' ? 'bg-amber-500/20 text-amber-400 border-amber-500/30' : '' }}
                                    {{ $item->status === 'diproses' ? 'bg-blue-500/20 text-blue-400 border-blue-500/30' : '' }}
                                    {{ $item->status === 'selesai' ? 'bg-green-500/20 text-green-400 border-green-500/30' : '' }}
                                    {{ $item->status === 'ditolak' ? 'bg-red-500/20 text-red-400 border-red-500/30' : '' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($item->status === 'ditolak')
                                    <div class="text-xs text-red-400 bg-red-500/10 p-2 rounded border border-red-500/20">
                                        <span class="font-bold block mb-1">Catatan Penolakan:</span>
                                        {{ $item->catatan }}
                                    </div>
                                @elseif($item->status === 'selesai')
                                    <a href="{{ route('surat.cetak', $item->id) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-medium text-white bg-green-500 hover:bg-green-600 px-3 py-1.5 rounded transition-colors shadow shadow-green-500/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Unduh PDF
                                    </a>
                                @else
                                    <span class="text-xs text-slate-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 px-6 text-center text-slate-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-lg font-medium text-slate-400">Tidak ada riwayat pengajuan</p>
                                <p class="mt-1">Anda belum pernah mengajukan surat atau filter tidak cocok.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pengajuan->hasPages())
            <div class="p-6 border-t border-slate-700/50">
                {{ $pengajuan->links() }}
            </div>
        @endif
    </div>
</div>
