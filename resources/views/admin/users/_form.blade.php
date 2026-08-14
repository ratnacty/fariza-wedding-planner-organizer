@csrf
@if(isset($editedUser)) @method('PUT') @endif

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
    <label class="text-xs font-medium text-blush-600">Nama</label>
    <input type="text" name="name" value="{{ old('name', $editedUser->name ?? '') }}" required class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
</div>

<div class="mt-5">
    <label class="text-xs font-medium text-blush-600">Email</label>
    <input type="email" name="email" value="{{ old('email', $editedUser->email ?? '') }}" required class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">
    <div>
        <label class="text-xs font-medium text-blush-600">Password</label>
        <input type="password" name="password" {{ isset($editedUser) ? '' : 'required' }} class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
        <p class="text-xs text-blush-400 mt-1">Minimal 8 karakter. {{ isset($editedUser) ? 'Kosongkan jika tidak ingin mengganti password.' : '' }}</p>
    </div>
    <div>
        <label class="text-xs font-medium text-blush-600">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" {{ isset($editedUser) ? '' : 'required' }} class="mt-1 w-full rounded-lg border-blush-200 focus:border-rose-400 focus:ring-rose-300 text-sm">
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="btn-primary">{{ isset($editedUser) ? 'Simpan Perubahan' : 'Tambah Admin' }}</button>
    <a href="{{ route('admin.users.index') }}" class="btn-outline">Batal</a>
</div>
