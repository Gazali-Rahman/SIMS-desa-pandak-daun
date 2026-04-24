<x-guest-layout>
    <div class="glass-card p-8 rounded-2xl w-full">
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-indigo-500/20 rounded-2xl flex items-center justify-center border border-indigo-500/50 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-center text-white mb-2">Verifikasi Email Anda</h2>
        
        <div class="mb-6 text-sm text-slate-400 text-center leading-relaxed">
            Terima kasih telah mendaftar! Sebelum mulai mengajukan surat, mohon verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan ke kotak masuk Anda. Jika Anda tidak menerimanya, kami dengan senang hati akan mengirimkan ulang.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 font-medium text-sm text-green-400 text-center bg-green-500/10 py-3 rounded-lg border border-green-500/20">
                Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat registrasi.
            </div>
        @endif

        <div class="mt-8 flex flex-col items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <button type="submit" class="btn-primary w-full text-center flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full px-4 py-2.5 rounded-xl font-semibold text-sm border border-slate-600 hover:bg-slate-800 text-slate-300 transition-all hover:shadow-[0_0_15px_rgba(255,255,255,0.05)]">
                    Keluar / Ganti Akun
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
