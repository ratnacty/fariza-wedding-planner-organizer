@php
    $cumulative = 0;
    $gradientStops = $statusBreakdown->map(function ($item) use (&$cumulative) {
        $start = $cumulative;
        $cumulative += $item['percent'];

        return "{$item['color']} {$start}% {$cumulative}%";
    })->implode(', ');

    $weekDays = ['SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB', 'MIN'];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-lg text-blush-900 truncate">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-xs text-blush-500">Kelola semua data wedding organizer dengan mudah.</p>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Stat cards --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <span class="w-11 h-11 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="4" y="7" width="16" height="13" rx="2"/><path stroke-linecap="round" d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </span>
                    <p class="text-xs uppercase tracking-wide text-blush-500">Total Booking</p>
                </div>
                <p class="mt-3 text-3xl font-serif text-blush-900">{{ $bookingsThisMonth }}</p>
                <p class="text-xs text-blush-400 mt-1">
                    Booking bulan ini
                    @if($trendPercent != 0)
                        <span class="{{ $trendPercent > 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
                            {{ $trendPercent > 0 ? '↑' : '↓' }} {{ abs($trendPercent) }}%
                        </span>
                        dari bulan lalu
                    @endif
                </p>
            </div>

            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <span class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="4" y="9" width="16" height="11" rx="1"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16v3.5H4V9Zm8 0v11M12 9c-1.5-4-6-4-6-1.2 0 1.2 1 1.2 6 1.2Zm0 0c1.5-4 6-4 6-1.2 0 1.2-1 1.2-6 1.2Z"/></svg>
                    </span>
                    <p class="text-xs uppercase tracking-wide text-blush-500">Paket Wedding</p>
                </div>
                <p class="mt-3 text-3xl font-serif text-blush-900">{{ $totalPackages }}</p>
                <p class="text-xs text-blush-400 mt-1">Total paket tersedia</p>
            </div>

            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <span class="w-11 h-11 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.8 4.9L19 9.5l-5.2 1.6L12 16l-1.8-4.9L5 9.5l5.2-1.6L12 3Z"/></svg>
                    </span>
                    <p class="text-xs uppercase tracking-wide text-blush-500">Layanan</p>
                </div>
                <p class="mt-3 text-3xl font-serif text-blush-900">{{ $totalServices }}</p>
                <p class="text-xs text-blush-400 mt-1">Wedding Organizer &amp; MUA</p>
            </div>

            <div class="card p-5">
                <div class="flex items-center gap-3">
                    <span class="w-11 h-11 rounded-xl bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10" r="1.3"/><path stroke-linecap="round" stroke-linejoin="round" d="m5 16 4-4 3 3 4-5 5 6"/></svg>
                    </span>
                    <p class="text-xs uppercase tracking-wide text-blush-500">Galeri Foto</p>
                </div>
                <p class="mt-3 text-3xl font-serif text-blush-900">{{ $totalGalleries }}</p>
                <p class="text-xs text-blush-400 mt-1">Total foto galeri</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6 items-start">
            {{-- Left column --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-serif text-lg text-blush-900">Booking Terbaru</h3>
                    </div>

                    @if($latestBookings->isEmpty())
                        <p class="text-sm text-blush-500">Belum ada booking masuk.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-xs uppercase text-blush-500 border-b border-blush-100">
                                        <th class="py-2 pr-4">Nama</th>
                                        <th class="py-2 pr-4">Tanggal</th>
                                        <th class="py-2 pr-4">Paket</th>
                                        <th class="py-2 pr-4">Layanan</th>
                                        <th class="py-2 pr-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestBookings as $booking)
                                        <tr class="border-b border-blush-50">
                                            <td class="py-3 pr-4 font-medium text-blush-900">{{ $booking->name }}</td>
                                            <td class="py-3 pr-4 text-blush-600">{{ $booking->wedding_date->translatedFormat('d M Y') }}</td>
                                            <td class="py-3 pr-4 text-blush-600">{{ $booking->package->name ?? '-' }}</td>
                                            <td class="py-3 pr-4 text-blush-600">{{ $booking->service->name ?? '-' }}</td>
                                            <td class="py-3 pr-4">
                                                <span class="px-2 py-1 rounded-full text-xs
                                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                                    {{ $booking->statusLabel() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="text-center mt-5">
                        <a href="{{ route('admin.bookings.index') }}" class="btn-primary text-sm !px-5 !py-2.5">Lihat Semua Booking</a>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-serif text-base text-blush-900">Paket Populer</h3>
                            <a href="{{ route('admin.packages.index') }}" class="text-xs text-rose-500 hover:text-rose-600">Lihat semua</a>
                        </div>

                        @if($popularPackages->isEmpty())
                            <p class="text-sm text-blush-500">Belum ada booking untuk paket manapun.</p>
                        @else
                            <ul class="space-y-3">
                                @foreach($popularPackages as $package)
                                    <li class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden shrink-0">
                                            <x-photo-placeholder :color="$package->cover_color" :src="$package->imageUrl()" class="w-full h-full" />
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-blush-900 truncate">{{ $package->name }}</p>
                                            <p class="text-xs text-rose-500">{{ $package->bookings_count }} booking</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="card p-6">
                        <h3 class="font-serif text-base text-blush-900 mb-4">Statistik Booking</h3>

                        @if($totalBookings === 0)
                            <p class="text-sm text-blush-500">Belum ada data booking.</p>
                        @else
                            <div class="flex items-center gap-5">
                                <div class="relative w-28 h-28 rounded-full shrink-0" style="background: conic-gradient({{ $gradientStops }})">
                                    <div class="absolute inset-3 bg-white rounded-full flex flex-col items-center justify-center">
                                        <span class="text-xl font-serif text-blush-900">{{ $totalBookings }}</span>
                                        <span class="text-[10px] text-blush-500">Total</span>
                                    </div>
                                </div>
                                <ul class="space-y-2 text-xs">
                                    @foreach($statusBreakdown as $item)
                                        <li class="flex items-center gap-2">
                                            <i class="w-2.5 h-2.5 rounded-full inline-block" style="background: {{ $item['color'] }}"></i>
                                            <span class="text-blush-600">{{ $item['label'] }}</span>
                                            <span class="text-blush-400">{{ $item['count'] }} ({{ $item['percent'] }}%)</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="space-y-6">
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-serif text-base text-blush-900">Kalender Booking</h3>
                        <span class="text-xs text-blush-500">{{ $calendarMonthLabel }}</span>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-semibold text-blush-400 mb-2">
                        @foreach($weekDays as $day)
                            <span>{{ $day }}</span>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        @for($n = 0; $n < $calendarStartOffset; $n++)
                            <span></span>
                        @endfor
                        @for($day = 1; $day <= $calendarDaysInMonth; $day++)
                            @php $status = $calendarDays[$day]['status'] ?? 'tersedia'; @endphp
                            <div class="flex items-center justify-center">
                                <span class="w-7 h-7 flex items-center justify-center rounded-full text-[11px]
                                    {{ match($status) {
                                        'penuh' => 'bg-blush-200 text-blush-500',
                                        'terbooking' => 'bg-rose-200 text-rose-800 font-medium',
                                        'lewat' => 'text-blush-300',
                                        default => 'bg-cream-100 text-blush-700',
                                    } }}">
                                    {{ $day }}
                                </span>
                            </div>
                        @endfor
                    </div>

                    <div class="flex flex-wrap gap-3 mt-4 pt-4 border-t border-blush-100 text-[10px] text-blush-500">
                        <span class="flex items-center gap-1.5"><i class="w-2.5 h-2.5 rounded-full bg-cream-200 border border-blush-200 inline-block"></i> Tersedia</span>
                        <span class="flex items-center gap-1.5"><i class="w-2.5 h-2.5 rounded-full bg-rose-200 inline-block"></i> Terbooking</span>
                        <span class="flex items-center gap-1.5"><i class="w-2.5 h-2.5 rounded-full bg-blush-200 inline-block"></i> Penuh</span>
                    </div>
                </div>

                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-serif text-base text-blush-900">Booking Mendatang</h3>
                        <a href="{{ route('admin.bookings.index') }}" class="text-xs text-rose-500 hover:text-rose-600">Lihat semua</a>
                    </div>

                    @if($upcomingBookings->isEmpty())
                        <p class="text-sm text-blush-500">Belum ada booking survei mendatang.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach($upcomingBookings as $booking)
                                <li class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-rose-50 flex flex-col items-center justify-center text-rose-600 shrink-0">
                                        <span class="text-[9px] uppercase font-semibold leading-none">{{ $booking->wedding_date->translatedFormat('M') }}</span>
                                        <span class="text-base font-serif leading-none mt-0.5">{{ $booking->wedding_date->format('d') }}</span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-blush-900 truncate">{{ $booking->name }}</p>
                                        <p class="text-xs text-blush-500 truncate">
                                            {{ $booking->package->name ?? 'Tanpa paket' }}
                                            @if($booking->service) &middot; {{ $booking->service->name }} @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
