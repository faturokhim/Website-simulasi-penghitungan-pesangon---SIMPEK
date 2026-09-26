<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'SIMPEK - Kalkulator Hak Pesangon &amp; Kompensasi PHK Resmi')</title>
        <meta name="description" content="@yield('description', 'Sistem Informasi Manajemen Penghitungan Kompensasi PHK Ketenagakerjaan resmi berdasarkan UU No. 6 Tahun 2023 dan PP No. 35 Tahun 2021.')">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body class="flex min-h-full flex-col bg-canvas font-sans text-slate-800 selection:bg-primary-100 selection:text-primary-900">
        <x-public-navbar />

        <main class="flex-1">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <footer id="regulasi" class="border-t border-slate-200 bg-surface py-10">
            <div class="page-container space-y-6 text-xs text-slate-500">
                <div class="flex flex-col items-start justify-between gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-center">
                    <x-brand size="sm" />
                    <p class="sm:text-right">
                        Dasar Regulasi: <strong class="text-slate-700">UU No. 6 Tahun 2023</strong> &amp;
                        <strong class="text-slate-700">PP No. 35 Tahun 2021</strong>
                    </p>
                </div>

                <p class="leading-relaxed text-justify">
                    <strong class="text-slate-700">Pemberitahuan Hukum:</strong>
                    Sistem Informasi Penghitungan Kompensasi Pemutusan Hubungan Kerja (SIMPEK) ini merupakan media simulasi
                    berdasarkan data masukan dan peraturan ketenagakerjaan yang berlaku di Republik Indonesia. Ketentuan
                    spesifik yang diatur dalam Perjanjian Kerja (PK), Peraturan Perusahaan (PP), atau Perjanjian Kerja
                    Bersama (PKB) yang memuat hak lebih tinggi tetap mengikat para pihak.
                </p>

                <p class="text-center text-slate-400">&copy; {{ date('Y') }} SIMPEK. Hak Cipta Dilindungi Undang-Undang.</p>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
