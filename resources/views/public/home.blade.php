<x-public-layout>
    <div class="relative" style="background-image:
        radial-gradient(circle at 0% 4%, rgba(238,163,179,0.45) 0%, transparent 32%),
        radial-gradient(circle at 100% 15%, rgba(237,184,163,0.40) 0%, transparent 34%),
        radial-gradient(circle at 0% 27%, rgba(246,205,214,0.45) 0%, transparent 30%),
        radial-gradient(circle at 100% 39%, rgba(245,214,201,0.40) 0%, transparent 34%),
        radial-gradient(circle at 0% 51%, rgba(238,163,179,0.40) 0%, transparent 30%),
        radial-gradient(circle at 100% 63%, rgba(237,184,163,0.45) 0%, transparent 32%),
        radial-gradient(circle at 0% 75%, rgba(246,205,214,0.40) 0%, transparent 32%),
        radial-gradient(circle at 100% 87%, rgba(237,184,163,0.45) 0%, transparent 30%),
        radial-gradient(circle at 0% 97%, rgba(238,163,179,0.40) 0%, transparent 28%);">
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
    </div>
</x-public-layout>
