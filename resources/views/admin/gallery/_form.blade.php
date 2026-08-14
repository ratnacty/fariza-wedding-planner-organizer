@csrf
@if(isset($gallery)) @method('PUT') @endif

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
    <label class="text-xs font-medium text-blush-600">Foto</label>
    @if(isset($gallery) && $gallery->imageUrl())
        <div class="mt-2 w-full max-w-sm aspect-square rounded-lg overflow-hidden border border-blush-100">
            <img src="{{ $gallery->imageUrl() }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
        </div>
    @endif
    <input type="file" name="image" accept="image/*" {{ isset($gallery) ? '' : 'required' }} class="mt-2 w-full text-sm text-blush-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
    <p class="text-xs text-blush-400 mt-1">JPG/PNG/WEBP, maksimal 2MB. {{ isset($gallery) ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}</p>
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Judul Foto</label>
    <input type="text" name="title" value="{{ old('title', $gallery->title ?? '') }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $gallery->category ?? '') }}" placeholder="Dekorasi, Pengantin, Venue, dll" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Kaitkan dengan Paket (opsional)</label>
        <select name="package_id" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
            <option value="">- Tidak ada -</option>
            @foreach($packages as $package)
                <option value="{{ $package->id }}" {{ old('package_id', $gallery->package_id ?? '') == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Warna Cover</label>
        <select name="cover_color" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
            <option value="rose" {{ old('cover_color', $gallery->cover_color ?? '') === 'rose' ? 'selected' : '' }}>Rose</option>
            <option value="blush" {{ old('cover_color', $gallery->cover_color ?? '') === 'blush' ? 'selected' : '' }}>Blush</option>
        </select>
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Urutan Tampil</label>
        <input type="number" name="order" min="0" value="{{ old('order', $gallery->order ?? 0) }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="btn-primary">{{ isset($gallery) ? 'Simpan Perubahan' : 'Simpan Foto' }}</button>
    <a href="{{ route('admin.gallery.index') }}" class="btn-outline">Batal</a>
</div>
