<section id="galeri" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-4">
    <div class="text-center mb-10">
        <div class="floral-divider">
            <span class="uppercase tracking-[0.25em] text-xs font-semibold text-rose-500">Galeri</span>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
        @foreach($galleries as $item)
            <a href="{{ route('gallery.index') }}" class="aspect-square rounded-xl overflow-hidden block group">
                <x-photo-placeholder :color="$loop->even ? 'rose' : 'blush'" :src="$item->imageUrl()" class="w-full h-full group-hover:scale-105 transition duration-500" />
            </a>
        @endforeach
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('gallery.index') }}" class="btn-outline">Lihat Semua Galeri</a>
    </div>
</section>
