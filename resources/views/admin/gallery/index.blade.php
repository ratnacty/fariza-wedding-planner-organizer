<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-xl text-blush-900">Galeri</h2>
            <a href="{{ route('admin.gallery.create') }}" class="btn-primary text-sm !px-4 !py-2">+ Tambah Foto</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($galleries as $item)
                <div class="card overflow-hidden">
                    <div class="aspect-square">
                        <x-photo-placeholder :color="$item->cover_color" :src="$item->imageUrl()" class="w-full h-full" />
                    </div>
                    <div class="p-4">
                        <p class="font-medium text-blush-900 text-sm">{{ $item->title ?: '(Tanpa judul)' }}</p>
                        <p class="text-xs text-blush-500 mt-0.5">
                            {{ $item->category ?: 'Umum' }}
                            @if($item->package) &middot; Paket {{ $item->package->name }} @endif
                        </p>
                        <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-blush-400 col-span-full text-center py-10">Belum ada foto galeri.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
