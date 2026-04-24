<!-- Warga Navigation -->
@role('warga')
    <div class="mb-2 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
        Menu Warga
    </div>
    <a href="{{ route('warga.dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('warga.dashboard') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('warga.dashboard') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('warga.pengajuan.create') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('warga.pengajuan.create') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('warga.pengajuan.create') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Ajukan Surat
    </a>
    <a href="{{ route('warga.pengajuan.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('warga.pengajuan.index') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('warga.pengajuan.index') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
        Riwayat Pengajuan
    </a>
    <a href="{{ route('warga.profile') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('warga.profile') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('warga.profile') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Profil Saya
    </a>
@endrole


<!-- Kepala Desa Navigation -->
@role('kepala_desa')
    <div class="mb-2 mt-4 px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
        Menu Kades
    </div>
    <a href="{{ route('kades.dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('kades.dashboard') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('kades.dashboard') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('kades.persetujuan.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('kades.persetujuan.index') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('kades.persetujuan.index') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            </path>
        </svg>
        Persetujuan Surat
    </a>
    <a href="{{ route('kades.users.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('kades.users.index') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('kades.users.index') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
            </path>
        </svg>
        Data Pengguna
    </a>
    <a href="{{ route('kades.roles.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('kades.roles.index') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('kades.roles.index') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
            </path>
        </svg>
        Manajemen Role
    </a>
@endrole

<!-- Shared Permission Based Navigation -->

@can('lihat-dashboard')
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('dashboard') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
        </svg>
        Dashboard
    </a>
@endcan

@can('lihat-pengajuan')
    <a href="{{ route('pengajuan.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('pengajuan.index') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('pengajuan.index') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
            </path>
        </svg>
        Pengajuan Masuk
    </a>
@endcan

@can('lihat-warga')
    <a href="{{ route('data-warga') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('data-warga') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('data-warga') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
        </svg>
        Data Warga
    </a>
@endcan

@can('lihat-master-surat')
    <a href="{{ route('master-surat') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('master-surat') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('master-surat') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
            </path>
        </svg>
        Master Jenis Surat
    </a>
@endcan

@can('lihat-laporan')
    <a href="{{ route('laporan.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors {{ request()->routeIs('laporan.index') ? 'text-white bg-indigo-500/20 font-medium' : '' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('laporan.index') ? 'text-indigo-400' : '' }}" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            </path>
        </svg>
        Laporan Pengajuan
    </a>
@endcan
