<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-xl text-blush-900">Paket Wedding</h2>
            <a href="{{ route('admin.packages.create') }}" class="btn-primary text-sm !px-4 !py-2">+ Tambah Paket</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-blush-500 border-b border-blush-100">
                        <th class="py-3 px-4">Foto</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Harga</th>
                        <th class="py-3 px-4">Urutan</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                        <tr class="border-b border-blush-50">
                            <td class="py-3 px-4">
                                <div class="w-14 h-14 rounded-lg overflow-hidden">
                                    <x-photo-placeholder :color="$package->cover_color" :src="$package->imageUrl()" class="w-full h-full" />
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-blush-900">{{ $package->name }}</div>
                                <div class="text-xs text-blush-500">{{ $package->tagline }}</div>
                            </td>
                            <td class="py-3 px-4">{{ $package->price ? 'Rp '.number_format($package->price, 0, ',', '.') : '-' }}</td>
                            <td class="py-3 px-4">{{ $package->order }}</td>
                            <td class="py-3 px-4">
                                @if($package->is_active)
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                                @if($package->is_featured)
                                    <span class="px-2 py-1 rounded-full text-xs bg-rose-100 text-rose-700 ml-1">Populer</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex justify-end gap-3 text-xs">
                                    <a href="{{ route('packages.show', $package) }}" target="_blank" class="text-blush-500 hover:text-blush-700">Lihat</a>
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="text-rose-500 hover:text-rose-600">Edit</a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Hapus paket {{ $package->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-blush-400">Belum ada paket wedding.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
