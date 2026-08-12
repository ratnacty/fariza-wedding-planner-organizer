<x-public-layout :title="'Galeri - Fariza Wedding Organizer'">
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16">
        <div class="text-center mb-12">
            <span class="section-eyebrow justify-center">Galeri</span>
            <h1 class="section-title">Momen &amp; Karya Kami</h1>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galleries as $item)
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <x-photo-placeholder :color="$loop->even ? 'rose' : 'blush'" :src="$item->imageUrl()" :label="$item->title" class="w-full h-full group-hover:scale-105 transition duration-500" />
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $galleries->links() }}
        </div>
    </section>
</x-public-layout>
