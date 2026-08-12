@csrf
@if(isset($package)) @method('PUT') @endif

@if($errors->any())
    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 mb-5">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid sm:grid-cols-2 gap-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Nama Paket</label>
        <input type="text" name="name" value="{{ old('name', $package->name ?? '') }}" required class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Tier (contoh: Silver / Gold / Platinum)</label>
        <input type="text" name="tier" value="{{ old('tier', $package->tier ?? '') }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Foto Cover</label>
    @if(isset($package) && $package->imageUrl())
        <div class="mt-2 w-32 h-32 rounded-lg overflow-hidden border border-blush-100">
            <img src="{{ $package->imageUrl() }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
        </div>
    @endif
    <input type="file" name="image" accept="image/*" class="mt-2 w-full text-sm text-blush-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
    <p class="text-xs text-blush-400 mt-1">JPG/PNG/WEBP, maksimal 2MB. {{ isset($package) ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}</p>
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Tagline</label>
    <input type="text" name="tagline" value="{{ old('tagline', $package->tagline ?? '') }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Deskripsi</label>
    <textarea name="description" rows="3" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">{{ old('description', $package->description ?? '') }}</textarea>
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Fitur / Fasilitas (satu baris = satu fitur)</label>
    <textarea name="features" rows="5" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">{{ old('features', isset($package) ? implode("\n", $package->features ?? []) : '') }}</textarea>
</div>

<div class="grid sm:grid-cols-3 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Harga (Rp)</label>
        <input type="number" name="price" min="0" value="{{ old('price', $package->price ?? '') }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Warna Cover</label>
        <select name="cover_color" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
            <option value="rose" {{ old('cover_color', $package->cover_color ?? '') === 'rose' ? 'selected' : '' }}>Rose</option>
            <option value="blush" {{ old('cover_color', $package->cover_color ?? '') === 'blush' ? 'selected' : '' }}>Blush</option>
        </select>
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Urutan Tampil</label>
        <input type="number" name="order" min="0" value="{{ old('order', $package->order ?? 0) }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
</div>

<div class="flex gap-6 mt-5">
    <label class="flex items-center gap-2 text-sm text-blush-700">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }} class="rounded border-blush-300 text-rose-500 focus:ring-rose-300">
        Tandai sebagai Populer
    </label>
    <label class="flex items-center gap-2 text-sm text-blush-700">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }} class="rounded border-blush-300 text-rose-500 focus:ring-rose-300">
        Aktif / Tampilkan di situs
    </label>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="btn-primary">{{ isset($package) ? 'Simpan Perubahan' : 'Tambah Paket' }}</button>
    <a href="{{ route('admin.packages.index') }}" class="btn-outline">Batal</a>
</div>
