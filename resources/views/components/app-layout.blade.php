<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($header) ? strip_tags($header) . ' - ' : '' }}Fariza Admin</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $pendingBookingsCount = \App\Models\Booking::where('status', \App\Models\Booking::STATUS_PENDING)->count();
        @endphp

        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-cream-50">
            {{-- Mobile sidebar overlay --}}
            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
                 x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-blush-900/40 z-40 lg:hidden"></div>

            {{-- Sidebar --}}
            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 bg-white border-r border-blush-100 flex flex-col transition-transform duration-200 ease-in-out lg:static lg:translate-x-0">
                @include('layouts.navigation')
            </aside>

            {{-- Main column --}}
            <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
                {{-- Topbar --}}
                <header class="sticky top-0 z-30 bg-white border-b border-blush-100">
                    <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-blush-500 hover:text-rose-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                            </button>
                            <div class="min-w-0 flex-1">
                                {{ $header ?? '' }}
                            </div>
                        </div>

                        <div class="flex items-center gap-4 shrink-0">
                            <a href="{{ route('home') }}" target="_blank" class="hidden md:inline text-xs text-blush-500 hover:text-rose-500 transition">Lihat Situs &#8599;</a>

                            <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="relative p-2 rounded-full text-blush-500 hover:bg-blush-50 hover:text-rose-500 transition" title="Booking menunggu konfirmasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/></svg>
                                @if($pendingBookingsCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] px-1 flex items-center justify-center rounded-full bg-rose-500 text-white text-[10px] font-semibold">{{ $pendingBookingsCount }}</span>
                                @endif
                            </a>

                            <span class="hidden sm:inline-flex items-center gap-2 text-xs text-blush-600 bg-cream-100 rounded-full px-3 py-1.5">
                                <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path stroke-linecap="round" d="M8 3v4M16 3v4M3 10h18"/></svg>
                                {{ now()->translatedFormat('l, d F Y') }}
                            </span>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="w-9 h-9 rounded-full bg-rose-100 text-rose-700 font-semibold text-sm flex items-center justify-center hover:bg-rose-200 transition">
                                        {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-4 py-2 border-b border-blush-50">
                                        <p class="text-sm font-medium text-blush-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-blush-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <x-dropdown-link :href="route('profile.edit')">{{ __('Profil') }}</x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Keluar') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                @if(session('status'))
                    <div class="px-4 sm:px-6 lg:px-8 pt-6">
                        <div class="rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
