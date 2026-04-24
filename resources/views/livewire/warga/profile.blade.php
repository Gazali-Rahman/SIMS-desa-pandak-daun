<div class="max-w-4xl mx-auto space-y-6">
    @if (session()->has('message'))
        <div class="p-4 bg-green-500/20 border border-green-500/50 rounded-xl flex items-start gap-3">
            <div class="text-green-400 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-green-400">Berhasil!</h4>
                <p class="text-sm text-green-400/80">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <div class="glass-card p-6 md:p-8">
        <h2 class="text-xl font-bold text-white mb-2">Informasi Pribadi</h2>
        <p class="text-sm text-slate-400 mb-8">Pastikan data profil Anda lengkap dan sesuai dengan KTP agar mempermudah verifikasi saat pengajuan surat.</p>
        
        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" wire:model.blur="nik" class="input-field w-full" placeholder="16 digit NIK">
                    @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" wire:model.blur="name" class="input-field w-full">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                    <input type="email" wire:model.blur="email" class="input-field w-full">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">No. WhatsApp / Telepon</label>
                    <input type="text" wire:model.blur="phone" class="input-field w-full" placeholder="08...">
                    @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="border-t border-slate-700/50 pt-6">
                <h3 class="text-lg font-bold text-white mb-4">Informasi Domisili</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Jalan / Dusun</label>
                        <textarea wire:model.blur="address" rows="2" class="input-field w-full" placeholder="Cth: Jl. Raya Pandak Daun No. 12"></textarea>
                        @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- RT -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">RT</label>
                        <input type="text" wire:model.blur="rt" class="input-field w-full" placeholder="001">
                        @error('rt') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- RW -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">RW</label>
                        <input type="text" wire:model.blur="rw" class="input-field w-full" placeholder="002">
                        @error('rw') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Desa -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Desa / Kelurahan</label>
                        <input type="text" wire:model.blur="village" class="input-field w-full" placeholder="Pandak Daun">
                        @error('village') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kecamatan</label>
                        <input type="text" wire:model.blur="district" class="input-field w-full" placeholder="Karang Intan">
                        @error('district') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="btn-primary w-full md:w-auto flex justify-center items-center gap-2">
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
