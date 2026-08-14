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

                <div class="grid sm:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="text-xs font-medium text-blush-600">Latitude Peta</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $contact->latitude) }}" placeholder="-6.3100" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-blush-600">Longitude Peta</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $contact->longitude) }}" placeholder="106.6800" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                    </div>
                </div>
                <p class="text-xs text-blush-400 mt-1">Cari lokasi di Google Maps, klik kanan titiknya lalu salin koordinat yang muncul (format: latitude, longitude).</p>

                <div class="mt-8">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
