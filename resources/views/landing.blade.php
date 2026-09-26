/<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPEK - Kalkulator Hak Pesangon & Kompensasi PHK Resmi</title>
    <meta name="description" content="Sistem Informasi Manajemen Penghitungan Kompensasi PHK Ketenagakerjaan resmi berdasarkan UU No. 6 Tahun 2023 dan PP No. 35 Tahun 2021.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .clearwave-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 15% 15%, rgba(20, 184, 166, 0.12) 0px, transparent 55%),
                radial-gradient(at 85% 25%, rgba(13, 148, 136, 0.10) 0px, transparent 50%),
                radial-gradient(at 50% 90%, rgba(45, 212, 191, 0.08) 0px, transparent 60%);
        }
        .bento-card {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .bento-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -8px rgba(15, 118, 110, 0.12);
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-teal-500 selection:text-white">
    <!-- Top Glassmorphism Navigation Bar -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/85 border-b border-teal-100/70 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-teal-600 to-teal-800 text-white flex items-center justify-center text-xl shadow-md shadow-teal-700/20 group-hover:scale-105 transition-transform">
                        ⚖️
                    </div>
                    <div>
                        <div class="text-xl font-extrabold tracking-tight text-slate-900 group-hover:text-teal-700 transition-colors">SIMPEK</div>
                        <div class="text-[10px] font-bold text-teal-700 tracking-wider uppercase">Hak Ketenagakerjaan RI</div>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                    <a href="#fitur" class="hover:text-teal-700 transition-colors">Fitur Sistem</a>
                    <a href="#skenario" class="hover:text-teal-700 transition-colors">23 Alasan PHK</a>
                    <a href="#regulasi" class="hover:text-teal-700 transition-colors">Dasar Hukum</a>
                </nav>

                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200/70 rounded-xl transition">
                                Panel Admin
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200/70 rounded-xl transition">
                                Dashboard Saya
                            </a>
                        @endif
                        <a href="{{ route('user.calculator') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-xs font-bold rounded-xl shadow-sm shadow-teal-900/20 transition">
                            <span class="mr-1.5">🧮</span> Hitung Pesangon
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:text-teal-700 border border-slate-300/80 rounded-xl hover:bg-slate-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 sm:px-5 sm:py-2.5 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm shadow-teal-900/20 transition">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Clearwave Hero Section -->
    <section class="clearwave-mesh pt-12 pb-20 sm:pt-20 sm:pb-28 border-b border-teal-100/60 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Left Column: Copy & Actions -->
                <div class="lg:col-span-7 text-left space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-teal-50 text-teal-900 border border-teal-200/80 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        UU No. 6 Tahun 2023 &bull; PP No. 35 Tahun 2021
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                        Hitung pesangon dan kompensasi PHK <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-700 to-teal-500">sesuai aturan Indonesia</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-700 leading-relaxed max-w-2xl font-normal">
                        Masukkan masa kerja, upah, dan alasan PHK. Sistem menghitung Uang Pesangon (UP), Penghargaan Masa Kerja (UPMK), dan Penggantian Hak (UPH) lengkap dengan pasal acuannya.
                    </p>

                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="{{ route('user.calculator') }}" class="inline-flex items-center justify-center px-7 py-3.5 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold text-sm sm:text-base rounded-2xl shadow-lg shadow-teal-800/25 hover:shadow-xl transition-all">
                            <span class="text-lg mr-2">🧮</span> Mulai Hitung Simulasi
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-white hover:bg-teal-50/50 text-teal-900 font-bold text-sm sm:text-base rounded-2xl border border-teal-200/80 shadow-xs transition-all">
                                Daftar Akun Gratis
                            </a>
                        @endguest
                    </div>

                    <div class="pt-4 grid grid-cols-3 gap-4 border-t border-slate-200/80 max-w-xl">
                        <div>
                            <div class="text-xl sm:text-2xl font-extrabold text-teal-800">23 Alasan</div>
                            <div class="text-xs text-slate-500 font-medium">Sesuai PP No. 35/2021</div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-extrabold text-teal-800">Pasal 40–57</div>
                            <div class="text-xs text-slate-600 font-medium">Acuan hitung PP 35/2021</div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-extrabold text-teal-800">Format PDF</div>
                            <div class="text-xs text-slate-500 font-medium">Laporan Siap Unduh</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Live Simulation Card Mockup -->
                <div class="lg:col-span-5 relative">
                    <!-- Background ambient glow -->
                    <div class="absolute -inset-2 bg-gradient-to-r from-teal-400/20 to-teal-600/20 rounded-3xl blur-2xl -z-10"></div>

                    <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-6 sm:p-7 shadow-xl border border-teal-100 space-y-5">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs">
                                    📋
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Simulasi Rincian Hak PHK</div>
                                    <div class="text-[10px] text-teal-700 font-semibold">PP No. 35/2021 Pasal 43 ayat (1)</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Simulasi Sah
                            </span>
                        </div>

                        <!-- Employee tenure & wage brief -->
                        <div class="grid grid-cols-2 gap-3 p-3.5 bg-slate-50 rounded-2xl text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-semibold">Masa Kerja</span>
                                <span class="font-bold text-slate-800">4 Tahun 3 Bulan</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-semibold">Dasar Upah (Pokok + Tetap)</span>
                                <span class="font-bold text-teal-800">Rp 6.000.000</span>
                            </div>
                        </div>

                        <!-- Calculation breakdown items -->
                        <div class="space-y-2.5 text-xs">
                            <div class="flex items-center justify-between p-2.5 bg-teal-50/50 rounded-xl border border-teal-100/60">
                                <div>
                                    <span class="font-bold text-slate-800 block">Uang Pesangon (UP)</span>
                                    <span class="text-[10px] text-slate-500">5 bulan × 0.5 × Rp 6.000.000</span>
                                </div>
                                <span class="font-extrabold text-teal-900">Rp 15.000.000</span>
                            </div>

                            <div class="flex items-center justify-between p-2.5 bg-teal-50/50 rounded-xl border border-teal-100/60">
                                <div>
                                    <span class="font-bold text-slate-800 block">Penghargaan Masa Kerja (UPMK)</span>
                                    <span class="text-[10px] text-slate-500">2 bulan × 1.0 × Rp 6.000.000</span>
                                </div>
                                <span class="font-extrabold text-teal-900">Rp 12.000.000</span>
                            </div>

                            <div class="flex items-center justify-between p-2.5 bg-teal-50/50 rounded-xl border border-teal-100/60">
                                <div>
                                    <span class="font-bold text-slate-800 block">Penggantian Hak (UPH)</span>
                                    <span class="text-[10px] text-slate-500">Cuti tahunan 5 hari belum gugur</span>
                                </div>
                                <span class="font-extrabold text-teal-900">Rp 1.200.000</span>
                            </div>
                        </div>

                        <!-- Total card -->
                        <div class="p-4 bg-gradient-to-r from-teal-700 to-teal-850 rounded-2xl text-white flex items-center justify-between shadow-md">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-teal-200 block">Total Hak Kompensasi PHK</span>
                                <span class="text-xl sm:text-2xl font-black">Rp 28.200.000</span>
                            </div>
                            <a href="{{ route('user.calculator') }}" class="px-3.5 py-1.5 bg-white text-teal-900 text-xs font-bold rounded-xl hover:bg-teal-50 transition">
                                Coba Sendiri
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Features Section -->
    <section id="fitur" class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200/70">
                    Sistem Perhitungan Mandiri
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">
                    Setiap angka ada pasal acuannya
                </h2>
                <p class="text-slate-700 text-sm sm:text-base mt-3">
                    Masukkan masa kerja, upah, dan alasan PHK. Anda terima rincian UP, UPMK, dan UPH beserta pasal yang dipakai.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Bento 1: Formula Multiplier (Wide) -->
                <div class="md:col-span-7 bento-card bg-gradient-to-br from-teal-50/70 to-slate-50 p-7 rounded-3xl border border-teal-100 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-2xl mb-5 shadow-sm">
                            📊
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Matriks Pengali Sesuai PP 35/2021 Pasal 41–57</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Setiap skenario memiliki faktor pengali tersendiri: 0.5x untuk efisiensi akibat kerugian, 1.0x untuk penggabungan atau efisiensi pencegahan, 0.75x untuk force majeure tanpa tutup, 1.75x untuk usia pensiun, hingga 2.0x untuk sakit berkepanjangan dan meninggal dunia.
                        </p>
                    </div>
                    <div class="grid grid-cols-3 gap-2.5 pt-4 border-t border-teal-100 text-center text-xs">
                        <div class="p-2.5 bg-white rounded-xl border border-teal-100">
                            <span class="block font-bold text-teal-800 text-base">0.5x &ndash; 2.0x</span>
                            <span class="text-[10px] text-slate-500">Rentang Pengali UP</span>
                        </div>
                        <div class="p-2.5 bg-white rounded-xl border border-teal-100">
                            <span class="block font-bold text-teal-800 text-base">1.0x</span>
                            <span class="text-[10px] text-slate-500">Standar Pengali UPMK</span>
                        </div>
                        <div class="p-2.5 bg-white rounded-xl border border-teal-100">
                            <span class="block font-bold text-teal-800 text-base">1x Gaji</span>
                            <span class="text-[10px] text-slate-500">Uang Pisah Resign</span>
                        </div>
                    </div>
                </div>

                <!-- Bento 2: Komponen Upah -->
                <div class="md:col-span-5 bento-card bg-white p-7 rounded-3xl border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-2xl mb-5 shadow-sm">
                            💰
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Pemisahan Komponen Upah</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Mendukung perhitungan dasar upah bulanan (Upah Pokok + Tunjangan Tetap), upah harian (30x harian), serta sistem borongan/satuan hasil (rata-rata 12 bulan terakhir) sesuai Pasal 32–33 PP 35/2021.
                        </p>
                    </div>
                    <div class="mt-4 p-3 bg-slate-50 rounded-2xl text-[11px] text-slate-600 font-medium">
                        ✓ Mengabaikan tunjangan tidak tetap secara otomatis sesuai ketentuan UU.
                    </div>
                </div>

                <!-- Bento 3: UPH & Cuti -->
                <div class="md:col-span-5 bento-card bg-white p-7 rounded-3xl border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-700 text-white flex items-center justify-center text-2xl mb-5 shadow-sm">
                            🏖️
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Uang Penggantian Hak (UPH)</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            Mengakomodasi konversi sisa cuti tahunan yang belum gugur dengan rumus proporsional resmi <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-800 text-xs font-mono">(Upah / 25) × Hari Cuti</code>, ditambah ongkos kepulangan dan hak lain dalam PK/PP/PKB.
                        </p>
                    </div>
                    <div class="mt-4 p-3 bg-teal-50/70 rounded-2xl text-[11px] text-teal-800 font-medium">
                        ✓ Menjamin tidak ada komponen hak yang terlewat saat terjadi terminasi.
                    </div>
                </div>

                <!-- Bento 4: Format PDF Resmi -->
                <div class="md:col-span-7 bento-card bg-gradient-to-br from-slate-900 to-teal-950 text-white p-7 rounded-3xl border border-slate-800 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-500 text-white flex items-center justify-center text-2xl mb-5 shadow-sm">
                            📄
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Laporan Dokumen Resmi Siap Cetak (PDF)</h3>
                        <p class="text-slate-300 text-sm leading-relaxed mb-6">
                            Setelah simulasi diselesaikan, dokumen rincian lengkap dapat diunduh langsung dalam format PDF standar audit yang memuat identitas pekerja, masa kerja, uraian dasar upah, rincian matematis per pasal, dan disclaimer yuridis resmi.
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-700/80">
                        <span class="text-xs text-slate-300">Format kompatibel untuk lampiran bipartit atau audit HR</span>
                        <span class="text-xs font-bold text-teal-300">DomPDF Supported ✓</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table of 23 PHK Scenarios (Clearwave Reference Section) -->
    <section id="skenario" class="py-16 sm:py-20 bg-slate-50 border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200/70">
                        Ringkasan Yuridis
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">
                        Matriks 23 Skenario Alasan PHK PP No. 35 Tahun 2021
                    </h2>
                    <p class="text-slate-600 text-sm mt-1">
                        Daftar lengkap alasan pengakhiran hubungan kerja beserta ketentuan kelipatan hak kompensasi.
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('user.calculator') }}" class="inline-flex items-center px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition">
                        Buka Formulir Hitung →
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100/80 text-slate-700 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                                <th class="py-3.5 px-4">No</th>
                                <th class="py-3.5 px-4">Alasan Pemutusan Hubungan Kerja (PHK)</th>
                                <th class="py-3.5 px-4">Dasar Hukum</th>
                                <th class="py-3.5 px-4 text-center">Pengali Pesangon (UP)</th>
                                <th class="py-3.5 px-4 text-center">Pengali UPMK</th>
                                <th class="py-3.5 px-4">Hak Lain</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">1</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Penggabungan, Peleburan, Pemisahan Perusahaan</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 41</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">2</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pengambilalihan (Pengusaha Menolak Menerima)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 42 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">3</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pengambilalihan + Perubahan Syarat Kerja (Pekerja Menolak)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 42 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">4</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Efisiensi Karena Perusahaan Mengalami Kerugian</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 43 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">5</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Efisiensi Untuk Mencegah Terjadinya Kerugian</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 43 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">6</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Perusahaan Tutup Karena Kerugian (2 Tahun)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 44 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">7</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Perusahaan Tutup Bukan Karena Kerugian</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 44 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">8</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Keadaan Memaksa (Force Majeure) Tutup</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 45 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">9</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Keadaan Memaksa (Force Majeure) Tanpa Tutup</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 45 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-700">0.75x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">10</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">PKPU Karena Perusahaan Rugi</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 46 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">11</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">PKPU Bukan Karena Rugi</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 46 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">12</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Perusahaan Pailit</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 47</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH via Kurator</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">13</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">PHK atas Permintaan Pekerja (Pengusaha Melanggar)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 48</span></td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">14</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Permohonan Pekerja Ditolak PHI</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 49</span></td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 font-bold text-teal-800">UPH + Uang Pisah (PKB)</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">15</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pengunduran Diri (Resign Sukarela)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 50</span></td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 font-bold text-teal-800">UPH + Uang Pisah (PKB)</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">16</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Mangkir 5 Hari Berturut-turut</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 51</span></td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 font-bold text-teal-800">UPH + Uang Pisah (PKB)</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">17</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pelanggaran Disiplin Kerja (SP 1, 2, 3)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 52 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center font-bold text-amber-700">0.5x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">18</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pelanggaran Mendesak / Berat</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 52 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 font-bold text-teal-800">UPH + Uang Pisah (PKB)</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">19</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Ditahan &gt; 6 Bulan (Rugi Perusahaan)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 54 ayat (1)</span></td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 font-bold text-teal-800">UPH + Uang Pisah (PKB)</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">20</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Ditahan &gt; 6 Bulan (Tanpa Rugi)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 54 ayat (2)</span></td>
                                <td class="py-3 px-4 text-center text-slate-400 font-semibold">-</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">21</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Sakit Berkepanjangan / Cacat (&gt; 12 Bulan)</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 55</span></td>
                                <td class="py-3 px-4 text-center font-extrabold text-teal-800">2.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">22</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pekerja Mencapai Usia Pensiun</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 56</span></td>
                                <td class="py-3 px-4 text-center font-extrabold text-teal-800">1.75x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH</td>
                            </tr>
                            <tr class="hover:bg-teal-50/30">
                                <td class="py-3 px-4 font-bold text-slate-400">23</td>
                                <td class="py-3 px-4 font-semibold text-slate-800">Pekerja Meninggal Dunia</td>
                                <td class="py-3 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px]">Pasal 57</span></td>
                                <td class="py-3 px-4 text-center font-extrabold text-teal-800">2.0x</td>
                                <td class="py-3 px-4 text-center font-bold text-teal-800">1.0x</td>
                                <td class="py-3 px-4">UPH untuk Ahli Waris</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Clearwave Call-to-Action Section -->
    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-teal-900 via-teal-850 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-xl relative overflow-hidden">
                <div class="max-w-3xl relative z-10 space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-teal-200">Mulai hitung</span>
                    <h3 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                        Masukkan tanggal kerja dan gaji, terima rinciannya
                    </h3>
                    <p class="text-slate-200 text-sm sm:text-base leading-relaxed">
                        Hasilnya bisa Anda cetak sebagai PDF atau simpan sebagai riwayat.
                    </p>
                    <div class="pt-4 flex flex-wrap gap-3">
                        <a href="{{ route('user.calculator') }}" class="inline-flex items-center px-7 py-3.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold rounded-xl shadow-md transition">
                            <span class="mr-2">🧮</span> Hitung Sekarang
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl border border-white/20 transition">
                                Daftar Akun Baru
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="regulasi" class="bg-slate-900 text-slate-400 py-12 text-xs border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-800 pb-8">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-sm">
                        ⚖️
                    </div>
                    <span class="text-white font-bold text-base">SIMPEK &bull; Hak Ketenagakerjaan</span>
                </div>
                <div class="text-slate-400 text-center sm:text-right">
                    Dasar Regulasi: <strong>UU No. 6 Tahun 2023</strong> &amp; <strong>PP No. 35 Tahun 2021</strong>
                </div>
            </div>

            <div class="text-slate-300 leading-relaxed text-xs text-justify">
                <strong>Pemberitahuan Hukum:</strong> Sistem Informasi Penghitungan Kompensasi Pemutusan Hubungan Kerja (SIMPEK) ini merupakan media simulasi berdasarkan data masukan dan peraturan ketenagakerjaan yang berlaku di Republik Indonesia. Ketentuan spesifik yang diatur dalam Perjanjian Kerja (PK), Peraturan Perusahaan (PP), atau Perjanjian Kerja Bersama (PKB) yang memuat hak lebih tinggi tetap mengikat para pihak.
            </div>

            <div class="text-center text-slate-500 pt-4">
                &copy; {{ date('Y') }} SIMPEK. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>
</body>
</html>