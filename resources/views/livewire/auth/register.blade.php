<div>
    <div class="mb-8">
        <!-- Step Indicator -->
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-2xl font-bold text-white">
                @if($step === 1) Data Pribadi @endif
                @if($step === 2) Alamat Domisili @endif
                @if($step === 3) Keamanan Akun @endif
            </h2>
            <span class="text-sm font-medium text-indigo-400">Langkah {{ $step }} dari 3</span>
        </div>
        
        <div class="w-full bg-slate-700 rounded-full h-1.5 mb-6">
            <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-300" style="width: {{ ($step / 3) * 100 }}%"></div>
        </div>
    </div>

    <form wire:submit="register" class="space-y-6">
        @if($step === 1)
            <div wire:transition>
                <div class="space-y-4">
                    <div>
                        <label for="nik" class="block text-sm font-medium text-slate-300 mb-1">NIK (16 Digit)</label>
                        <input id="nik" type="text" wire:model.blur="nik" class="input-field @error('nik') border-red-500 @enderror" placeholder="Contoh: 350711xxxxxxxxxx">
                        @error('nik') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap (Sesuai KTP)</label>
                        <input id="name" type="text" wire:model.blur="name" class="input-field @error('name') border-red-500 @enderror" placeholder="Nama Lengkap">
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-300 mb-1">Nomor HP/WhatsApp</label>
                        <input id="phone" type="text" wire:model.blur="phone" class="input-field @error('phone') border-red-500 @enderror" placeholder="Contoh: 081234567890">
                        @error('phone') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-8 flex gap-3">
                    <a href="{{ route('login') }}" class="w-1/3 px-4 py-2 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg text-center transition-colors">Batal</a>
                    <button type="button" wire:click="nextStep" class="w-2/3 btn-primary text-center">Selanjutnya</button>
                </div>
            </div>
        @endif

        @if($step === 2)
            <div wire:transition>
                <div class="space-y-4">
                    <div>
                        <label for="address" class="block text-sm font-medium text-slate-300 mb-1">Alamat Lengkap (Desa Pandak Daun)</label>
                        <textarea id="address" wire:model.blur="address" rows="2" class="input-field @error('address') border-red-500 @enderror" placeholder="Jalan, Dusun, atau Blok"></textarea>
                        @error('address') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label for="rt" class="block text-sm font-medium text-slate-300 mb-1">RT</label>
                            <input id="rt" type="text" wire:model.blur="rt" class="input-field @error('rt') border-red-500 @enderror" placeholder="001">
                            @error('rt') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="rw" class="block text-sm font-medium text-slate-300 mb-1">RW</label>
                            <input id="rw" type="text" wire:model.blur="rw" class="input-field @error('rw') border-red-500 @enderror" placeholder="002">
                            @error('rw') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="w-1/3 px-4 py-2 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg transition-colors">Kembali</button>
                    <button type="button" wire:click="nextStep" class="w-2/3 btn-primary">Selanjutnya</button>
                </div>
            </div>
        @endif

        @if($step === 3)
            <div wire:transition>
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email (Opsional)</label>
                        <input id="email" type="email" wire:model.blur="email" class="input-field @error('email') border-red-500 @enderror" placeholder="email@contoh.com">
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password</label>
                        <input id="password" type="password" wire:model.blur="password" class="input-field @error('password') border-red-500 @enderror" placeholder="Minimal 8 karakter">
                        @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" wire:model.blur="password_confirmation" class="input-field" placeholder="Ulangi password">
                    </div>
                </div>
                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="w-1/3 px-4 py-2 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg transition-colors">Kembali</button>
                    <button type="submit" class="w-2/3 btn-primary bg-green-500 hover:bg-green-600 text-white flex justify-center items-center">
                        <span wire:loading.remove wire:target="register">Selesaikan Pendaftaran</span>
                        <span wire:loading wire:target="register">Memproses...</span>
                    </button>
                </div>
            </div>
        @endif
    </form>
</div>
