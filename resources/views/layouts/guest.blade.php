<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIMPEK') }} - Autentikasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .guest-mesh {
                background-color: #f8fafc;
                background-image: 
                    radial-gradient(at 10% 10%, rgba(20, 184, 166, 0.12) 0px, transparent 55%),
                    radial-gradient(at 90% 20%, rgba(13, 148, 136, 0.10) 0px, transparent 50%),
                    radial-gradient(at 50% 90%, rgba(45, 212, 191, 0.08) 0px, transparent 60%);
            }
        </style>
    </head>
    <body class="font-sans text-slate-800 antialiased guest-mesh min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 selection:bg-teal-500 selection:text-white">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-teal-600 to-teal-800 text-white flex items-center justify-center font-bold text-xl shadow-md shadow-teal-700/20 group-hover:scale-105 transition-transform">
                    ⚖️
                </div>
                <div class="text-left">
                    <div class="text-2xl font-black tracking-tight text-slate-900 group-hover:text-teal-700 transition-colors">SIMPEK</div>
                    <div class="text-[10px] font-bold text-teal-700 tracking-wider uppercase">Hak Ketenagakerjaan RI</div>
                </div>
            </a>
        </div>

        <div class="w-full sm:max-w-md bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl border border-teal-100/80 p-6 sm:p-8">
            {{ $slot }}
        </div>

        <div class="mt-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} SIMPEK &bull; Sesuai UU No. 6/2023 &amp; PP No. 35/2021
        </div>
    </body>
</html>
