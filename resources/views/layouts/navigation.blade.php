@php
    $navItems = [
        ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'admin.hero-slides.index', 'pattern' => 'admin.hero-slides.*', 'label' => 'Hero Slider', 'icon' => 'image'],
        ['route' => 'admin.about.edit', 'pattern' => 'admin.about.*', 'label' => 'Tentang Kami', 'icon' => 'heart'],
        ['route' => 'admin.services.index', 'pattern' => 'admin.services.*', 'label' => 'Layanan', 'icon' => 'sparkles'],
        ['route' => 'admin.packages.index', 'pattern' => 'admin.packages.*', 'label' => 'Paket Wedding', 'icon' => 'gift'],
        ['route' => 'admin.gallery.index', 'pattern' => 'admin.gallery.*', 'label' => 'Galeri', 'icon' => 'photos'],
        ['route' => 'admin.bookings.index', 'pattern' => 'admin.bookings.*', 'label' => 'Booking', 'icon' => 'calendar'],
        ['route' => 'admin.contact.edit', 'pattern' => 'admin.contact.*', 'label' => 'Kontak', 'icon' => 'phone'],
    ];
@endphp

<a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-center px-6 pt-7 pb-6 border-b border-blush-50">
    <span class="font-script text-3xl text-rose-500 leading-none">Fariza</span>
    <span class="text-[9px] tracking-[0.3em] text-blush-600 uppercase mt-1">Wedding Organizer</span>
    <span class="mt-3 text-[10px] tracking-[0.2em] text-rose-400 uppercase flex items-center gap-2">
        <i class="w-4 h-px bg-rose-200"></i> Admin Panel <i class="w-4 h-px bg-rose-200"></i>
    </span>
</a>

<nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1">
    @foreach($navItems as $item)
        @php $active = request()->routeIs($item['pattern']); @endphp
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition
               {{ $active ? 'bg-rose-50 text-rose-600' : 'text-blush-600 hover:bg-cream-100 hover:text-rose-500' }}">
            <span class="{{ $active ? 'text-rose-500' : 'text-blush-400' }}">
                @switch($item['icon'])
                    @case('home')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5 12 4l9 7.5M5 10v9a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1v-9"/></svg>
                        @break
                    @case('image')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="m5 18 5-5 3 3 3-4 4 6"/></svg>
                        @break
                    @case('heart')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.5c-6-4-9.5-7.6-9.5-11.5A5 5 0 0 1 12 6a5 5 0 0 1 9.5 3c0 3.9-3.5 7.5-9.5 11.5Z"/></svg>
                        @break
                    @case('sparkles')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.8 4.9L19 9.5l-5.2 1.6L12 16l-1.8-4.9L5 9.5l5.2-1.6L12 3Z"/></svg>
                        @break
                    @case('gift')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="4" y="9" width="16" height="11" rx="1"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16v3.5H4V9Zm8 0v11M12 9c-1.5-4-6-4-6-1.2 0 1.2 1 1.2 6 1.2Zm0 0c1.5-4 6-4 6-1.2 0 1.2-1 1.2-6 1.2Z"/></svg>
                        @break
                    @case('photos')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="3" y="6" width="14" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 6V4.8A1.8 1.8 0 0 1 8.8 3h8.4A1.8 1.8 0 0 1 19 4.8v8.4a1.8 1.8 0 0 1-1.8 1.8H16"/><circle cx="8" cy="11" r="1.2"/><path stroke-linecap="round" stroke-linejoin="round" d="m5 17 3-3 2 2 3-4 4 5"/></svg>
                        @break
                    @case('calendar')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path stroke-linecap="round" d="M8 3v4M16 3v4M3 10h18"/><path stroke-linecap="round" stroke-linejoin="round" d="m8.5 14.5 2 2 4-4"/></svg>
                        @break
                    @case('phone')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.5 4h3l1.5 4-2 1.5a11 11 0 0 0 5.5 5.5l1.5-2 4 1.5v3a2 2 0 0 1-2.2 2A17 17 0 0 1 3.5 6.2 2 2 0 0 1 5.5 4Z"/></svg>
                        @break
                @endswitch
            </span>
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>

<div class="px-4 pb-4">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-blush-500 hover:bg-red-50 hover:text-red-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v1M10 12h10m0 0-3-3m3 3-3 3"/></svg>
            Keluar
        </a>
    </form>
</div>

<a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-4 border-t border-blush-50 hover:bg-cream-50 transition">
    <span class="w-10 h-10 rounded-full bg-rose-100 text-rose-700 font-semibold text-sm flex items-center justify-center shrink-0">
        {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
    </span>
    <span class="min-w-0">
        <span class="block text-sm font-medium text-blush-900 truncate">{{ Auth::user()->name }}</span>
        <span class="block text-xs text-blush-500 truncate">{{ Auth::user()->email }}</span>
    </span>
</a>
