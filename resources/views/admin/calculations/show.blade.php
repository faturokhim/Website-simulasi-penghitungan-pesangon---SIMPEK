@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200/70 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                Penetapan Administratif Admin
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Rincian Perhitungan Hak PHK (Admin)</h1>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider
                @if($calculation->status === 'FINAL') bg-emerald-50 text-emerald-800 border border-emerald-200
                @elseif($calculation->status === 'DIVERIFIKASI') bg-teal-50 text-teal-800 border border-teal-200
                @elseif($calculation->status === 'MENUNGGU_VERIFIKASI') bg-amber-50 text-amber-800 border border-amber-200
                @else bg-slate-100 text-slate-700 border border-slate-200 @endif">
                ● Status: {{ $calculation->status }}
            </span>
            <a href="{{ route('admin.calculations.pdf', $calculation->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh PDF
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Hero Total Card -->
    <div class="bg-gradient-to-br from-teal-900 via-teal-850 to-slate-900 rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-6 -bottom-10 opacity-10 text-white text-9xl font-black select-none pointer-events-none">
            Rp
        </div>
        <div class="relative z-10 text-center space-y-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest bg-white/10 text-teal-200 backdrop-blur-sm border border-white/10">
                Total Kompensasi Akhir (Admin / HR)
            </span>
            <div class="text-4xl sm:text-6xl font-black tracking-tight text-white py-1">
                Rp {{ number_format($calculation->admin_total_amount, 0, ',', '.') }}
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
    @endphp

    <!-- 3 Bento Formula Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- UP -->
        <div class="bg-white rounded-3xl p-6 border border-teal-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Uang Pesangon (UP)</h3>
                    @if($hideSeverance)
                        <span class="text-xs font-bold bg-slate-100 text-slate-700 px-2 py-0.5 rounded-full border border-slate-300">@if($isDetainedNoLoss) Ps. 54 ayat (2) @else Tidak Berhak @endif</span>
                    @else
                        <span class="text-xs font-bold bg-teal-50 text-teal-900 px-2 py-0.5 rounded-full border border-teal-300">
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
                            <span class="text-slate-400">Pengali Regulasi:</span>
                            <span class="font-bold text-teal-800">{{ $calculation->rule ? $calculation->rule->severance_multiplier : '1.0' }}x</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl text-[11px] text-slate-600 font-mono mt-2">
                            Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }} × {{ $calculation->base_severance_months }} × {{ $calculation->rule ? $calculation->rule->severance_multiplier : '1.0' }}
                        </div>
                    @elseif($isDetainedNoLoss)
                        <p class="text-slate-600 text-xs italic">Pasal 54 ayat (2) PP 35/2021: tanpa uang pesangon. Berlaku UPMK 1x dan UPH.</p>
                    @else
                        <p class="text-slate-500 text-xs italic">Sesuai Pasal 50/51/52 PP 35/2021, kompensasi berupa Uang Pisah.</p>
                    @endif
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UP</span>
                <span class="text-2xl font-black text-teal-900">
                    Rp {{ number_format($calculation->admin_severance_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- UPMK -->
        <div class="bg-white rounded-3xl p-6 border border-teal-100 shadow-xs flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Penghargaan Masa Kerja (UPMK)</h3>
                    <span class="text-[10px] font-bold bg-teal-50 text-teal-800 px-2 py-0.5 rounded-full border border-teal-200">
                        {{ $calculation->rule ? $calculation->rule->upmk_multiplier . 'x' : '1.0x' }}
                    </span>
                </div>
                <div class="space-y-1.5 text-xs text-slate-600">
                    @if(!$isResignationType)
                        <div class="flex justify-between">
                            <span class="text-slate-400">Standar Bulan:</span>
                            <span class="font-bold text-slate-800">{{ $calculation->base_upmk_months }} Bulan Upah</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Pengali Regulasi:</span>
                            <span class="font-bold text-teal-800">{{ $calculation->rule ? $calculation->rule->upmk_multiplier : '1.0' }}x</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl text-[11px] text-slate-600 font-mono mt-2">
                            Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }} × {{ $calculation->base_upmk_months }} × {{ $calculation->rule ? $calculation->rule->upmk_multiplier : '1.0' }}
                        </div>
                    @else
                        <p class="text-slate-500 text-xs italic">Sesuai Pasal 50/51/52 PP 35/2021, kompensasi berupa Uang Pisah.</p>
                    @endif
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UPMK</span>
                <span class="text-2xl font-black text-teal-900">
                    Rp {{ number_format($calculation->admin_upmk_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- UPH -->
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
                        <span class="text-slate-400">Ongkos Transport Pulang:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($calculation->return_cost ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Hak Lainnya (PKB):</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($calculation->other_rights ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @if($calculation->admin_separation_money > 0)
                        <div class="flex justify-between pt-1 border-t border-slate-100 text-teal-800">
                            <span class="font-semibold">Uang Pisah:</span>
                            <span class="font-extrabold">Rp {{ number_format($calculation->admin_separation_money, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-[10px] uppercase font-bold text-slate-400 block">Subtotal UPH &amp; Pisah</span>
                <span class="text-2xl font-black text-teal-900">
                    Rp {{ number_format(($calculation->admin_uph_amount ?? 0) + ($calculation->admin_separation_money ?? 0), 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Data Pekerja & Upah -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 space-y-3">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs">👤</span>
                Data Pekerja &amp; Masa Kerja
            </h3>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-slate-100">
                    <tr><td class="py-2.5 text-slate-400 w-2/5">Nama Lengkap</td><td class="py-2.5 font-bold text-slate-900">: {{ $calculation->employee_name }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Nomor NIK / KTP</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->identity_number ?? '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Jabatan / Posisi</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->position ?? '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Mulai Bekerja</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->start_date ? \Carbon\Carbon::parse($calculation->start_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Tanggal PHK</td><td class="py-2.5 font-medium text-slate-800">: {{ $calculation->termination_date ? \Carbon\Carbon::parse($calculation->termination_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td class="py-2.5 text-slate-400">Total Masa Kerja</td><td class="py-2.5 font-extrabold text-teal-800">: {{ $calculation->work_years }} Tahun {{ $calculation->work_months }} Bulan {{ $calculation->work_days }} Hari</td></tr>
                </tbody>
            </table>
        </div>

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
            <p class="text-[10px] text-slate-400 italic">
                * Merujuk pada Pasal 157 UU No. 6 Tahun 2023 jo. Pasal 40 PP No. 35 Tahun 2021.
            </p>
        </div>
    </div>

    <!-- Dasar Hukum & Alasan PHK -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 space-y-3">
        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
            <span class="w-6 h-6 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xs">⚖️</span>
            Dasar Peraturan &amp; Rujukan Hukum
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

    <!-- Legal Disclaimer -->
    <div class="p-4 bg-amber-50/70 border border-amber-200/80 rounded-2xl text-[11px] text-amber-900 leading-relaxed">
        <strong>Pemberitahuan Audit:</strong> Perhitungan administratif ini disusun berdasarkan data masukan resmi dan ketentuan peraturan perundang-undangan ketenagakerjaan Republik Indonesia.
    </div>

    <!-- Tombol Aksi Lengkap -->
    <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-200">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.calculations.pdf', $calculation->id) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold text-xs rounded-xl shadow-md transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh PDF
            </a>
            <a href="{{ route('admin.verifications.show', $calculation->id) }}" class="inline-flex items-center px-5 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-md transition">
                Verifikasi Data
            </a>
            <a href="{{ route('admin.verifications.compare', $calculation->id) }}" class="inline-flex items-center px-5 py-3 bg-teal-800 hover:bg-teal-900 text-white font-bold text-xs rounded-xl shadow-md transition">
                Bandingkan User vs Admin
            </a>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.calculator') }}" class="px-5 py-3 border border-slate-300 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100 transition">
                + Hitung Baru
            </a>
            <a href="{{ route('admin.calculations.index') }}" class="px-4 py-3 text-slate-500 hover:text-slate-800 text-xs font-semibold">
                Daftar Penghitungan
            </a>
        </div>
    </div>
</div>
@endsection
