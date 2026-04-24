<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-slate-400">Di Portal Sistem Informasi Manajemen Surat Desa Pandak Daun</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-card p-6 border-l-4 border-l-indigo-500">
            <div class="text-slate-400 text-sm font-medium mb-1">Total Pengajuan</div>
            <div class="text-3xl font-bold text-white">{{ $stats['total'] }}</div>
        </div>
        <div class="glass-card p-6 border-l-4 border-l-amber-500">
            <div class="text-slate-400 text-sm font-medium mb-1">Menunggu Verifikasi</div>
            <div class="text-3xl font-bold text-white">{{ $stats['menunggu'] }}</div>
        </div>
        <div class="glass-card p-6 border-l-4 border-l-green-500">
            <div class="text-slate-400 text-sm font-medium mb-1">Selesai</div>
            <div class="text-3xl font-bold text-white">{{ $stats['selesai'] }}</div>
        </div>
        <div class="glass-card p-6 border-l-4 border-l-red-500">
            <div class="text-slate-400 text-sm font-medium mb-1">Ditolak</div>
            <div class="text-3xl font-bold text-white">{{ $stats['ditolak'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main CTA -->
        <div class="lg:col-span-2 glass-card p-8 flex flex-col items-center justify-center text-center bg-gradient-to-br from-slate-800 to-indigo-900/30 border-indigo-500/30">
            <div class="w-16 h-16 bg-indigo-500/20 text-indigo-400 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Butuh Surat Keterangan?</h3>
            <p class="text-slate-300 mb-6 max-w-md">Ajukan berbagai jenis surat keterangan dengan mudah secara online. Proses cepat dan transparan.</p>
            <a href="{{ route('warga.pengajuan.create') }}" class="btn-primary flex items-center justify-center gap-2 text-lg px-6 py-3 w-max mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajukan Surat Sekarang
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="glass-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-white">Pengajuan Terakhir</h3>
                <a href="{{ route('warga.pengajuan.index') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300">Lihat Semua</a>
            </div>
            
            @if($recentPengajuan->isEmpty())
                <div class="flex flex-col items-center justify-center h-48 text-center text-slate-500">
                    <svg class="w-12 h-12 mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p>Belum ada riwayat pengajuan surat.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentPengajuan as $pengajuan)
                        <div class="p-3 bg-slate-800/50 rounded-lg border border-slate-700/50">
                            <div class="flex justify-between items-start mb-2">
                                <div class="font-medium text-white text-sm">{{ $pengajuan->jenisSurat->nama }}</div>
                                <span class="text-xs px-2 py-1 rounded-full 
                                    {{ $pengajuan->status === 'menunggu' ? 'bg-amber-500/20 text-amber-400' : '' }}
                                    {{ $pengajuan->status === 'diproses' ? 'bg-blue-500/20 text-blue-400' : '' }}
                                    {{ $pengajuan->status === 'selesai' ? 'bg-green-500/20 text-green-400' : '' }}
                                    {{ $pengajuan->status === 'ditolak' ? 'bg-red-500/20 text-red-400' : '' }}">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </div>
                            <div class="text-xs text-slate-400">{{ $pengajuan->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
