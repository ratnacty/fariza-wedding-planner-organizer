<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-serif text-xl text-blush-900">Admin</h2>
            <a href="{{ route('admin.users.create') }}" class="btn-primary text-sm !px-4 !py-2">+ Tambah Admin</a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase text-blush-500 border-b border-blush-100">
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Bergabung</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-blush-50">
                            <td class="py-3 px-4">
                                <div class="font-medium text-blush-900">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-rose-500">(Anda)</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-blush-700">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-blush-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex justify-end gap-3 text-xs">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-rose-500 hover:text-rose-600">Edit</a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus admin {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-blush-400">Belum ada admin.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
