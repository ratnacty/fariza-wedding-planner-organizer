<x-public-layout>
    @if(session('booking_success'))
        <div class="max-w-3xl mx-auto mt-4 px-4">
            <div class="rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 text-center">
                {{ session('booking_success') }}
            </div>
        </div>
    @endif

    @include('public.partials._hero')
    @include('public.partials._about')
    @include('public.partials._services')
    @include('public.partials._packages')
    @include('public.partials._gallery')
    @include('public.partials._booking')
</x-public-layout>
