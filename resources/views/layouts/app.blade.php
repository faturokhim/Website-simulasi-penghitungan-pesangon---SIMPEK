<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'SIMPEK')) &mdash; Kalkulator Hak Pesangon &amp; PHK</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="flex min-h-full flex-col font-sans text-slate-800 selection:bg-primary-100 selection:text-primary-900">
        @php
            $withSidebar = request()->routeIs('admin.*');
        @endphp

        <x-app-navbar :sidebar="$withSidebar" />

        @hasSection('header')
            <header class="border-b border-slate-200 bg-surface">
                <div class="page-container py-5">
                    @yield('header')
                </div>
            </header>
        @endif

        <div class="flex flex-1 items-stretch">
            @if ($withSidebar)
                <x-sidebar />
            @endif

            <main id="content" class="min-w-0 flex-1 py-6 sm:py-8">
                <div class="page-container">
                    @if (session('success'))
                        <div class="mb-6">
                            <x-alert type="success" :dismissible="true">{{ session('success') }}</x-alert>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6">
                            <x-alert type="error" :dismissible="true">{{ session('error') }}</x-alert>
                        </div>
                    @endif

                    @hasSection('breadcrumb')
                        <div class="mb-4">
                            @yield('breadcrumb')
                        </div>
                    @endif

                    @yield('content')
                    {{ $slot ?? '' }}
                </div>
            </main>
        </div>

        <footer class="border-t border-slate-200 bg-surface py-6">
            <div class="page-container flex flex-col items-center justify-between gap-2 text-xs text-slate-500 sm:flex-row">
                <span>SIMPEK &copy; {{ date('Y') }}</span>
                <span>Sesuai UU No. 6 Tahun 2023 &amp; PP No. 35 Tahun 2021</span>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
