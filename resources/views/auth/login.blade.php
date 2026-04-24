<x-guest-layout>
    <x-slot:title>Login - SIMS Desa Pandak Daun</x-slot:title>

    <div class="glass-card p-8 w-full">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-white">Selamat Datang</h2>
            <p class="text-slate-400 text-sm mt-2">Silakan login menggunakan NIK Anda.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-500">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-medium text-slate-300 mb-2">NIK (Nomor Induk
                    Kependudukan)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                            </path>
                        </svg>
                    </div>
                    <input id="nik" type="text" name="nik" value="{{ old('nik') }}" required autofocus
                        placeholder="16 digit NIK"
                        class="input-field pl-10 block w-full @error('nik') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                </div>
                @error('nik')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-indigo-400 hover:text-indigo-300">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="input-field pl-10 block w-full @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-slate-700 bg-slate-900/50 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-slate-900">
                <label for="remember_me" class="ml-2 block text-sm text-slate-400">
                    Ingat Saya
                </label>
            </div>

            <div>
                <button type="submit" class="w-full btn-primary py-3 flex justify-center items-center gap-2 group">
                    <span>Masuk ke SIMS</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-indigo-400 hover:text-indigo-300">
                Daftar Akun Baru
            </a>
        </div>
    </div>
</x-guest-layout>
