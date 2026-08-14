<section id="tentang" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16 scroll-mt-24">
    <div class="grid lg:grid-cols-2 gap-10 items-center">
        <div class="order-2 lg:order-1 reveal">
            <span class="section-eyebrow">{{ $about->eyebrow ?? 'Tentang Kami' }}</span>
            <h2 class="section-title">{{ $about->title ?? 'Fariza Wedding Organizer' }}</h2>
            <p class="mt-5 text-blush-700/90 leading-relaxed">
                {{ $about->description ?? 'Kami berfokus pada pelayanan wedding organizer dan makeup artist profesional dengan konsep elegan, modern, dan penuh makna. Setiap detail kami rancang untuk hari bahagia Anda.' }}
            </p>
            <a href="{{ route('packages.index') }}" class="btn-primary mt-7">Selengkapnya</a>
        </div>
        <div class="order-1 lg:order-2 relative rounded-[2.5rem] overflow-hidden aspect-[16/10] shadow-soft reveal group/about" style="--reveal-delay:.15s">
            <x-photo-placeholder color="blush" class="w-full h-full transition-transform duration-500 group-hover/about:scale-105" label="Prosesi Sakral" :src="$about?->imageUrl()" />
        </div>
    </div>
</section>
