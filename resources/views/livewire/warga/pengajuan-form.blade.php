<div class="max-w-4xl mx-auto">
    <!-- Stepper Indicator -->
    <div class="mb-10">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-700 -z-10 rounded-full"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-indigo-500 -z-10 rounded-full transition-all duration-300" style="width: {{ ($step - 1) * 33.33 }}%"></div>
            
            @foreach(['Pilih Surat', 'Isi Data', 'Upload', 'Konfirmasi'] as $index => $label)
                @php $stepNumber = $index + 1; @endphp
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors border-2
                        {{ $step >= $stepNumber ? 'bg-indigo-500 border-indigo-500 text-white' : 'bg-slate-800 border-slate-600 text-slate-400' }}">
                        @if($step > $stepNumber)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                    <span class="text-xs font-medium {{ $step >= $stepNumber ? 'text-indigo-400' : 'text-slate-500' }} hidden sm:block">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="glass-card p-6 md:p-8">
        <!-- Step 1: Pilih Surat -->
        @if($step === 1)
            <div wire:transition>
                <h2 class="text-xl font-bold text-white mb-6">Pilih Jenis Surat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($jenisSuratList as $surat)
                        <button type="button" wire:click="selectSurat({{ $surat['id'] }})" class="p-4 border border-slate-700 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 hover:border-indigo-500 text-left transition-all group flex items-start gap-4 overflow-hidden">
                            <div class="w-12 h-12 rounded-lg bg-slate-700 group-hover:bg-indigo-500/20 text-slate-400 group-hover:text-indigo-400 flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $surat['icon'] }}"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-white mb-1 group-hover:text-indigo-300 truncate">{{ $surat['nama'] }}</h3>
                                <p class="text-xs text-slate-400 truncate">{{ $surat['deskripsi'] ?? 'Pengajuan surat baru.' }}</p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Step 2: Isi Data Dinamis -->
        @if($step === 2 && $selectedSuratData)
            <div wire:transition>
                <h2 class="text-xl font-bold text-white mb-6">Lengkapi Data Pengajuan: {{ $selectedSuratData->nama }}</h2>
                
                <div class="bg-slate-900/50 p-4 rounded-lg border border-slate-700 mb-6 flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-white">Data Profil Otomatis</h4>
                        <p class="text-xs text-slate-400">Nama, NIK, dan Alamat Anda akan otomatis tercetak di surat berdasarkan data profil Anda.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Keperluan Pembuatan Surat <span class="text-red-400">*</span></label>
                        <textarea wire:model.blur="keperluan" rows="3" class="input-field" placeholder="Contoh: Untuk persyaratan pendaftaran beasiswa"></textarea>
                        @error('keperluan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    @if(is_array($selectedSuratData->form_fields) && count($selectedSuratData->form_fields) > 0)
                        <div class="pt-4 mt-4 border-t border-slate-700 space-y-4">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-3">Informasi Tambahan</h3>
                            
                            @foreach($selectedSuratData->form_fields as $field)
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-1">{{ $field['label'] }} <span class="text-red-400">*</span></label>
                                    @if($field['type'] === 'number')
                                        <input type="number" wire:model.blur="data_tambahan.{{ $field['name'] }}" class="input-field" placeholder="{{ $field['label'] }}">
                                    @elseif($field['type'] === 'date')
                                        <input type="date" wire:model.blur="data_tambahan.{{ $field['name'] }}" class="input-field">
                                    @else
                                        <input type="text" wire:model.blur="data_tambahan.{{ $field['name'] }}" class="input-field" placeholder="{{ $field['label'] }}">
                                    @endif
                                    @error("data_tambahan.{$field['name']}") <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="px-6 py-2 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg transition-colors">Kembali</button>
                    <button type="button" wire:click="nextStep" class="btn-primary flex-1">Selanjutnya</button>
                </div>
            </div>
        @endif

        <!-- Step 3: Upload -->
        @if($step === 3 && $selectedSuratData)
            <div wire:transition>
                <h2 class="text-xl font-bold text-white mb-6">Unggah Berkas Persyaratan</h2>
                
                <div class="space-y-6">
                    @php 
                        $syaratList = is_array($selectedSuratData->syarat) ? $selectedSuratData->syarat : (json_decode($selectedSuratData->syarat, true) ?? []); 
                    @endphp
                    
                    @foreach($syaratList as $key => $is_required)
                        @if($is_required)
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2 capitalize">{{ str_replace('_', ' ', $key) }} <span class="text-red-400">*</span></label>
                                <div class="flex items-center gap-4">
                                    <div class="w-32 h-24 border-2 border-dashed border-slate-600 rounded-lg flex flex-col items-center justify-center bg-slate-800/50 hover:bg-slate-800 transition-colors relative overflow-hidden">
                                        @if(isset($dokumen[$key]) && $dokumen[$key])
                                            <img src="{{ $dokumen[$key]->temporaryUrl() }}" class="object-cover w-full h-full">
                                            <button type="button" wire:click="$set('dokumen.{{ $key }}', null)" class="absolute top-1 right-1 bg-red-500/80 p-1 rounded-full text-white hover:bg-red-500">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        @else
                                            <svg class="w-8 h-8 text-slate-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Pilih Foto</span>
                                            <input type="file" wire:model.live="dokumen.{{ $key }}" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-slate-400 mb-1">Pastikan foto terlihat jelas dan tidak terpotong.</p>
                                        <p class="text-xs text-slate-500">Format: JPG, PNG. Max: 2MB.</p>
                                        @error('dokumen.'.$key) <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if(count(array_filter($syaratList)) === 0)
                        <div class="p-6 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-center">
                            <svg class="w-10 h-10 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-medium">Tidak ada berkas yang wajib diunggah.</p>
                            <p class="text-sm mt-1">Anda bisa langsung melanjutkan ke proses konfirmasi.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="px-6 py-2 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg transition-colors">Kembali</button>
                    <button type="button" wire:click="nextStep" class="btn-primary flex-1">Selanjutnya</button>
                </div>
            </div>
        @endif

        <!-- Step 4: Konfirmasi -->
        @if($step === 4 && $selectedSuratData)
            <div wire:transition x-data="{ confirmed: false }">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Konfirmasi Data</h2>
                        <p class="text-xs text-slate-400">Pastikan semua data sudah benar sebelum mengirim pengajuan.</p>
                    </div>
                </div>

                <div class="bg-slate-900/50 border border-slate-700 rounded-xl p-5 space-y-4 mb-6">
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Jenis Surat</div>
                        <div class="font-medium text-white">{{ $selectedSuratData->nama }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Keperluan</div>
                        <div class="font-medium text-white">{{ $keperluan }}</div>
                    </div>
                    
                    @if(count($data_tambahan) > 0)
                        <div class="pt-4 mt-2 border-t border-slate-800">
                            <div class="text-xs text-slate-500 mb-2">Data Tambahan:</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($selectedSuratData->form_fields as $field)
                                    <div>
                                        <div class="text-[10px] uppercase tracking-wider text-slate-500 mb-1">{{ $field['label'] }}</div>
                                        <div class="text-sm text-slate-300">{{ $data_tambahan[$field['name']] ?? '-' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-4 border-t border-slate-800">
                        @foreach((is_array($selectedSuratData->syarat) ? $selectedSuratData->syarat : (json_decode($selectedSuratData->syarat, true) ?? [])) as $key => $is_required)
                            @if($is_required)
                                <div>
                                    <div class="text-[10px] uppercase tracking-wider text-slate-500 mb-2">Lampiran {{ str_replace('_', ' ', $key) }}</div>
                                    <div class="flex items-center gap-2 text-sm text-green-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Terlampir
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <label class="flex items-start gap-3 cursor-pointer group">
                    <div class="relative flex items-center justify-center mt-0.5">
                        <input type="checkbox" x-model="confirmed" class="w-5 h-5 border-2 border-slate-600 rounded bg-transparent checked:bg-indigo-500 checked:border-indigo-500 transition-all cursor-pointer appearance-none">
                        <svg class="w-3.5 h-3.5 text-white absolute pointer-events-none opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm text-slate-400 group-hover:text-slate-300 transition-colors">
                        Saya menyatakan bahwa data yang saya isikan adalah benar dan dapat dipertanggungjawabkan sesuai hukum yang berlaku.
                    </span>
                </label>

                <div class="mt-8 flex gap-3">
                    <button type="button" wire:click="previousStep" class="px-6 py-2 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg transition-colors">Kembali</button>
                    <button type="button" wire:click="submit" x-bind:disabled="!confirmed" x-bind:class="!confirmed ? 'opacity-50 cursor-not-allowed' : ''" class="btn-primary flex-1 flex justify-center items-center gap-2 transition-all">
                        <span wire:loading.remove wire:target="submit">Kirim Pengajuan</span>
                        <span wire:loading wire:target="submit">Mengirim...</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
