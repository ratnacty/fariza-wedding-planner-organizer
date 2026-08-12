<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-xl text-blush-900">Layanan</h2>
            <a href="{{ route('admin.services.create') }}" class="btn-primary text-sm !px-4 !py-2">+ Tambah Layanan</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-blush-500 border-b border-blush-100">
                        <th class="py-3 px-4">Foto</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Urutan</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="border-b border-blush-50">
                            <td class="py-3 px-4">
                                <div class="w-14 h-14 rounded-lg overflow-hidden">
                                    <x-photo-placeholder color="rose" :src="$service->imageUrl()" class="w-full h-full" />
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-blush-900">{{ $service->name }}</div>
                                <div class="text-xs text-blush-500 line-clamp-1">{{ $service->description }}</div>
                            </td>
                            <td class="py-3 px-4">{{ $service->order }}</td>
                            <td class="py-3 px-4">
                                @if($service->is_active)
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex justify-end gap-3 text-xs">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-rose-500 hover:text-rose-600">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus layanan {{ $service->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-blush-400">Belum ada layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
