<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-xl text-blush-900">Kontak</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card p-6">
            <form method="POST" action="{{ route('admin.contact.update') }}">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 mb-5">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="text-xs font-medium text-blush-600">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" placeholder="0812-3456-7890" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Email</label>
                    <input type="email" name="email" value="{{ old('email', $contact->email) }}" placeholder="farizawedding@gmail.com" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Alamat</label>
                    <textarea name="address" rows="3" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">{{ old('address', $contact->address) }}</textarea>
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Jam Operasional</label>
                    <input type="text" name="hours" value="{{ old('hours', $contact->hours) }}" placeholder="Senin - Minggu, 08.00 - 20.00 WIB" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Link Google Maps (opsional)</label>
                    <input type="url" name="map_url" value="{{ old('map_url', $contact->map_url) }}" placeholder="https://maps.app.goo.gl/xxxxx atau https://www.google.com/maps/..." class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                    <p class="text-xs text-blush-400 mt-1">
                        Tidak wajib diisi &mdash; titik lokasi di peta beranda otomatis dicari dari <strong>Alamat</strong> di atas. Kalau kamu tempel link Google Maps di sini, kolom <strong>Alamat akan ikut diperbarui otomatis</strong> mengikuti alamat dari link tersebut saat disimpan.
                    </p>
                    @if($contact->latitude && $contact->longitude)
                        <p class="text-xs text-emerald-600 mt-1">Titik lokasi di peta saat ini: {{ $contact->latitude }}, {{ $contact->longitude }}</p>
                    @endif
                </div>

                <div class="mt-8">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
