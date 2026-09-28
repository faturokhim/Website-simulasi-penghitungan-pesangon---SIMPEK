@extends('layouts.public')

@section('title', 'SIMPEK - Kalkulator Hak Pesangon & Kompensasi PHK Resmi')

@section('content')
@php
    $scenarios = [
        ['Penggabungan, Peleburan, Pemisahan Perusahaan', 'Pasal 41', '1.0x', '1.0x', 'UPH'],
        ['Pengambilalihan (Pengusaha Menolak Menerima)', 'Pasal 42 ayat (1)', '1.0x', '1.0x', 'UPH'],
        ['Pengambilalihan + Perubahan Syarat Kerja (Pekerja Menolak)', 'Pasal 42 ayat (2)', '0.5x', '1.0x', 'UPH'],
        ['Efisiensi Karena Perusahaan Mengalami Kerugian', 'Pasal 43 ayat (1)', '0.5x', '1.0x', 'UPH'],
        ['Efisiensi Untuk Mencegah Terjadinya Kerugian', 'Pasal 43 ayat (2)', '1.0x', '1.0x', 'UPH'],
        ['Perusahaan Tutup Karena Kerugian (2 Tahun)', 'Pasal 44 ayat (1)', '0.5x', '1.0x', 'UPH'],
        ['Perusahaan Tutup Bukan Karena Kerugian', 'Pasal 44 ayat (2)', '1.0x', '1.0x', 'UPH'],
        ['Keadaan Memaksa (Force Majeure) Tutup', 'Pasal 45 ayat (1)', '0.5x', '1.0x', 'UPH'],
        ['Keadaan Memaksa (Force Majeure) Tanpa Tutup', 'Pasal 45 ayat (2)', '0.75x', '1.0x', 'UPH'],
        ['PKPU Karena Perusahaan Rugi', 'Pasal 46 ayat (1)', '0.5x', '1.0x', 'UPH'],
        ['PKPU Bukan Karena Rugi', 'Pasal 46 ayat (2)', '1.0x', '1.0x', 'UPH'],
        ['Perusahaan Pailit', 'Pasal 47', '0.5x', '1.0x', 'UPH via Kurator'],
        ['PHK atas Permintaan Pekerja (Pengusaha Melanggar)', 'Pasal 48', '1.0x', '1.0x', 'UPH'],
        ['Permohonan Pekerja Ditolak PHI', 'Pasal 49', '-', '-', 'UPH + Uang Pisah (PKB)'],
        ['Pengunduran Diri (Resign Sukarela)', 'Pasal 50', '-', '-', 'UPH + Uang Pisah (PKB)'],
        ['Mangkir 5 Hari Berturut-turut', 'Pasal 51', '-', '-', 'UPH + Uang Pisah (PKB)'],
        ['Pelanggaran Disiplin Kerja (SP 1, 2, 3)', 'Pasal 52 ayat (1)', '0.5x', '1.0x', 'UPH'],
        ['Pelanggaran Mendesak / Berat', 'Pasal 52 ayat (2)', '-', '-', 'UPH + Uang Pisah (PKB)'],
        ['Ditahan &gt; 6 Bulan (Rugi Perusahaan)', 'Pasal 54 ayat (1)', '-', '-', 'UPH + Uang Pisah (PKB)'],
        ['Ditahan &gt; 6 Bulan (Tanpa Rugi)', 'Pasal 54 ayat (2)', '-', '1.0x', 'UPH'],
        ['Sakit Berkepanjangan / Cacat (&gt; 12 Bulan)', 'Pasal 55', '2.0x', '1.0x', 'UPH'],
        ['Pekerja Mencapai Usia Pensiun', 'Pasal 56', '1.75x', '1.0x', 'UPH'],
        ['Pekerja Meninggal Dunia', 'Pasal 57', '2.0x', '1.0x', 'UPH untuk Ahli Waris'],
    ];

    $features = [
        [
            'icon' => 'bar-chart-3',
            'title' => 'Matriks Pengali Sesuai PP 35/2021 Pasal 41–57',
            'body' => 'Setiap skenario memiliki faktor pengali tersendiri: 0.5x untuk efisiensi akibat kerugian, 1.0x untuk penggabungan atau efisiensi pencegahan, 0.75x untuk force majeure tanpa tutup, 1.75x untuk usia pensiun, hingga 2.0x untuk sakit berkepanjangan dan meninggal dunia.',
            'span' => 'md:col-span-7',
            'footer' => [
                ['0.5x – 2.0x', 'Rentang Pengali UP'],
                ['1.0x', 'Standar Pengali UPMK'],
                ['1x Gaji', 'Uang Pisah Resign'],
            ],
        ],
        [
            'icon' => 'coins',
            'title' => 'Pemisahan Komponen Upah',
            'body' => 'Mendukung perhitungan dasar upah bulanan (Upah Pokok + Tunjangan Tetap), upah harian (30x harian), serta sistem borongan/satuan hasil (rata-rata 12 bulan terakhir) sesuai Pasal 32–33 PP 35/2021.',
            'span' => 'md:col-span-5',
            'note' => 'Mengabaikan tunjangan tidak tetap secara otomatis sesuai ketentuan UU.',
        ],
        [
            'icon' => 'calendar',
            'title' => 'Uang Penggantian Hak (UPH)',
            'body' => 'Mengakomodasi konversi sisa cuti tahunan yang belum gugur dengan rumus proporsional resmi (Upah / 25) × Hari Cuti, ditambah ongkos kepulangan dan hak lain dalam PK/PP/PKB.',
            'span' => 'md:col-span-5',
            'note' => 'Menjamin tidak ada komponen hak yang terlewat saat terjadi terminasi.',
        ],
        [
            'icon' => 'file-text',
            'title' => 'Laporan Dokumen Resmi Siap Cetak (PDF)',
            'body' => 'Setelah simulasi diselesaikan, dokumen rincian lengkap dapat diunduh langsung dalam format PDF standar audit yang memuat identitas pekerja, masa kerja, uraian dasar upah, rincian matematis per pasal, dan disclaimer yuridis resmi.',
            'span' => 'md:col-span-7',
            'meta' => ['Format kompatibel untuk lampiran bipartit atau audit HR', 'DomPDF Supported'],
        ],
    ];
