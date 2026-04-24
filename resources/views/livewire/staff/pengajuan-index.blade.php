<div>
    @can('lihat-pengajuan')
        <div class="glass-card overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="relative max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.500ms="search"
                            class="input-field pl-10 py-2 w-full text-sm" placeholder="Cari NIK atau Nama Warga...">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <select wire:model.live="jenisSuratFilter" class="input-field py-2 text-sm min-w-[180px]">
                        <option value="">Semua Jenis Surat</option>
                        @foreach ($jenisSuratList as $js)
                            <option value="{{ $js->id }}">{{ $js->nama }}</option>
                        @endforeach
                    </select>

                    <select wire:model.live="statusFilter" class="input-field py-2 text-sm min-w-[150px]">
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
                            <th class="py-4 px-6 font-medium">PEMOHON</th>
                            <th class="py-4 px-6 font-medium">JENIS SURAT</th>
                            <th class="py-4 px-6 font-medium">STATUS</th>
                            <th class="py-4 px-6 font-medium text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($pengajuan as $item)
                            <tr class="border-b border-slate-700/50 hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-6 text-slate-300 whitespace-nowrap">
                                    {{ $item->created_at->format('d M Y') }}<br>
                                    <span class="text-xs text-slate-500">{{ $item->created_at->format('H:i') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-white">{{ $item->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $item->user->nik }}</div>
                                </td>
                                <td class="py-4 px-6 text-slate-300">
                                    <div class="font-medium text-white">{{ $item->jenisSurat->nama }}</div>
                                    <div class="text-xs text-slate-500 truncate max-w-[200px]">{{ $item->keperluan }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-medium border
                                    {{ $item->status === 'menunggu' ? 'bg-amber-500/20 text-amber-400 border-amber-500/30' : '' }}
                                    {{ $item->status === 'diproses' ? 'bg-blue-500/20 text-blue-400 border-blue-500/30' : '' }}
                                    {{ $item->status === 'selesai' ? 'bg-green-500/20 text-green-400 border-green-500/30' : '' }}
                                    {{ $item->status === 'ditolak' ? 'bg-red-500/20 text-red-400 border-red-500/30' : '' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    @if ($item->status === 'selesai')
                                        @can('cetak-pengajuan')
                                            <a href="{{ route('surat.cetak', $item->id) }}" target="_blank"
                                                class="inline-block px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition-colors mr-1"
                                                title="Cetak PDF">
                                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endcan
                                    @endif
                                    @can('verifikasi-pengajuan')
                                        <a href="{{ route('pengajuan.show', $item->id) }}"
                                            class="inline-block px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded text-xs font-medium transition-colors">
                                            {{ in_array($item->status, ['menunggu', 'diproses']) ? 'Verifikasi' : 'Detail' }}
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-slate-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium text-slate-400">Tidak ada data ditemukan</p>
                                    <p class="mt-1">Silakan sesuaikan kriteria pencarian atau filter Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pengajuan->hasPages())
                <div class="p-6 border-t border-slate-700/50">
                    {{ $pengajuan->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="glass-card p-6 text-center text-slate-500">
            Anda tidak memiliki akses untuk melihat daftar pengajuan.
        </div>
    @endcan
</div>
