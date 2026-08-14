<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-xl text-blush-900">Edit Admin: {{ $editedUser->name }}</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card p-6">
            <form method="POST" action="{{ route('admin.users.update', $editedUser) }}">
                @include('admin.users._form')
            </form>
        </div>
    </div>
</x-app-layout>
