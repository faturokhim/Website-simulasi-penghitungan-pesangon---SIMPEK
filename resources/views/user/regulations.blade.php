@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200/70 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                Rujukan Perundang-Undangan Resmi
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Regulasi Ketenagakerjaan &amp; Formula PHK</h1>
        </div>
        <a href="{{ route('user.calculator') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-xs font-bold rounded-xl shadow-sm transition">
            <span class="mr-1.5">🧮</span> Buka Kalkulator
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <!-- Overview Bento Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- UU 6/2023 Card -->
        <div class="bg-white rounded-3xl p-7 border border-teal-100 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-900 border border-teal-200 mb-3">
                    Undang-Undang Republik Indonesia
                </div>
                <h2 class="text-xl font-extrabold text-slate-900 mb-2">UU No. 6 Tahun 2023 (Cipta Kerja)</h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pasal 81 angka 44 menetapkan perubahan atas Pasal 156 UU No. 13/2003 tentang Ketenagakerjaan: mewajibkan pengusaha membayar Uang Pesangon (UP), Uang Penghargaan Masa Kerja (UPMK), dan Uang Penggantian Hak (UPH), serta menetapkan bahwa ketentuan lebih lanjut diatur dalam Peraturan Pemerintah.
                </p>
            </div>
            <div class="p-3 bg-slate-50 rounded-2xl text-[11px] text-slate-600 font-medium">
                Berlaku sejak: <strong>21 Maret 2023</strong> &bull; Status: <strong>Aktif / Berlaku Sah</strong>
            </div>
        </div>

        <!-- PP 35/2021 Card -->
        <div class="bg-white rounded-3xl p-7 border border-teal-100 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-900 border border-teal-200 mb-3">
                    Peraturan Pemerintah
                </div>
                <h2 class="text-xl font-extrabold text-slate-900 mb-2">PP No. 35 Tahun 2021</h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Bab V tentang Pemutusan Hubungan Kerja (Pasal 36 s.d. Pasal 59): memuat tata cara PHK, tabel hak standar masa kerja (Pasal 40), serta matriks faktor pengali kompensasi untuk 23 skenario alasan PHK (Pasal 41 s.d. Pasal 57).
                </p>
            </div>
            <div class="p-3 bg-teal-50/70 rounded-2xl text-[11px] text-teal-900 font-medium">
                Berlaku sejak: <strong>2 Februari 2021</strong> &bull; Status: <strong>Regulasi Operasional Utama</strong>
            </div>
        </div>
    </div>

    <!-- Dua Tabel Standar: UP dan UPMK (Pasal 40) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Standar Pesangon (Pasal 40 ayat 2) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-sm">Standar Uang Pesangon (UP)</h3>
                    <p class="text-[11px] text-slate-500">PP No. 35/2021 Pasal 40 ayat (2)</p>
                </div>
                <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold bg-teal-50 text-teal-800">1 &ndash; 9 Bulan</span>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-100">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-[10px]">
                        <tr>
                            <th class="py-2.5 px-3">Masa Kerja</th>
                            <th class="py-2.5 px-3 text-right">Standar Hak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr><td class="py-2 px-3">Kurang dari 1 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">1 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">1 tahun &ndash; &lt; 2 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">2 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">2 tahun &ndash; &lt; 3 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">3 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">3 tahun &ndash; &lt; 4 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">4 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">4 tahun &ndash; &lt; 5 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">5 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">5 tahun &ndash; &lt; 6 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">6 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">6 tahun &ndash; &lt; 7 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">7 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">7 tahun &ndash; &lt; 8 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">8 bulan upah</td></tr>
                        <tr class="bg-teal-50/50"><td class="py-2 px-3 font-semibold">8 tahun atau lebih</td><td class="py-2 px-3 font-extrabold text-teal-900 text-right">9 bulan upah (Maks)</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Standar UPMK (Pasal 40 ayat 3) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-sm">Penghargaan Masa Kerja (UPMK)</h3>
                    <p class="text-[11px] text-slate-500">PP No. 35/2021 Pasal 40 ayat (3)</p>
                </div>
                <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold bg-teal-50 text-teal-800">2 &ndash; 10 Bulan</span>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-100">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-[10px]">
                        <tr>
                            <th class="py-2.5 px-3">Masa Kerja</th>
                            <th class="py-2.5 px-3 text-right">Standar Hak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr><td class="py-2 px-3">Kurang dari 3 tahun</td><td class="py-2 px-3 text-slate-400 text-right">Tidak berhak</td></tr>
                        <tr><td class="py-2 px-3">3 tahun &ndash; &lt; 6 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">2 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">6 tahun &ndash; &lt; 9 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">3 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">9 tahun &ndash; &lt; 12 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">4 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">12 tahun &ndash; &lt; 15 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">5 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">15 tahun &ndash; &lt; 18 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">6 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">18 tahun &ndash; &lt; 21 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">7 bulan upah</td></tr>
                        <tr><td class="py-2 px-3">21 tahun &ndash; &lt; 24 tahun</td><td class="py-2 px-3 font-bold text-teal-800 text-right">8 bulan upah</td></tr>
                        <tr class="bg-teal-50/50"><td class="py-2 px-3 font-semibold">24 tahun atau lebih</td><td class="py-2 px-3 font-extrabold text-teal-900 text-right">10 bulan upah (Maks)</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabel Lengkap 23 Skenario Alasan PHK -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Daftar Lengkap 23 Skenario Alasan PHK &amp; Aturan Pengali</h3>
                <p class="text-xs text-slate-500 mt-0.5">Sesuai ketentuan Bab V PP No. 35 Tahun 2021</p>
            </div>
            <span class="text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-xl border border-teal-200">
                23 Kasus Terakreditasi
            </span>
        </div>

        <div class="overflow-x-auto">
            @php
                $reasonsList = \App\Models\TerminationReason::with('rules')->where('is_active', true)->get();
            @endphp
            <table class="w-full text-xs text-left border-collapse">
                <thead class="bg-slate-50 text-slate-600 font-bold uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Alasan Pemutusan Hubungan Kerja (PHK)</th>
                        <th class="py-3 px-4">Dasar Hukum</th>
                        <th class="py-3 px-4 text-center">Pengali Pesangon (UP)</th>
                        <th class="py-3 px-4 text-center">Pengali UPMK</th>
                        <th class="py-3 px-4">Kompensasi Lain</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($reasonsList as $r)
                    @php
                        $rule = $r->rules->first();
                        $sevMult = $rule ? (float)$rule->severance_multiplier : 1.0;
                        $upmkMult = $rule ? (float)$rule->upmk_multiplier : 1.0;
                        $isSep = $r->uses_separation_money;
                    @endphp
                    <tr class="hover:bg-teal-50/30">
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-900 block">{{ $r->name }}</span>
                            @if($r->description)
                            <span class="text-[11px] text-slate-500">{{ $r->description }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded font-mono text-[11px] bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $r->legal_basis ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            @if($isSep)
                                <span class="text-slate-400 font-semibold">-</span>
                            @else
                                <span class="font-bold {{ $sevMult >= 1.75 ? 'text-teal-700 text-sm' : ($sevMult < 1.0 ? 'text-amber-700' : 'text-slate-900') }}">
                                    {{ $sevMult }}x
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            @if($isSep)
                                <span class="text-slate-400 font-semibold">-</span>
                            @else
                                <span class="font-bold text-slate-900">{{ $upmkMult }}x</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($isSep)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-800 border border-teal-200">
                                    UPH + Uang Pisah (PKB)
                                </span>
                            @else
                                <span class="text-slate-600">UPH Sesuai Pasal 40 (4)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection