<div>
    <!-- Notifications -->
    @if (session()->has('message'))
        <div class="mb-4 bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 bg-red-500/20 text-red-400 border border-red-500/50 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="glass-card p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-white">Daftar Role</h3>
                <p class="text-sm text-slate-400">Kelola peran dan hak akses pengguna sistem.</p>
            </div>
            <button wire:click="createRole" class="btn-primary flex items-center gap-2 py-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Role Baru
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($roles as $role)
                <div class="bg-slate-800/50 border border-slate-700/50 rounded-xl p-5 hover:border-indigo-500/50 transition-colors group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold capitalize">{{ str_replace('_', ' ', $role->name) }}</h4>
                                <p class="text-xs text-slate-400">{{ $role->users()->count() }} Pengguna</p>
                            </div>
                        </div>
                        
                        <!-- Actions Dropdown (Alpine) -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" class="text-slate-400 hover:text-white p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </button>
                            <div x-show="open" class="absolute right-0 mt-2 w-48 bg-slate-800 border border-slate-700 rounded-lg shadow-xl z-10 overflow-hidden" style="display: none;">
                                <button wire:click="managePermissions({{ $role->id }})" class="w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    Hak Akses
                                </button>
                                @if(!in_array($role->name, ['warga', 'staff', 'kepala_desa']))
                                    <button wire:click="editRole({{ $role->id }})" class="w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-slate-700 hover:text-white flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Ubah Nama
                                    </button>
                                    <button wire:click="deleteRole({{ $role->id }})" wire:confirm="Yakin ingin menghapus role ini?" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-slate-700 hover:text-red-300 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus Role
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-xs text-slate-400 mb-2">Hak Akses:</p>
                        <div class="flex flex-wrap gap-1">
                            @forelse($role->permissions as $perm)
                                <span class="bg-slate-700 text-slate-300 px-2 py-0.5 rounded text-[10px]">{{ $perm->name }}</span>
                            @empty
                                <span class="text-xs text-slate-500 italic">Belum ada hak akses.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Role Form Modal -->
    <div x-data="{ open: @entangle('showRoleModal') }" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>
        <div x-show="open" x-transition.scale.95 class="bg-slate-800 rounded-2xl w-full max-w-sm border border-slate-700 shadow-2xl relative z-10 overflow-hidden" @click.away="open = false">
            <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
                <h3 class="text-lg font-bold text-white">{{ $roleId ? 'Ubah Role' : 'Tambah Role Baru' }}</h3>
                <button @click="open = false" class="text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Role</label>
                    <input type="text" wire:model="roleName" class="input-field w-full" placeholder="Misal: sekretaris_desa">
                    <p class="text-[10px] text-slate-500 mt-1">Gunakan huruf kecil, spasi akan diubah menjadi underscore (_).</p>
                    @error('roleName') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="open = false" class="btn-secondary">Batal</button>
                    <button wire:click="saveRole" class="btn-primary">Simpan Role</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Modal -->
    <div x-data="{ open: @entangle('showPermissionModal') }" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>
        <div x-show="open" x-transition.scale.95 class="bg-slate-800 rounded-2xl w-full max-w-md border border-slate-700 shadow-2xl relative z-10 overflow-hidden" @click.away="open = false">
            <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
                <h3 class="text-lg font-bold text-white">Kelola Hak Akses</h3>
                <button @click="open = false" class="text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                @if($selectedRole)
                    <div class="mb-4">
                        <p class="text-sm text-slate-400">Menentukan hak akses untuk role <strong class="text-indigo-400 capitalize">{{ str_replace('_', ' ', $selectedRole->name) }}</strong>.</p>
                    </div>
                    
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                        @foreach($permissionsList as $perm)
                            <label class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-lg cursor-pointer hover:bg-slate-700/50 transition-colors">
                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $perm->name }}" class="w-4 h-4 text-indigo-500 rounded border-slate-600 bg-slate-800 focus:ring-indigo-500 focus:ring-offset-slate-800">
                                <span class="text-sm text-slate-200">{{ $perm->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
                
                <div class="flex justify-end gap-3 mt-6">
                    <button @click="open = false" class="btn-secondary">Batal</button>
                    <button wire:click="savePermissions" class="btn-primary">Terapkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
