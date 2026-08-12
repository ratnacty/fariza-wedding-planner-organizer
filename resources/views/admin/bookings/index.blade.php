<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-xl text-blush-900">Booking Survei</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

        <div class="flex flex-wrap gap-2 text-sm">
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 rounded-full transition {{ !$status ? 'bg-rose-500 text-white' : 'bg-white border border-blush-200 text-blush-600 hover:bg-blush-50' }}">Semua</a>
            <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-full transition {{ $status === 'pending' ? 'bg-rose-500 text-white' : 'bg-white border border-blush-200 text-blush-600 hover:bg-blush-50' }}">Menunggu</a>
            <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="px-4 py-2 rounded-full transition {{ $status === 'confirmed' ? 'bg-rose-500 text-white' : 'bg-white border border-blush-200 text-blush-600 hover:bg-blush-50' }}">Dikonfirmasi</a>
            <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-full transition {{ $status === 'cancelled' ? 'bg-rose-500 text-white' : 'bg-white border border-blush-200 text-blush-600 hover:bg-blush-50' }}">Dibatalkan</a>
        </div>

        <div class="card overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-blush-500 border-b border-blush-100">
                        <th class="py-3 px-4">Kode</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Nama &amp; Kontak</th>
                        <th class="py-3 px-4">Layanan / Paket</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-b border-blush-50 align-top">
                            <td class="py-3 px-4 font-mono text-xs text-blush-500">{{ $booking->code }}</td>
                            <td class="py-3 px-4">{{ $booking->wedding_date->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-blush-900">{{ $booking->name }}</div>
                                <div class="text-xs text-blush-500">{{ $booking->whatsapp }}</div>
                                @if($booking->event_location)
                                    <div class="text-xs text-blush-400">{{ $booking->event_location }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-xs text-blush-600">
                                {{ $booking->service->name ?? '-' }}
                                @if($booking->package)<br>Paket {{ $booking->package->name }}@endif
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300">
                                        <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                        <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Hapus booking dari {{ $booking->name }}?');" class="text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-blush-400">Belum ada data booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $bookings->links() }}
        </div>

        <div class="card p-6">
            <h3 class="font-serif text-lg text-blush-900 mb-1">Tutup Tanggal Kalender</h3>
            <p class="text-xs text-blush-500 mb-4">Tanggal yang ditutup akan otomatis berstatus "Penuh" pada kalender booking di halaman publik (misal untuk hari libur).</p>

            <form action="{{ route('admin.blocked-dates.store') }}" method="POST" class="flex flex-wrap items-end gap-3">
                @csrf
                <div>
                    <label class="text-xs font-medium text-blush-600">Tanggal</label>
                    <input type="date" name="date" required class="mt-1 rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="text-xs font-medium text-blush-600">Alasan (opsional)</label>
                    <input type="text" name="reason" placeholder="Hari libur nasional, dsb." class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>
                <button type="submit" class="btn-primary !px-5 !py-2.5 text-sm">Tutup Tanggal</button>
            </form>

            @if($blockedDates->isNotEmpty())
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach($blockedDates as $blocked)
                        <span class="inline-flex items-center gap-2 bg-blush-50 text-blush-700 text-xs px-3 py-1.5 rounded-full">
                            {{ $blocked->date->translatedFormat('d M Y') }}
                            @if($blocked->reason) &middot; {{ $blocked->reason }} @endif
                            <form action="{{ route('admin.blocked-dates.destroy', $blocked) }}" method="POST" onsubmit="return confirm('Buka kembali tanggal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700">&times;</button>
                            </form>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
