<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SIMPEK - {{ config('app.name', 'Kalkulator Hak Pesangon & PHK') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-full flex flex-col selection:bg-teal-500 selection:text-white">
        <div class="min-h-screen flex flex-col flex-1">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white/70 backdrop-blur-sm border-b border-slate-200/80">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <main class="flex-1 max-w-7xl w-full mx-auto py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-6 flex items-start gap-3 p-4 bg-teal-50 border border-teal-200/80 rounded-2xl text-teal-900 shadow-sm" role="alert">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-teal-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
                        <div class="flex-1 text-sm font-medium">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 flex items-start gap-3 p-4 bg-rose-50 border border-rose-200/80 rounded-2xl text-rose-900 shadow-sm" role="alert">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs font-bold">!</span>
                        <div class="flex-1 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <footer class="mt-auto border-t border-slate-200/80 bg-white/70 py-6 text-center text-xs text-slate-500">
                <div class="max-w-7xl mx-auto px-4">
                    SIMPEK &copy; {{ date('Y') }} &bull; Sistem Informasi Penghitungan Kompensasi PHK Ketenagakerjaan sesuai PP No. 35/2021 & UU No. 6/2023.
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>