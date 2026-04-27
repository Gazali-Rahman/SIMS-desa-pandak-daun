<div>
    <!-- Header & Search -->
    <div class="glass-card p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex-1 w-full relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="input-field pl-10 py-2 w-full max-w-md"
                    placeholder="Cari berdasarkan nama, NIK, atau email...">
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-slate-400">Filter Role:</label>
                <select wire:model.live="roleFilter" class="input-field py-2 px-3 w-40">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-800/50 text-slate-400 text-xs uppercase tracking-wider border-b border-slate-700/50">
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Kontak</th>
                        <th class="py-3 px-4">Role Saat Ini</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-700/50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center border border-slate-600">
                                        <span
                                            class="text-lg font-bold text-slate-300">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-400 font-mono">NIK: {{ $user->nik ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-slate-300">{{ $user->email }}</div>
                                <div class="text-xs text-slate-400">{{ $user->phone ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @foreach ($user->roles as $role)
                                    @php
                                        $color = match ($role->name) {
                                            'kepala_desa' => 'bg-purple-500/20 text-purple-400 border-purple-500/20',
                                            'staff' => 'bg-blue-500/20 text-blue-400 border-blue-500/20',
                                            'warga' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/20',
                                            default => 'bg-slate-500/20 text-slate-400 border-slate-500/20',
                                        };
                                    @endphp
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-full text-xs font-medium border {{ $color }}">
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button wire:click="openRoleModal({{ $user->id }})"
                                    class="btn-primary py-1.5 px-3 text-xs items-center gap-1 inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Ubah Role
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">
                                Tidak ada pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-700/50">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Role Modal -->
    <div x-data="{ open: @entangle('showRoleModal') }" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center px-4"
        style="display: none;">

        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

        <div x-show="open" x-transition.scale.95
            class="bg-slate-800 rounded-2xl w-full max-w-md border border-slate-700 shadow-2xl relative z-10 overflow-hidden"
            @click.away="open = false">

            <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
                <h3 class="text-lg font-bold text-white">Ubah Role Pengguna</h3>
                <button @click="open = false" class="text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                @if ($selectedUser)
                    <div class="mb-4 p-3 bg-slate-700/30 rounded-lg flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center">
                            <span
                                class="text-lg font-bold text-slate-300">{{ substr($selectedUser->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <div class="text-sm text-white font-medium">{{ $selectedUser->name }}</div>
                            <div class="text-xs text-slate-400">{{ $selectedUser->email }}</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Pilih Role Baru</label>
                        <select wire:model="newRole" class="input-field w-full">
                            <option value="">Pilih Role...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('newRole')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="flex justify-end gap-3 mt-6">
                    <button @click="open = false" class="btn-secondary">Batal</button>
                    <button wire:click="changeRole" class="btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</div>
