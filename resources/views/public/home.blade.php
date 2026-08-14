<x-public-layout>
    <div class="relative overflow-hidden">
        <div class="absolute top-[4%] -left-32 w-[36rem] h-[36rem] bg-rose-300/45 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[15%] -right-28 w-[38rem] h-[38rem] bg-blush-300/40 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[27%] -left-24 w-[34rem] h-[34rem] bg-rose-200/45 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[39%] -right-32 w-[38rem] h-[38rem] bg-blush-200/40 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[51%] -left-28 w-[34rem] h-[34rem] bg-rose-300/40 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[63%] -right-24 w-[36rem] h-[36rem] bg-blush-300/45 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[75%] -left-32 w-[36rem] h-[36rem] bg-rose-200/40 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[87%] -right-28 w-[34rem] h-[34rem] bg-blush-300/45 rounded-full blur-3xl -z-10"></div>
        <div class="absolute top-[97%] -left-24 w-[32rem] h-[32rem] bg-rose-300/40 rounded-full blur-3xl -z-10"></div>

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
