@csrf
@if(isset($slide)) @method('PUT') @endif

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
    <label class="text-xs font-medium text-blush-600">Foto Slide</label>
    @if(isset($slide) && $slide->imageUrl())
        <div class="mt-2 w-full max-w-sm aspect-[4/3] rounded-lg overflow-hidden border border-blush-100">
            <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
        </div>
    @endif
    <input type="file" name="image" accept="image/*" class="mt-2 w-full text-sm text-blush-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-50 file:text-rose-600 hover:file:bg-rose-100">
    <p class="text-xs text-blush-400 mt-1">JPG/PNG/WEBP, maksimal 2MB. {{ isset($slide) ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}</p>
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Eyebrow (teks kecil di atas judul)</label>
        <input type="text" name="eyebrow" value="{{ old('eyebrow', $slide->eyebrow ?? '') }}" placeholder="contoh: Wujudkan" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Warna Cover</label>
        <select name="cover_color" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
            <option value="rose" {{ old('cover_color', $slide->cover_color ?? '') === 'rose' ? 'selected' : '' }}>Rose</option>
            <option value="blush" {{ old('cover_color', $slide->cover_color ?? '') === 'blush' ? 'selected' : '' }}>Blush</option>
        </select>
    </div>
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Judul</label>
    <input type="text" name="title" value="{{ old('title', $slide->title ?? '') }}" required class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Subjudul</label>
    <textarea name="subtitle" rows="3" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">{{ old('subtitle', $slide->subtitle ?? '') }}</textarea>
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Urutan Tampil</label>
        <input type="number" name="order" min="0" value="{{ old('order', $slide->order ?? 0) }}" class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
    <div class="flex items-end">
        <label class="flex items-center gap-2 text-sm text-blush-700 pb-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }} class="rounded border-blush-300 text-rose-500 focus:ring-rose-300">
            Aktif / Tampilkan di beranda
        </label>
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="btn-primary">{{ isset($slide) ? 'Simpan Perubahan' : 'Tambah Slide' }}</button>
    <a href="{{ route('admin.hero-slides.index') }}" class="btn-outline">Batal</a>
</div>
