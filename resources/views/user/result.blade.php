@extends('layouts.app')

@section('header')
    <x-page-header eyebrow="Dokumen Hasil Perhitungan Resmi" title="Rincian Hak Kompensasi PHK">
        <x-slot name="actions">
            @if ($calculation->status === 'FINAL')
                <x-badge variant="success" icon="check-circle">{{ str_replace('_', ' ', $calculation->status) }}</x-badge>
            @elseif ($calculation->status === 'DIVERIFIKASI')
                <x-badge variant="primary" icon="badge-check">{{ str_replace('_', ' ', $calculation->status) }}</x-badge>
            @elseif ($calculation->status === 'MENUNGGU_VERIFIKASI')
                <x-badge variant="warning" icon="clock">{{ str_replace('_', ' ', $calculation->status) }}</x-badge>
            @else
                <x-badge variant="neutral">{{ str_replace('_', ' ', $calculation->status) }}</x-badge>
            @endif
            <x-button href="{{ route('user.result.pdf', $calculation->id) }}" variant="primary" size="sm" icon="file-down">
                Unduh Dokumen PDF
            </x-button>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Hero Total Compensation Card (Clearwave Style) -->
    <div class="bg-slate-900 rounded-card p-8 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-6 -bottom-10 opacity-10 text-white text-9xl font-black select-none pointer-events-none">
            Rp
        </div>
        <div class="relative z-10 text-center space-y-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-white/10 text-primary-200 border border-white/10">
                Total Kompensasi Pengakhiran Hubungan Kerja
            </span>
            <div class="text-4xl sm:text-6xl font-black tracking-tight text-white py-1">
                Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}
            </div>
            <div class="inline-flex flex-wrap items-center justify-center gap-2 text-xs sm:text-sm text-primary-100/90 font-medium">
                <span class="font-bold text-white">{{ $calculation->employee_name }}</span>
                <span>&bull;</span>
                <span>Masa Kerja: <strong class="text-white">{{ $calculation->work_years }} Tahun {{ $calculation->work_months }} Bulan {{ $calculation->work_days }} Hari</strong></span>
                <span>&bull;</span>
                <span>Dasar Upah: <strong class="text-white">Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }}</strong></span>
            </div>
        </div>
    </div>

    @php
        $calcType = $calculation->calculation_type ?? 'standard_phk';
        $isResignationType = in_array($calcType, ['resignation_type']);
        $isDetainedNoLoss = $calcType === 'detained_no_loss';
        $hideSeverance = $isResignationType || $isDetainedNoLoss;
        $isSicknessDisability = $calcType === 'sickness_disability';
        $isRetirement = $calcType === 'retirement';
        $isDeath = $calcType === 'death';
        $isStandardPhk = !$isResignationType && !$isSicknessDisability && !$isRetirement && !$isDeath;
    @endphp

    <!-- 3 Bento Breakdown Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- 1. Uang Pesangon (UP) -->
        <div class="bg-white rounded-card p-6 border border-primary-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Uang Pesangon (UP)</h3>
                    @if($hideSeverance)
                        <span class="text-xs font-bold bg-slate-100 text-slate-700 px-2 py-0.5 rounded-full border border-slate-300">@if($isDetainedNoLoss) Ps. 54 ayat (2) @else Tidak Berhak @endif</span>
                    @elseif($isSicknessDisability)
                        <span class="text-[10px] font-bold bg-primary-50 text-primary-800 px-2 py-0.5 rounded-full border border-primary-200">Ps. 55 (2.0x)</span>
                    @elseif($isRetirement)
                        <span class="text-[10px] font-bold bg-primary-50 text-primary-800 px-2 py-0.5 rounded-full border border-primary-200">Ps. 56 (1.75x)</span>
                    @elseif($isDeath)
                        <span class="text-[10px] font-bold bg-primary-50 text-primary-800 px-2 py-0.5 rounded-full border border-primary-200">Ps. 57 (2.0x)</span>
                    @else
                        <span class="text-[10px] font-bold bg-primary-50 text-primary-800 px-2 py-0.5 rounded-full border border-primary-200">
                            {{ $calculation->rule ? $calculation->rule->severance_multiplier . 'x' : '1.0x' }}
                        </span>
                    @endif
                </div>

                <div class="space-y-1.5 text-xs text-slate-600">
                    @if(!$hideSeverance)
                        <div class="flex justify-between">
                            <span class="text-slate-400">Standar Bulan:</span>
                            <span class="font-bold text-slate-800">{{ $calculation->base_severance_months }} Bulan Upah</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Faktor Pengali:</span>
                            <span class="font-bold text-primary-800">{{ $calculation->rule ? $calculation->rule->severance_multiplier : '1.0' }}x</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl text-[11px] text-slate-600 font-mono mt-2">
                            Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }} × {{ $calculation->base_severance_months }} bln × {{ $calculation->rule ? $calculation->rule->severance_multiplier : '1.0' }}
                        </div>
                    @elseif($isDetainedNoLoss)
                        <p class="text-slate-600 text-xs italic">Berdasarkan Pasal 54 ayat (2) PP No. 35/2021, tidak ada uang pesangon. Pekerja tetap berhak atas UPMK dan UPH.</p>
                    @else
                        <p class="text-slate-500 text-xs italic">Berdasarkan Pasal 50/51/52 ayat 2 PP No. 35/2021, tidak timbul hak uang pesangon melainkan Uang Pisah.</p>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UP</span>
                <span class="text-2xl font-black text-primary-900">
                    Rp {{ number_format($calculation->user_severance_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- 2. UPMK -->
        <div class="bg-white rounded-card p-6 border border-primary-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Penghargaan Masa Kerja (UPMK)</h3>
                    @if($isResignationType)
                        <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">Tidak Berhak</span>
                    @else
                        <span class="text-[10px] font-bold bg-primary-50 text-primary-800 px-2 py-0.5 rounded-full border border-primary-200">
                            {{ $calculation->rule ? $calculation->rule->upmk_multiplier . 'x' : '1.0x' }}
                        </span>
                    @endif
                </div>

                <div class="space-y-1.5 text-xs text-slate-600">
                    @if(!$isResignationType)
                        <div class="flex justify-between">
                            <span class="text-slate-400">Standar Bulan:</span>
                            <span class="font-bold text-slate-800">{{ $calculation->base_upmk_months }} Bulan Upah</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Faktor Pengali:</span>
                            <span class="font-bold text-primary-800">{{ $calculation->rule ? $calculation->rule->upmk_multiplier : '1.0' }}x</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl text-[11px] text-slate-600 font-mono mt-2">
                            Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }} × {{ $calculation->base_upmk_months }} bln × {{ $calculation->rule ? $calculation->rule->upmk_multiplier : '1.0' }}
                        </div>
                    @else
                        <p class="text-slate-500 text-xs italic">Berdasarkan Pasal 50/51/52 ayat 2 PP No. 35/2021, tidak timbul hak UPMK melainkan Uang Pisah.</p>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UPMK</span>
                <span class="text-2xl font-black text-primary-900">
                    Rp {{ number_format($calculation->user_upmk_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- 3. UPH / Uang Pisah -->
        <div class="bg-white rounded-card p-6 border border-primary-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Penggantian Hak (UPH) &amp; Pisah</h3>
                    <span class="text-[10px] font-bold bg-primary-50 text-primary-800 px-2 py-0.5 rounded-full border border-primary-200">Pasal 40 (4)</span>
                </div>

                <div class="space-y-1.5 text-xs text-slate-600">
                    @php
                        $cutiVal = $calculation->wage_basis > 0 && $calculation->cuti_remaining > 0
                            ? round(($calculation->wage_basis / 25) * $calculation->cuti_remaining, 2)
                            : 0;
                    @endphp
                    <div class="flex justify-between">
                        <span class="text-slate-400">Cuti ({{ $calculation->cuti_remaining ?? 0 }} hari):</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($cutiVal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Ongkos Transportasi Pulang:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($calculation->return_cost ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Hak Lainnya (PKB):</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($calculation->other_rights ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @if($calculation->user_separation_money > 0)
                        <div class="flex justify-between pt-1 border-t border-slate-100 text-primary-800">
                            <span class="font-semibold">Uang Pisah:</span>
                            <span class="font-bold">Rp {{ number_format($calculation->user_separation_money, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UPH &amp; Pisah</span>
                <span class="text-2xl font-black text-primary-900">
                    Rp {{ number_format(($calculation->user_uph_amount ?? 0) + ($calculation->user_separation_money ?? 0), 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Data Pekerja & Rincian Komponen Upah -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Identitas Pekerja -->
        <div class="bg-white rounded-card border border-slate-200/80 p-6 space-y-3">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-badge bg-primary-50 text-primary-700"><x-icon name="user" :size="14" /></span>
                Data Pekerja
            </h3>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-slate-100">
                    <tr><td class="py-2.5 text-slate-400 w-2/5">Nama Lengkap</td><td class="py-2.5 font-bold text-slate-900">: {{ $calculation->employee_name }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Nomor NIK / KTP</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->identity_number ?? '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Jabatan / Bagian</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->position ?? '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Periode Bekerja</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->start_date ? \Carbon\Carbon::parse($calculation->start_date)->format('d/m/Y') : '-' }} s/d {{ $calculation->termination_date ? \Carbon\Carbon::parse($calculation->termination_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Total Masa Kerja</td><td class="py-2.5 font-bold text-primary-800">: {{ $calculation->work_years }} Tahun {{ $calculation->work_months }} Bulan {{ $calculation->work_days }} Hari</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Rincian Upah & Penyesuaian -->
        <div class="bg-white rounded-card border border-slate-200/80 p-6 space-y-3">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-badge bg-primary-50 text-primary-700"><x-icon name="briefcase" :size="14" /></span>
                Komponen Upah Bulanan
            </h3>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-slate-100">
                    <tr><td class="py-2.5 text-slate-400 w-1/2">Upah Pokok</td><td class="py-2.5 font-semibold text-slate-800 text-right">Rp {{ number_format($calculation->basic_salary, 0, ',', '.') }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Tunjangan Tetap</td><td class="py-2.5 font-semibold text-slate-800 text-right">Rp {{ number_format($calculation->fixed_allowance, 0, ',', '.') }}</td></tr>
                    @if($calculation->non_fixed_allowance > 0)
                        <tr><td class="py-2.5 text-slate-400">Tunjangan Tidak Tetap</td><td class="py-2.5 text-slate-400 text-right">Rp {{ number_format($calculation->non_fixed_allowance, 0, ',', '.') }} (Diabaikan)</td></tr>
                    @endif
                    <tr class="bg-primary-50/70 font-bold">
                        <td class="py-2.5 px-3 text-primary-900 rounded-l-xl">Dasar Upah Penghitungan</td>
                        <td class="py-2.5 px-3 text-primary-900 text-right rounded-r-xl font-bold">Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-[10px] text-slate-400 italic leading-tight">
                * Merujuk pada Pasal 157 UU No. 6 Tahun 2023 jo. Pasal 40 PP No. 35 Tahun 2021.
            </p>
        </div>
    </div>

    <!-- Rujukan Hukum Resmi -->
    <div class="bg-white rounded-card border border-slate-200/80 p-6 space-y-3">
        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-badge bg-primary-50 text-primary-700"><x-icon name="scale" :size="14" /></span>
            Landasan Yuridis &amp; Keterangan Alasan PHK
        </h3>
        <div class="p-4 bg-slate-50 rounded-card space-y-2 text-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <span class="text-slate-500 font-medium">Alasan Pengakhiran:</span>
                <span class="font-bold text-slate-900 text-sm">{{ $calculation->terminationReason->name ?? '-' }}</span>
            </div>
            @if($calculation->terminationReason && $calculation->terminationReason->legal_basis)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium">Dasar Hukum:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-primary-100 text-primary-900">
                        {{ $calculation->terminationReason->legal_basis }}
                    </span>
                </div>
            @endif
            @if($calculation->terminationReason && $calculation->terminationReason->description)
                <p class="text-slate-600 pt-2 border-t border-slate-200/70 text-[11px] leading-relaxed">
                    {{ $calculation->terminationReason->description }}
                </p>
            @endif
        </div>
    </div>

    <!-- Legal Disclaimer (No AI Slop) -->
    <div class="p-4 bg-amber-50/70 border border-amber-200/80 rounded-card text-[11px] text-amber-900 leading-relaxed">
        <strong>Pemberitahuan:</strong> Hasil kalkulasi ini merupakan simulasi matematis berdasarkan data masukan dan ketentuan peraturan perundang-undangan ketenagakerjaan Republik Indonesia. Apabila terdapat Perjanjian Kerja Bersama (PKB) atau Peraturan Perusahaan (PP) yang mengatur hak lebih baik dari ketentuan normatif undang-undang, maka ketentuan yang lebih menguntungkan pekerja yang berlaku.
    </div>

    <!-- Action Bar -->
    <div class="pt-4 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <x-button href="{{ route('user.result.pdf', $calculation->id) }}" variant="primary" size="md" icon="file-down">
                Unduh Dokumen PDF
            </x-button>

            @if($calculation->status === 'SIMULASI')
                <form action="{{ route('user.result.submit', $calculation->id) }}" method="POST" class="inline">
                    @csrf
                    <x-button type="submit" variant="success" size="md" icon="check-circle">
                        Ajukan Verifikasi ke Admin HR
                    </x-button>
                </form>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <x-button href="{{ route('user.calculator') }}" variant="secondary" size="md" icon="refresh-cw">
                Hitung Ulang
            </x-button>
            <x-button href="{{ route('user.history') }}" variant="ghost" size="md" icon="history">
                Riwayat Simulasi
            </x-button>
        </div>
    </div>
</div>
@endsection