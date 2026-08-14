<section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
    <div class="text-center mb-12 reveal">
        <div class="floral-divider">
            <span class="uppercase tracking-[0.25em] text-xs font-semibold text-rose-500">Paket Wedding</span>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($packages as $package)
            <div class="card overflow-hidden flex flex-col relative reveal group transition-transform duration-300 hover:-translate-y-1.5 {{ $package->is_featured ? 'ring-2 ring-rose-400' : '' }}" style="--reveal-delay:{{ $loop->index * 0.1 }}s">
                @if($package->is_featured)
                    <span class="absolute top-4 right-4 z-10 bg-rose-500 text-white text-[11px] font-semibold uppercase tracking-wide px-3 py-1 rounded-full">Populer</span>
                @endif
                <div class="aspect-[4/3] overflow-hidden">
                    <x-photo-placeholder :color="$package->cover_color" :src="$package->imageUrl()" class="w-full h-full transition-transform duration-500 group-hover:scale-105" />
                </div>
                <div class="p-6 text-center flex flex-col flex-1">
                    <h3 class="font-serif text-2xl text-blush-900 uppercase tracking-wide">{{ $package->name }}</h3>
                    <p class="mt-2 text-sm text-blush-700/80 leading-relaxed flex-1">Paket pernikahan dengan pelayanan lengkap dan berkualitas.</p>
                    @if($package->price)
                        <p class="mt-3 text-rose-600 font-semibold">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                    @endif
                    <a href="{{ route('packages.show', $package) }}" class="btn-outline mt-4 w-full">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('packages.index') }}" class="btn-primary">Lihat Semua Paket</a>
    </div>
</section>
