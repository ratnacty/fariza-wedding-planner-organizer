<section id="tentang" class="relative overflow-hidden max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16 scroll-mt-24">
    <div class="absolute top-0 right-0 w-[28rem] h-[28rem] bg-blush-300/50 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-rose-300/45 rounded-full blur-3xl -z-10"></div>

    <div class="grid lg:grid-cols-2 gap-10 items-center">
        <div class="order-2 lg:order-1 reveal">
            <span class="section-eyebrow">{{ $about->eyebrow ?? 'Tentang Kami' }}</span>
            <h2 class="section-title">{{ $about->title ?? 'Fariza Wedding Organizer' }}</h2>
            <p class="mt-5 text-blush-700/90 leading-relaxed">
                {{ $about->description ?? 'Kami berfokus pada pelayanan wedding organizer dan makeup artist profesional dengan konsep elegan, modern, dan penuh makna. Setiap detail kami rancang untuk hari bahagia Anda.' }}
            </p>
            <a href="{{ route('packages.index') }}" class="btn-primary mt-7">Selengkapnya</a>
        </div>
        <div class="order-1 lg:order-2 relative rounded-[2.5rem] overflow-hidden aspect-[16/10] shadow-soft reveal" style="--reveal-delay:.15s">
            <x-photo-placeholder color="blush" class="w-full h-full" label="Prosesi Sakral" :src="$about?->imageUrl()" />
            <div class="absolute inset-0 bg-gradient-to-t from-rose-900/40 via-rose-700/10 to-transparent pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-bl from-blush-400/30 via-transparent to-rose-500/25 mix-blend-multiply pointer-events-none"></div>
        </div>
    </div>
</section>
