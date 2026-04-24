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
    <body class="antialiased bg-slate-900 text-slate-100 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             style="display: none;"
             class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm md:hidden" 
             x-transition.opacity 
             @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="w-64 bg-slate-800/90 md:bg-slate-800/50 border-r border-slate-700/50 flex flex-col fixed inset-y-0 left-0 z-50 md:relative md:translate-x-0 transition-transform duration-300 ease-in-out backdrop-blur-xl">
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-700/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/30">
                        S
                    </div>
                    <span class="font-bold text-lg tracking-tight">SIMS Desa</span>
                </div>
                <!-- Close button for mobile -->
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <!-- Unified Dynamic Sidebar -->
                @include('components.sidebar.main')
            </nav>
            
            <div class="p-4 border-t border-slate-700/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2 w-full text-left text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden w-full relative">
            <!-- Topbar -->
            <header class="h-16 bg-slate-800/30 border-b border-slate-700/50 backdrop-blur-md flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-xl font-semibold">{{ $header ?? '' }}</h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <livewire:components.notification-bell />
                    
                    <!-- User Menu -->
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-700">
                        <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center border border-slate-600">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</div>
                            <div class="text-xs text-slate-400 capitalize">{{ auth()->user()->roles->first()->name ?? 'Warga' }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 scroll-smooth">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
