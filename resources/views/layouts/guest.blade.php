<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'SIMPEK') &mdash; Autentikasi</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="flex min-h-screen flex-col items-center justify-center bg-canvas p-4 sm:p-6">
        <div class="w-full max-w-md">
            <div class="mb-6 flex justify-center">
                <x-brand size="lg" />
            </div>

            <div class="rounded-card border border-slate-200 bg-surface p-6 shadow-card sm:p-8">
                {{ $slot }}
            </div>

            <p class="mt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} SIMPEK &bull; Sesuai UU No. 6/2023 &amp; PP No. 35/2021
            </p>
        </div>
    </body>
</html>
