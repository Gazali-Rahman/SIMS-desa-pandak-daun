<div>
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-slate-700/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-white text-lg">Antrean Persetujuan Surat</h3>
                <p class="text-sm text-slate-400">Surat berikut telah diverifikasi oleh Staff dan menunggu ACC dari Anda.</p>
            </div>
            
            <div class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" class="input-field pl-10 py-2 w-full text-sm" placeholder="Cari NIK atau Nama...">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/50 text-slate-400 text-sm border-b border-slate-700/50">
                        <th class="py-4 px-6 font-medium">TANGGAL MASUK</th>
                        <th class="py-4 px-6 font-medium">PEMOHON</th>
                        <th class="py-4 px-6 font-medium">JENIS SURAT & KEPERLUAN</th>
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
                            <td class="py-4 px-6">
                                <div class="font-medium text-indigo-400">{{ $item->jenisSurat->nama }}</div>
                                <div class="text-xs text-slate-300 mt-1 max-w-sm truncate">{{ $item->keperluan }}</div>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <button wire:click="confirmReject({{ $item->id }})" class="inline-block px-3 py-1 bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/30 rounded text-xs font-medium transition-colors mr-2">
                                    Tolak
                                </button>
                                <button wire:click="setuju({{ $item->id }})" wire:confirm="Anda yakin menyetujui surat ini?" class="inline-block px-4 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs font-medium transition-colors">
                                    ACC Surat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 px-6 text-center text-slate-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-lg font-medium text-slate-400">Antrean Bersih</p>
                                <p class="mt-1">Tidak ada surat yang menunggu persetujuan Anda saat ini.</p>
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

    <!-- Reject Modal -->
    @if($showRejectModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="glass-card w-full max-w-md p-6 animate-[fadeIn_0.2s_ease-out]">
            <h3 class="text-lg font-bold text-white mb-2">Tolak Pengajuan Surat</h3>
            <p class="text-sm text-slate-400 mb-4">Silakan masukkan alasan penolakan agar warga atau staff dapat memperbaikinya.</p>
            
            <div class="mb-4">
                <textarea wire:model="catatan" rows="3" class="input-field border-red-500/50 focus:border-red-500 focus:ring-red-500" placeholder="Alasan penolakan..."></textarea>
                @error('catatan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex justify-end gap-3">
                <button wire:click="cancelReject" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-sm font-medium transition-colors">
                    Batal
                </button>
                <button wire:click="tolak" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">
                    Tolak Surat
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
