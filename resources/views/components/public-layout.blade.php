<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Fariza Wedding Organizer' }}</title>
    <meta name="description" content="Fariza Wedding Organizer &mdash; wujudkan pernikahan impian Anda dengan pelayanan wedding organizer dan makeup artist profesional.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-50">
    <div x-data="{ mobileOpen: false, scrolled: false }"
         x-init="scrolled = window.scrollY > 8; window.addEventListener('scroll', () => scrolled = window.scrollY > 8)">

        <header class="sticky top-0 z-50 transition-all duration-300"
                :class="scrolled ? 'bg-cream-50/90 backdrop-blur-md shadow-sm' : 'bg-transparent'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex items-center justify-between h-20">
                    <a href="{{ route('home') }}" class="flex flex-col leading-none group">
                        <span class="font-script text-3xl text-rose-500 group-hover:text-rose-600 transition">Fariza</span>
                        <span class="text-[10px] tracking-[0.3em] text-blush-700 uppercase -mt-1">Wedding Organizer</span>
                    </a>

                    <nav class="hidden lg:flex items-center gap-8 text-sm font-medium text-blush-800">
                        <a href="{{ route('home') }}" data-nav="beranda" class="nav-link hover:text-rose-500 transition-colors duration-300 {{ request()->routeIs('home') ? 'text-rose-500 is-active' : '' }}">Beranda</a>
                        <a href="{{ route('home') }}#tentang" data-nav="tentang" class="nav-link hover:text-rose-500 transition-colors duration-300">Tentang Kami</a>
                        <a href="{{ route('packages.index') }}" class="nav-link hover:text-rose-500 transition-colors duration-300 {{ request()->routeIs('packages.*') ? 'text-rose-500 is-active' : '' }}">Paket Wedding</a>
                        <a href="{{ route('home') }}#layanan" data-nav="layanan" class="nav-link hover:text-rose-500 transition-colors duration-300">MUA &amp; Makeup</a>
                        <a href="{{ route('gallery.index') }}" class="nav-link hover:text-rose-500 transition-colors duration-300 {{ request()->routeIs('gallery.*') ? 'text-rose-500 is-active' : '' }}">Galeri</a>
                        <a href="{{ route('home') }}#kalender" data-nav="kalender" class="nav-link hover:text-rose-500 transition-colors duration-300">Kalender</a>
                        <a href="{{ route('home') }}#kontak" data-nav="kontak" class="nav-link hover:text-rose-500 transition-colors duration-300">Kontak</a>
                    </nav>

                    <div class="hidden lg:block">
                        <a href="{{ route('home') }}#booking" class="btn-primary">Booking Survei</a>
                    </div>

                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-rose-600" aria-label="Menu">
                        <svg x-show="!mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <div x-show="mobileOpen" x-cloak x-transition
                 class="lg:hidden bg-cream-50 border-t border-blush-100 shadow-lg">
                <nav class="flex flex-col px-6 py-4 gap-3 text-sm font-medium text-blush-800">
                    <a href="{{ route('home') }}" @click="mobileOpen=false">Beranda</a>
                    <a href="{{ route('home') }}#tentang" @click="mobileOpen=false">Tentang Kami</a>
                    <a href="{{ route('packages.index') }}" @click="mobileOpen=false">Paket Wedding</a>
                    <a href="{{ route('home') }}#layanan" @click="mobileOpen=false">MUA &amp; Makeup</a>
                    <a href="{{ route('gallery.index') }}" @click="mobileOpen=false">Galeri</a>
                    <a href="{{ route('home') }}#kalender" @click="mobileOpen=false">Kalender</a>
                    <a href="{{ route('home') }}#kontak" @click="mobileOpen=false">Kontak</a>
                    <a href="{{ route('home') }}#booking" class="btn-primary mt-2 w-full" @click="mobileOpen=false">Booking Survei</a>
                </nav>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="relative overflow-hidden bg-gradient-to-b from-blush-900 via-rose-800 to-rose-500 text-cream-100">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 85% 20%, white 0, transparent 30%), radial-gradient(circle at 10% 80%, white 0, transparent 25%);"></div>
            <x-floral-corner class="absolute bottom-0 left-0 pointer-events-none select-none" />
            <x-floral-corner flip class="absolute bottom-0 right-0 pointer-events-none select-none" />
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-7 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <span class="font-script text-3xl text-rose-200">Fariza</span>
                    <p class="mt-2 text-sm text-cream-200/80 leading-relaxed">Mewujudkan pernikahan impian dengan pelayanan terbaik.</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-rose-200 mb-2.5">Menu</h4>
                    <ul class="space-y-1.5 text-sm text-cream-200/80">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('home') }}#tentang" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('packages.index') }}" class="hover:text-white transition">Paket Wedding</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-white transition">Galeri</a></li>
                        <li><a href="{{ route('home') }}#kalender" class="hover:text-white transition">Kalender</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-rose-200 mb-2.5">Layanan</h4>
                    <ul class="space-y-1.5 text-sm text-cream-200/80">
                        <li>Wedding Organizer</li>
                        <li>Makeup Artist (MUA)</li>
                    </ul>
                </div>
                <div id="kontak">
                    @php $contact = \App\Models\Contact::first(); @endphp
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-rose-200 mb-2.5">Kontak</h4>
                    <ul class="space-y-1.5 text-sm text-cream-200/80">
                        <li>{{ $contact->phone ?? '0812-3456-7890' }}</li>
                        <li>{{ $contact->email ?? 'farizawedding@gmail.com' }}</li>
                        <li>{{ $contact->address ?? 'Jl. Raya Serpong No. 123, Tangerang Selatan, Banten' }}</li>
                    </ul>
                </div>
            </div>
            <div class="relative border-t border-white/10 py-2.5 text-center text-xs text-cream-200/60">
                &copy; {{ date('Y') }} Fariza Wedding Organizer. All Rights Reserved.
            </div>
        </footer>
    </div>
</body>
</html>
