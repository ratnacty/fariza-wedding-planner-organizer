@csrf
@if(isset($service)) @method('PUT') @endif

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
    @if(isset($service) && $service->imageUrl())
        <div class="mt-2 w-32 h-32 rounded-lg overflow-hidden border border-blush-100">
            <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
        </div>
    @endif
    <input type="file" name="image" accept="image/*" class="mt-2 w-full text-sm text-blush-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
    <p class="text-xs text-blush-400 mt-1">JPG/PNG/WEBP, maksimal 2MB. {{ isset($service) ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}</p>
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Nama Layanan</label>
        <input type="text" name="name" value="{{ old('name', $service->name ?? '') }}" required class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Ikon Badge</label>
        <select name="icon" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
            <option value="flower" {{ old('icon', $service->icon ?? '') === 'flower' ? 'selected' : '' }}>Bunga</option>
            <option value="sparkles" {{ old('icon', $service->icon ?? '') === 'sparkles' ? 'selected' : '' }}>Kilau</option>
        </select>
    </div>
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Deskripsi</label>
    <textarea name="description" rows="3" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">{{ old('description', $service->description ?? '') }}</textarea>
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Urutan Tampil</label>
        <input type="number" name="order" min="0" value="{{ old('order', $service->order ?? 0) }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div class="flex items-end">
        <label class="flex items-center gap-2 text-sm text-blush-700 pb-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }} class="rounded border-blush-300 text-rose-500 focus:ring-rose-300">
            Aktif / Tampilkan di beranda
        </label>
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="btn-primary">{{ isset($service) ? 'Simpan Perubahan' : 'Tambah Layanan' }}</button>
    <a href="{{ route('admin.services.index') }}" class="btn-outline">Batal</a>
</div>
