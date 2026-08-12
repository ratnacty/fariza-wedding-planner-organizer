<x-public-layout :title="$package->name.' - Fariza Wedding Organizer'">
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
        <nav class="text-xs text-blush-500 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-rose-500">Beranda</a>
            <span>/</span>
            <a href="{{ route('packages.index') }}" class="hover:text-rose-500">Paket Wedding</a>
            <span>/</span>
            <span class="text-blush-800">{{ $package->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-10">
            <div class="rounded-[2rem] overflow-hidden aspect-[4/3] shadow-soft">
                <x-photo-placeholder :color="$package->cover_color" :src="$package->imageUrl()" class="w-full h-full" :label="$package->tier" />
            </div>

            <div>
                @if($package->is_featured)
                    <span class="inline-block bg-rose-500 text-white text-[11px] font-semibold uppercase tracking-wide px-3 py-1 rounded-full mb-3">Paling Populer</span>
                @endif
                <h1 class="font-serif text-4xl text-blush-900">{{ $package->name }}</h1>
                <p class="mt-2 text-rose-500 italic">{{ $package->tagline }}</p>
                <p class="mt-5 text-blush-700/90 leading-relaxed">{{ $package->description }}</p>

                @if($package->price)
                    <p class="mt-6 text-2xl font-serif text-rose-600">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                @endif

                @if($package->features)
                    <ul class="mt-6 space-y-3">
                        @foreach($package->features as $feature)
                            <li class="flex items-start gap-3 text-sm text-blush-700">
                                <svg class="w-5 h-5 mt-0.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('home', ['package' => $package->id]) }}#booking" class="btn-primary">Booking Paket Ini</a>
                    <a href="{{ route('packages.index') }}" class="btn-outline">Lihat Paket Lain</a>
                </div>
            </div>
        </div>

        @if($otherPackages->count())
            <div class="mt-20">
                <h2 class="section-title text-center mb-10">Paket Lainnya</h2>
                <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                    @foreach($otherPackages as $other)
                        <div class="card overflow-hidden flex flex-col">
                            <div class="aspect-[4/3]">
                                <x-photo-placeholder :color="$other->cover_color" :src="$other->imageUrl()" class="w-full h-full" />
                            </div>
                            <div class="p-5 text-center">
                                <h3 class="font-serif text-xl text-blush-900 uppercase">{{ $other->name }}</h3>
                                <a href="{{ route('packages.show', $other) }}" class="btn-outline mt-3 w-full">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</x-public-layout>
