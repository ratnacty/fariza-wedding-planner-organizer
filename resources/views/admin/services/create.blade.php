<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-xl text-blush-900">Tambah Layanan</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="card p-6">
            <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                @include('admin.services._form')
            </form>
        </div>
    </div>
</x-app-layout>
