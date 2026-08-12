<section class="relative overflow-hidden" x-data="heroSlider({{ $slides->count() ?: 1 }})">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 pt-10 pb-16 md:pt-16 md:pb-24">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="relative min-h-[220px]">
                @forelse($slides as $i => $slide)
                    <div x-show="index === {{ $i }}" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                        <span class="section-eyebrow">{{ $slide->eyebrow }}</span>
                        <h1 class="font-serif text-4xl md:text-5xl lg:text-[3.3rem] leading-tight text-blush-900 mt-3">
                            {{ $slide->title }}
                        </h1>
                        <p class="mt-5 text-blush-700/90 text-base md:text-lg max-w-md leading-relaxed">
                            {{ $slide->subtitle }}
                        </p>
                    </div>
                @empty
                    <h1 class="font-serif text-4xl md:text-5xl text-blush-900">Wujudkan Pernikahan Impian Anda</h1>
                @endforelse

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#booking" class="btn-primary">Booking Survei</a>
                    <a href="{{ route('packages.index') }}" class="btn-outline">Lihat Paket</a>
                </div>
            </div>

            <div class="relative">
                <div class="relative rounded-[2.5rem] overflow-hidden aspect-[4/3] shadow-soft">
                    @forelse($slides as $i => $slide)
                        <div x-show="index === {{ $i }}" x-transition:enter="transition ease-in-out duration-700" x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100" class="absolute inset-0" x-cloak>
                            <x-photo-placeholder :color="$slide->cover_color" :src="$slide->imageUrl()" class="w-full h-full" />
                        </div>
                    @empty
                        <x-photo-placeholder color="rose" class="w-full h-full" />
                    @endforelse
                </div>

                @if($slides->count() > 1)
                    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
                        @foreach($slides as $i => $slide)
                            <button @click="goTo({{ $i }})" :class="index === {{ $i }} ? 'w-6 bg-white' : 'w-2 bg-white/60'" class="h-2 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
