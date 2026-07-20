<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'SIMS - Desa Pandak Daun' }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased bg-slate-900 text-slate-100 min-h-screen flex">
        
        <!-- Left Side: Branding/Illustration -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-slate-800 items-center justify-center overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-[20%] -left-[10%] w-[70%] h-[70%] rounded-full bg-indigo-500/20 blur-[120px]"></div>
                <div class="absolute top-[60%] -right-[20%] w-[60%] h-[60%] rounded-full bg-blue-500/20 blur-[100px]"></div>
            </div>
            
            <div class="relative z-10 flex flex-col items-center text-center px-12 max-w-lg">
                <div class="w-20 h-20 bg-indigo-500 rounded-2xl flex items-center justify-center mb-8 shadow-2xl shadow-indigo-500/40 border border-indigo-400/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <h1 class="text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-blue-400">
                    APLIKASI PELAYANAN ADMINISTRASI PENDUDUK DESA PANDAK DAUN BERBASIS WEB
                </h1>
                <p class="text-slate-400 text-lg">
                    Layanan pengajuan administrasi persuratan digital Desa Pandak Daun. Mudah, cepat, dan transparan.
                </p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <!-- Mobile Logo (hidden on desktop) -->
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/30">
                        S
                    </div>
                    <span class="font-bold text-xl tracking-tight">SIMS Desa</span>
                </div>

                {{ $slot }}
            </div>
        </div>

        @livewireScripts
    </body>
</html>
