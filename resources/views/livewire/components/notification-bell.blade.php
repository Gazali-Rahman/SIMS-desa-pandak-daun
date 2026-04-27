<div class="relative" x-data="{ open: @entangle('isOpen') }" @click.outside="open = false">
    <!-- Bell Button -->
    <button @click="open = !open; $wire.toggleDropdown()"
        class="relative p-2 text-slate-400 hover:text-white transition-colors rounded-lg hover:bg-slate-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>

        @if ($unreadCount > 0)
            <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border border-slate-900"></span>
            </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-slate-800 border border-slate-700/50 rounded-xl shadow-2xl overflow-hidden z-50 origin-top-right backdrop-blur-xl"
        style="display: none;">

        <div class="px-4 py-3 border-b border-slate-700/50 flex justify-between items-center bg-slate-800/80">
            <h3 class="text-sm font-bold text-white">Notifikasi</h3>
            @if ($unreadCount > 0)
                <span
                    class="bg-red-500/20 text-red-400 py-0.5 px-2 rounded-full text-xs font-medium">{{ $unreadCount }}
                    Baru</span>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto divide-y divide-slate-700/50">
            @forelse($notifications as $notification)
                @php
                    $data = $notification->data;
                    $colorClass = match ($data['color'] ?? 'blue') {
                        'blue' => 'text-blue-400 bg-blue-500/20',
                        'green' => 'text-green-400 bg-green-500/20',
                        'red' => 'text-red-400 bg-red-500/20',
                        'indigo' => 'text-indigo-400 bg-indigo-500/20',
                        default => 'text-slate-400 bg-slate-500/20',
                    };
                @endphp
                <button wire:click="markAsRead('{{ $notification->id }}', '{{ $data['url'] ?? '#' }}')"
                    class="w-full text-left px-4 py-3 hover:bg-slate-700/50 transition-colors flex gap-3 group relative">
                    <!-- Unread dot indicator -->
                    <div class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-blue-500"></div>

                    <div class="shrink-0 mt-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $colorClass }}">
                            @if (($data['icon'] ?? '') == 'document-text')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white group-hover:text-indigo-300 transition-colors">
                            {{ $data['title'] ?? 'Notifikasi Baru' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-2">{{ $data['message'] ?? '' }}</p>
                        <p class="text-[10px] text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </button>
            @empty
                <div class="px-4 py-8 text-center text-slate-500 flex flex-col items-center">
                    <svg class="w-10 h-10 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <p class="text-sm">Tidak ada notifikasi baru</p>
                </div>
            @endforelse
        </div>

        @if ($unreadCount > 0)
            <div class="p-2 border-t border-slate-700/50 bg-slate-800/80">
                <button wire:click="markAllAsRead"
                    class="w-full text-center px-4 py-2 text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition-colors">
                    Tandai semua dibaca
                </button>
            </div>
        @endif
    </div>
</div>
