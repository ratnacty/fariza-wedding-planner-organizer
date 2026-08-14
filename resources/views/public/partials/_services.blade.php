<section id="layanan" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-4">
    <div class="text-center mb-10 reveal">
        <div class="floral-divider">
            <span class="uppercase tracking-[0.25em] text-xs font-semibold text-rose-500">Layanan Kami</span>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($services as $service)
            <div class="card overflow-hidden flex flex-col sm:flex-row group reveal transition-transform duration-300 hover:-translate-y-1" style="--reveal-delay:{{ $loop->index * 0.1 }}s">
                <div class="sm:w-2/5 aspect-[4/3] sm:aspect-auto overflow-hidden">
                    <x-photo-placeholder :color="$loop->even ? 'blush' : 'rose'" :src="$service->imageUrl()" class="w-full h-full transition-transform duration-500 group-hover:scale-105" />
                </div>
                <div class="p-6 sm:w-3/5 flex flex-col justify-center">
                    <div class="w-11 h-11 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 mb-3 group-hover:bg-rose-100 transition">
                        @if($service->icon === 'sparkles')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l1.8 4.9L19 9.5l-5.2 1.6L12 16l-1.8-4.9L5 9.5l5.2-1.6L12 3Z"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-3-8-5.5-8-10a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 11c0 4.5-4 7-8 10Z"/></svg>
                        @endif
                    </div>
                    <h3 class="font-serif text-xl text-blush-900 uppercase tracking-wide">{{ $service->name }}</h3>
                    <p class="mt-2 text-sm text-blush-700/90 leading-relaxed">{{ $service->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
