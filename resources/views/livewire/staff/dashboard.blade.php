<div>
    @can('lihat-dashboard')
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white mb-1">Dashboard Pelayanan</h1>
                <p class="text-slate-400 text-sm">Ringkasan pengajuan surat dan aktivitas warga</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="glass-card p-6 border-t-4 border-t-indigo-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-400 text-sm font-medium">Masuk Hari Ini</div>
                    <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-white">{{ $stats['hari_ini'] }}</div>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-amber-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-400 text-sm font-medium">Perlu Verifikasi</div>
                    <div class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-white">{{ $stats['perlu_verifikasi'] }}</div>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-400 text-sm font-medium">Sedang Diproses</div>
                    <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-white">{{ $stats['sedang_diproses'] }}</div>
            </div>
            <div class="glass-card p-6 border-t-4 border-t-green-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-400 text-sm font-medium">Selesai Bulan Ini</div>
                    <div class="w-8 h-8 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-white">{{ $stats['selesai_bulan_ini'] }}</div>
            </div>
        </div>

        <!-- Recent Table -->
        <div class="glass-card overflow-hidden">
            <div class="p-6 border-b border-slate-700/50 flex justify-between items-center">
                <h3 class="font-bold text-white">Pengajuan Terbaru (Perlu Aksi)</h3>
                <a href="#" class="text-sm font-medium text-indigo-400 hover:text-indigo-300">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-800/50 text-slate-400 text-sm border-b border-slate-700/50">
                            <th class="py-3 px-6 font-medium">TANGGAL</th>
                            <th class="py-3 px-6 font-medium">PEMOHON</th>
                            <th class="py-3 px-6 font-medium">JENIS SURAT</th>
                            <th class="py-3 px-6 font-medium">STATUS</th>
                            <th class="py-3 px-6 font-medium text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($pengajuanTerbaru as $pengajuan)
                            <tr class="border-b border-slate-700/50 hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-6 text-slate-300">{{ $pengajuan->created_at->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-white">{{ $pengajuan->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $pengajuan->user->nik }}</div>
                                </td>
                                <td class="py-4 px-6 text-slate-300">{{ $pengajuan->jenisSurat->nama }}</td>
                                <td class="py-4 px-6">
                                    <span
                                        class="text-xs px-2 py-1 rounded-full 
                                    {{ $pengajuan->status === 'menunggu' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                    {{ $pengajuan->status === 'diproses' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}">
                                        {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @can('verifikasi_pengajuan')
                                        <a href="{{ route('pengajuan.show', $pengajuan->id) }}"
                                            class="inline-block px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white rounded text-xs font-medium transition-colors">
                                            Verifikasi
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-slate-500">
                                    Tidak ada pengajuan yang perlu diverifikasi saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="glass-card p-6 text-center text-slate-500">
            Anda tidak memiliki akses untuk melihat dashboard.
        </div>
    @endcan
</div>
