<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Masuk Admin - Fariza Wedding Organizer</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-blush-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cream-100">
            <a href="{{ route('home') }}" class="flex flex-col items-center leading-none mb-2">
                <span class="font-script text-4xl text-rose-500">Fariza</span>
                <span class="text-[10px] tracking-[0.3em] text-blush-600 uppercase -mt-1">Wedding Organizer</span>
            </a>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-soft overflow-hidden sm:rounded-2xl border border-blush-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
