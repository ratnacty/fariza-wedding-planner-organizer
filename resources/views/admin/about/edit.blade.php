<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-xl text-blush-900">Tentang Kami</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card p-6">
            <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 mb-5">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="text-xs font-medium text-blush-600">Foto Section</label>
                    @if($about->imageUrl())
                        <div class="mt-2 w-full max-w-sm aspect-[16/10] rounded-lg overflow-hidden border border-blush-100">
                            <img src="{{ $about->imageUrl() }}" alt="{{ $about->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="mt-2 w-full text-sm text-blush-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
                    <p class="text-xs text-blush-400 mt-1">JPG/PNG/WEBP, maksimal 2MB. Kosongkan jika tidak ingin mengganti foto.</p>
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Eyebrow (teks kecil di atas judul)</label>
                    <input type="text" name="eyebrow" value="{{ old('eyebrow', $about->eyebrow) }}" placeholder="contoh: Tentang Kami" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $about->title) }}" required class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
                </div>

                <div class="mt-5">
                    <label class="text-xs font-medium text-blush-600">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">{{ old('description', $about->description) }}</textarea>
                </div>

                <div class="mt-8">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
