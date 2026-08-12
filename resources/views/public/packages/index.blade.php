<x-public-layout :title="'Paket Wedding - Fariza Wedding Organizer'">
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
        <div class="text-center mb-12">
            <span class="section-eyebrow justify-center">Paket Wedding</span>
            <h1 class="section-title">Pilih Paket Sesuai Impian Anda</h1>
            <p class="mt-4 text-blush-700/80 max-w-xl mx-auto">
                Semua paket dapat disesuaikan dengan kebutuhan dan anggaran Anda. Hubungi kami untuk konsultasi lebih lanjut.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($packages as $package)
                <div class="card overflow-hidden flex flex-col relative {{ $package->is_featured ? 'ring-2 ring-rose-400' : '' }}">
                    @if($package->is_featured)
                        <span class="absolute top-4 right-4 z-10 bg-rose-500 text-white text-[11px] font-semibold uppercase tracking-wide px-3 py-1 rounded-full">Populer</span>
                    @endif
                    <div class="aspect-[4/3]">
                        <x-photo-placeholder :color="$package->cover_color" :src="$package->imageUrl()" class="w-full h-full" />
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="font-serif text-2xl text-blush-900 uppercase tracking-wide text-center">{{ $package->name }}</h3>
                        <p class="mt-1 text-xs text-rose-500 text-center italic">{{ $package->tagline }}</p>

                        @if($package->features)
                            <ul class="mt-4 space-y-2 text-sm text-blush-700 flex-1">
                                @foreach(array_slice($package->features, 0, 4) as $feature)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 mt-0.5 text-rose-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if($package->price)
                            <p class="mt-4 text-rose-600 font-semibold text-center">Mulai Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        @endif

                        <a href="{{ route('packages.show', $package) }}" class="btn-primary mt-4 w-full">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-public-layout>
