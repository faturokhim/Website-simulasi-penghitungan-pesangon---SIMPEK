@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200/70 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                Dokumen Hasil Perhitungan Resmi
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Rincian Hak Kompensasi PHK</h1>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($calculation->status === 'FINAL') bg-emerald-50 text-emerald-800 border border-emerald-200
                @elseif($calculation->status === 'DIVERIFIKASI') bg-teal-50 text-teal-800 border border-teal-200
                @elseif($calculation->status === 'MENUNGGU_VERIFIKASI') bg-amber-50 text-amber-800 border border-amber-200
                @else bg-slate-100 text-slate-700 border border-slate-200 @endif">
                ● Status: {{ $calculation->status }}
            </span>
            <a href="{{ route('user.result.pdf', $calculation->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Dokumen PDF
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Hero Total Compensation Card (Clearwave Style) -->
    <div class="bg-gradient-to-br from-teal-900 via-teal-850 to-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-6 -bottom-10 opacity-10 text-white text-9xl font-black select-none pointer-events-none">
            Rp
        </div>
        <div class="relative z-10 text-center space-y-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-white/10 text-teal-200 backdrop-blur-sm border border-white/10">
                Total Kompensasi Pengakhiran Hubungan Kerja
            </span>
            <div class="text-4xl sm:text-6xl font-black tracking-tight text-white py-1">
                Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}
            </div>
            <div class="inline-flex flex-wrap items-center justify-center gap-2 text-xs sm:text-sm text-teal-100/90 font-medium">
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
        <div class="bg-white rounded-3xl p-6 border border-teal-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Uang Pesangon (UP)</h3>
                    @if($hideSeverance)
                        <span class="text-xs font-bold bg-slate-100 text-slate-700 px-2 py-0.5 rounded-full border border-slate-300">@if($isDetainedNoLoss) Ps. 54 ayat (2) @else Tidak Berhak @endif</span>
                    @elseif($isSicknessDisability)
                        <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">Ps. 55 (2.0x)</span>
                    @elseif($isRetirement)
                        <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">Ps. 56 (1.75x)</span>
                    @elseif($isDeath)
                        <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">Ps. 57 (2.0x)</span>
                    @else
                        <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">
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
                            <span class="font-bold text-teal-800">{{ $calculation->rule ? $calculation->rule->severance_multiplier : '1.0' }}x</span>
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
                <span class="text-2xl font-black text-teal-900">
                    Rp {{ number_format($calculation->user_severance_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- 2. UPMK -->
        <div class="bg-white rounded-3xl p-6 border border-teal-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Penghargaan Masa Kerja (UPMK)</h3>
                    @if($isResignationType)
                        <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">Tidak Berhak</span>
                    @else
                        <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">
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
                            <span class="font-bold text-teal-800">{{ $calculation->rule ? $calculation->rule->upmk_multiplier : '1.0' }}x</span>
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
                <span class="text-2xl font-black text-teal-900">
                    Rp {{ number_format($calculation->user_upmk_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- 3. UPH / Uang Pisah -->
        <div class="bg-white rounded-3xl p-6 border border-teal-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Penggantian Hak (UPH) &amp; Pisah</h3>
                    <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">Pasal 40 (4)</span>
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
                        <div class="flex justify-between pt-1 border-t border-slate-100 text-teal-800">
                            <span class="font-semibold">Uang Pisah:</span>
                            <span class="font-extrabold">Rp {{ number_format($calculation->user_separation_money, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UPH &amp; Pisah</span>
                <span class="text-2xl font-black text-teal-900">
                    Rp {{ number_format(($calculation->user_uph_amount ?? 0) + ($calculation->user_separation_money ?? 0), 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Data Pekerja & Rincian Komponen Upah -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Identitas Pekerja -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 space-y-3">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs">👤</span>
                Data Pekerja
            </h3>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-slate-100">
                    <tr><td class="py-2.5 text-slate-400 w-2/5">Nama Lengkap</td><td class="py-2.5 font-bold text-slate-900">: {{ $calculation->employee_name }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Nomor NIK / KTP</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->identity_number ?? '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Jabatan / Bagian</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->position ?? '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Periode Bekerja</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->start_date ? \Carbon\Carbon::parse($calculation->start_date)->format('d/m/Y') : '-' }} s/d {{ $calculation->termination_date ? \Carbon\Carbon::parse($calculation->termination_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Total Masa Kerja</td><td class="py-2.5 font-extrabold text-teal-800">: {{ $calculation->work_years }} Tahun {{ $calculation->work_months }} Bulan {{ $calculation->work_days }} Hari</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Rincian Upah & Penyesuaian -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 space-y-3">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs">💼</span>
                Komponen Upah Bulanan
            </h3>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-slate-100">
                    <tr><td class="py-2.5 text-slate-400 w-1/2">Upah Pokok</td><td class="py-2.5 font-semibold text-slate-800 text-right">Rp {{ number_format($calculation->basic_salary, 0, ',', '.') }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Tunjangan Tetap</td><td class="py-2.5 font-semibold text-slate-800 text-right">Rp {{ number_format($calculation->fixed_allowance, 0, ',', '.') }}</td></tr>
                    @if($calculation->non_fixed_allowance > 0)
                        <tr><td class="py-2.5 text-slate-400">Tunjangan Tidak Tetap</td><td class="py-2.5 text-slate-400 text-right">Rp {{ number_format($calculation->non_fixed_allowance, 0, ',', '.') }} (Diabaikan)</td></tr>
                    @endif
                    <tr class="bg-teal-50/70 font-bold">
                        <td class="py-2.5 px-3 text-teal-900 rounded-l-xl">Dasar Upah Penghitungan</td>
                        <td class="py-2.5 px-3 text-teal-900 text-right rounded-r-xl font-extrabold">Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-[10px] text-slate-400 italic leading-tight">
                * Merujuk pada Pasal 157 UU No. 6 Tahun 2023 jo. Pasal 40 PP No. 35 Tahun 2021.
            </p>
        </div>
    </div>

    <!-- Rujukan Hukum Resmi -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 space-y-3">
        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
            <span class="w-6 h-6 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs">⚖️</span>
            Landasan Yuridis &amp; Keterangan Alasan PHK
        </h3>
        <div class="p-4 bg-slate-50 rounded-2xl space-y-2 text-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                <span class="text-slate-500 font-medium">Alasan Pengakhiran:</span>
                <span class="font-extrabold text-slate-900 text-sm">{{ $calculation->terminationReason->name ?? '-' }}</span>
            </div>
            @if($calculation->terminationReason && $calculation->terminationReason->legal_basis)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium">Dasar Hukum:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-teal-100 text-teal-900">
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
    <div class="p-4 bg-amber-50/70 border border-amber-200/80 rounded-2xl text-[11px] text-amber-900 leading-relaxed">
        <strong>Pemberitahuan:</strong> Hasil kalkulasi ini merupakan simulasi matematis berdasarkan data masukan dan ketentuan peraturan perundang-undangan ketenagakerjaan Republik Indonesia. Apabila terdapat Perjanjian Kerja Bersama (PKB) atau Peraturan Perusahaan (PP) yang mengatur hak lebih baik dari ketentuan normatif undang-undang, maka ketentuan yang lebih menguntungkan pekerja yang berlaku.
    </div>

    <!-- Action Bar -->
    <div class="pt-4 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('user.result.pdf', $calculation->id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold text-xs rounded-xl shadow-md transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Dokumen PDF
            </a>

            @if($calculation->status === 'SIMULASI')
                <form action="{{ route('user.result.submit', $calculation->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-5 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-md transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Ajukan Verifikasi ke Admin HR
                    </button>
                </form>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('user.calculator') }}" class="px-5 py-3 border border-slate-300 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100 transition">
                + Hitung Ulang
            </a>
            <a href="{{ route('user.history') }}" class="px-4 py-3 text-slate-500 hover:text-slate-800 text-xs font-semibold">
                Riwayat Simulasi
            </a>
        </div>
    </div>
</div>
@endsection