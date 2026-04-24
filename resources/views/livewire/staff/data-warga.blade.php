<div>
    @can('lihat-warga')
        <div class="glass-card p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Daftar Warga Terdaftar</h3>
                    <p class="text-sm text-slate-400">Seluruh data penduduk desa yang memiliki akun pada sistem ini.</p>
                </div>

                <div class="w-full md:w-64 relative">
                    <input type="text" wire:model.live.debounce.500ms="search" class="input-field pl-10 w-full"
                        placeholder="Cari NIK, Nama, atau Email...">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-800/50 text-slate-400 text-sm border-b border-slate-700/50">
                            <th class="py-4 px-6 font-medium">IDENTITAS WARGA</th>
                            <th class="py-4 px-6 font-medium">KONTAK / EMAIL</th>
                            <th class="py-4 px-6 font-medium">ALAMAT</th>
                            <th class="py-4 px-6 font-medium text-center">TOTAL PENGAJUAN</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-700/50">
                        @forelse($warga as $person)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-700 text-slate-300 flex items-center justify-center font-bold">
                                            {{ substr($person->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $person->name }}</div>
                                            <div class="text-xs text-slate-400 font-mono mt-0.5">NIK:
                                                {{ $person->nik ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-300">{{ $person->email }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">{{ $person->phone ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-300 truncate max-w-xs" title="{{ $person->address }}">
                                        {{ $person->address ?? '-' }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5">RT {{ $person->rt ?? '-' }} / RW
                                        {{ $person->rw ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 font-bold text-xs">
                                        {{ $person->pengajuanSurats()->count() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <p>Tidak ada data warga ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 border-t border-slate-700/50 pt-4">
                {{ $warga->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    @else
        <div class="glass-card p-6 text-center text-slate-500">
            Anda tidak memiliki akses untuk melihat data warga.
        </div>
    @endcan
</div>