@endphp

{{-- Hero --}}
<section class="border-b border-slate-200 bg-surface py-14 sm:py-20">
    <div class="page-container">
        <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-12 lg:gap-12">
            <div class="space-y-6 lg:col-span-7">
                <span class="inline-flex items-center gap-2 rounded-badge border border-primary-200 bg-primary-50 px-3 py-1.5 text-xs font-semibold text-primary-900">
                    <x-icon name="shield-check" :size="14" />
                    UU No. 6 Tahun 2023 &bull; PP No. 35 Tahun 2021
                </span>

                <h1 class="text-3xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    Hitung pesangon dan kompensasi PHK
                    <span class="text-primary-700">sesuai aturan Indonesia</span>
                </h1>

                <p class="max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg">
                    Masukkan masa kerja, upah, dan alasan PHK. Sistem menghitung Uang Pesangon (UP),
                    Penghargaan Masa Kerja (UPMK), dan Penggantian Hak (UPH) lengkap dengan pasal acuannya.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <x-button href="{{ route('user.calculator') }}" variant="primary" size="lg" icon="calculator">
                        Mulai Hitung Simulasi
                    </x-button>
                    @guest
                        <x-button href="{{ route('register') }}" variant="secondary" size="lg">
                            Daftar Akun Gratis
                        </x-button>
                    @endguest
                </div>

                <dl class="grid max-w-xl grid-cols-3 gap-4 border-t border-slate-200 pt-5">
                    <div>
                        <dt class="text-xs font-medium text-slate-500">Sesuai PP No. 35/2021</dt>
                        <dd class="mt-1 text-xl font-bold text-primary-800 sm:text-2xl">23 Alasan</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500">Acuan hitung PP 35/2021</dt>
                        <dd class="mt-1 text-xl font-bold text-primary-800 sm:text-2xl">Pasal 40–57</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-slate-500">Laporan Siap Unduh</dt>
                        <dd class="mt-1 text-xl font-bold text-primary-800 sm:text-2xl">Format PDF</dd>
                    </div>
                </dl>
            </div>

            <div class="lg:col-span-5">
                <x-card class="space-y-5">
                    <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-8 w-8 items-center justify-center rounded-badge bg-primary-100 text-primary-700">
                                <x-icon name="clipboard-list" :size="16" />
                            </span>
                            <div>
                                <p class="text-xs font-semibold text-slate-800">Simulasi Rincian Hak PHK</p>
                                <p class="text-[10px] font-medium text-primary-700">PP No. 35/2021 Pasal 43 ayat (1)</p>
                            </div>
                        </div>
                        <x-badge variant="success" icon="check-circle">Simulasi Sah</x-badge>
                    </div>

                    <div class="grid grid-cols-2 gap-3 rounded-input bg-slate-50 p-3.5 text-xs">
                        <div>
                            <span class="block text-[10px] font-semibold uppercase text-slate-400">Masa Kerja</span>
                            <span class="font-semibold text-slate-800">4 Tahun 3 Bulan</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-semibold uppercase text-slate-400">Dasar Upah (Pokok + Tetap)</span>
                            <span class="font-semibold text-primary-800">Rp 6.000.000</span>
                        </div>
                    </div>

                    <ul class="space-y-2.5 text-xs">
                        @foreach ([
                            ['Uang Pesangon (UP)', '5 bulan × 0.5 × Rp 6.000.000', 'Rp 15.000.000'],
                            ['Penghargaan Masa Kerja (UPMK)', '2 bulan × 1.0 × Rp 6.000.000', 'Rp 12.000.000'],
                            ['Penggantian Hak (UPH)', 'Cuti tahunan 5 hari belum gugur', 'Rp 1.200.000'],
                        ] as $line)
                            <li class="flex items-center justify-between gap-3 rounded-input border border-primary-100 bg-primary-50/60 p-2.5">
                                <div>
                                    <span class="block font-semibold text-slate-800">{{ $line[0] }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $line[1] }}</span>
                                </div>
                                <span class="font-bold text-primary-900">{{ $line[2] }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex items-center justify-between gap-3 rounded-card bg-primary-800 p-4 text-white">
                        <div>
                            <span class="block text-[10px] font-semibold uppercase text-primary-200">Total Hak Kompensasi PHK</span>
                            <span class="text-xl font-bold tabular sm:text-2xl">Rp 28.200.000</span>
                        </div>
                        <x-button href="{{ route('user.calculator') }}" variant="secondary" size="sm">Coba Sendiri</x-button>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</section>

{{-- Features --}}
<section id="fitur" class="bg-canvas py-16 sm:py-20">
    <div class="page-container">
        <div class="mb-12 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 rounded-badge border border-primary-200 bg-primary-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary-700">
                Sistem Perhitungan Mandiri
            </span>
            <h2 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Setiap angka ada pasal acuannya
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-slate-600 sm:text-base">
                Masukkan masa kerja, upah, dan alasan PHK. Anda terima rincian UP, UPMK, dan UPH beserta pasal yang dipakai.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-12">
            @foreach ($features as $feature)
                <x-card class="flex flex-col justify-between {{ $feature['span'] }}">
                    <div>
                        <span class="mb-5 flex h-11 w-11 items-center justify-center rounded-badge bg-primary-100 text-primary-700">
                            <x-icon :name="$feature['icon']" :size="22" />
                        </span>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $feature['body'] }}</p>
                    </div>

                    @if (! empty($feature['footer']))
                        <div class="mt-6 grid grid-cols-3 gap-2.5 border-t border-slate-100 pt-4 text-center text-xs">
                            @foreach ($feature['footer'] as $stat)
                                <div class="rounded-input border border-slate-200 bg-slate-50 p-2.5">
                                    <span class="block font-semibold text-primary-800">{{ $stat[0] }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $stat[1] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (! empty($feature['note']))
                        <div class="mt-5 flex items-start gap-2 rounded-input bg-slate-50 p-3 text-xs leading-relaxed text-slate-600">
                            <x-icon name="check" :size="14" class="mt-0.5 shrink-0 text-primary-700" />
                            <span>{{ $feature['note'] }}</span>
                        </div>
                    @endif

                    @if (! empty($feature['meta']))
                        <div class="mt-6 flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 pt-4 text-xs text-slate-500">
                            <span>{{ $feature['meta'][0] }}</span>
                            <span class="inline-flex items-center gap-1.5 font-semibold text-primary-700">
                                <x-icon name="check-circle" :size="14" />
                                {{ $feature['meta'][1] }}
                            </span>
                        </div>
                    @endif
                </x-card>
            @endforeach
        </div>
    </div>
</section>

{{-- 23 scenarios --}}
<section id="skenario" class="border-y border-slate-200 bg-surface py-16 sm:py-20">
    <div class="page-container">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-badge border border-primary-200 bg-primary-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-primary-700">
                    Ringkasan Yuridis
                </span>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Matriks 23 Skenario Alasan PHK PP No. 35 Tahun 2021
                </h2>
                <p class="mt-1 text-sm text-slate-600">
                    Daftar lengkap alasan pengakhiran hubungan kerja beserta ketentuan kelipatan hak kompensasi.
                </p>
            </div>
            <x-button href="{{ route('user.calculator') }}" variant="primary" size="sm" icon="arrow-right" icon-position="right">
                Buka Formulir Hitung
            </x-button>
        </div>

        <x-table min-width="880px">
            <x-table.head>
                <tr>
                    <x-table.th>No</x-table.th>
                    <x-table.th>Alasan Pemutusan Hubungan Kerja (PHK)</x-table.th>
                    <x-table.th>Dasar Hukum</x-table.th>
                    <x-table.th align="center">Pengali Pesangon (UP)</x-table.th>
                    <x-table.th align="center">Pengali UPMK</x-table.th>
                    <x-table.th>Hak Lain</x-table.th>
                </tr>
            </x-table.head>
            <x-table.body>
                @foreach ($scenarios as $index => $scenario)
                    <x-table.row>
                        <x-table.cell class="font-semibold text-slate-400">{{ $index + 1 }}</x-table.cell>
                        <x-table.cell class="font-medium text-slate-800">{!! $scenario[0] !!}</x-table.cell>
                        <x-table.cell>
                            <span class="rounded-badge bg-slate-100 px-2 py-0.5 font-mono text-[11px] text-slate-600">{{ $scenario[1] }}</span>
                        </x-table.cell>
                        <x-table.cell align="center" class="font-semibold {{ $scenario[2] === '-' ? 'text-slate-400' : ($scenario[2] === '0.5x' ? 'text-amber-700' : 'text-primary-800') }}">
                            {{ $scenario[2] }}
                        </x-table.cell>
                        <x-table.cell align="center" class="font-semibold {{ $scenario[3] === '-' ? 'text-slate-400' : 'text-primary-800' }}">
                            {{ $scenario[3] }}
                        </x-table.cell>
                        <x-table.cell class="text-slate-600">{!! $scenario[4] !!}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table.body>
        </x-table>
    </div>
</section>

{{-- CTA --}}
<section class="bg-surface py-16 sm:py-20">
    <div class="page-container">
        <div class="rounded-card bg-primary-800 p-8 sm:p-12">
            <div class="max-w-3xl space-y-4">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-primary-200">
                    <x-icon name="zap" :size="14" />
                    Mulai hitung
                </span>
                <h3 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    Masukkan tanggal kerja dan gaji, terima rinciannya
                </h3>
                <p class="text-sm leading-relaxed text-primary-100 sm:text-base">
                    Hasilnya bisa Anda cetak sebagai PDF atau simpan sebagai riwayat.
                </p>
                <div class="flex flex-wrap gap-3 pt-2">
                    <x-button href="{{ route('user.calculator') }}" variant="secondary" size="lg" icon="calculator">
                        Hitung Sekarang
                    </x-button>
                    @guest
                        <x-button href="{{ route('register') }}" variant="light" size="lg">
                            Daftar Akun Baru
                        </x-button>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
