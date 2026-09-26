@extends('layouts.app')

@section('header')
    <div>
        <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Selisih user vs admin</p>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Perbandingan Hasil</h1>
        <p class="text-sm text-slate-600 mt-0.5">{{ $calculation->employee_name }} &bull; Kolom selisih memakai nilai mutlak.</p>
    </div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-5">
    <div class="table-shell">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="font-bold text-slate-900">Perbandingan hitungan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="table-head text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Komponen</th>
                        <th class="px-6 py-3 text-right">User</th>
                        <th class="px-6 py-3 text-right">Admin</th>
                        <th class="px-6 py-3 text-right">Selisih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-teal-50/50">
                        <td class="px-6 py-4 font-semibold text-slate-900">Uang Pesangon</td>
                        <td class="px-6 py-4 text-right tabular text-slate-800">Rp {{ number_format($calculation->user_severance_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right tabular text-slate-800">Rp {{ number_format($calculation->admin_severance_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right tabular font-bold text-slate-900">
                            Rp {{ number_format(abs($calculation->admin_severance_amount - $calculation->user_severance_amount), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="hover:bg-teal-50/50">
                        <td class="px-6 py-4 font-semibold text-slate-900">UPMK</td>
                        <td class="px-6 py-4 text-right tabular text-slate-800">Rp {{ number_format($calculation->user_upmk_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right tabular text-slate-800">Rp {{ number_format($calculation->admin_upmk_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right tabular font-bold text-slate-900">
                            Rp {{ number_format(abs($calculation->admin_upmk_amount - $calculation->user_upmk_amount), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="hover:bg-teal-50/50">
                        <td class="px-6 py-4 font-semibold text-slate-900">UPH</td>
                        <td class="px-6 py-4 text-right tabular text-slate-800">Rp {{ number_format($calculation->user_uph_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right tabular text-slate-800">Rp {{ number_format($calculation->admin_uph_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right tabular font-bold text-slate-900">
                            Rp {{ number_format(abs($calculation->admin_uph_amount - $calculation->user_uph_amount), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-teal-50/70">
                        <td class="px-6 py-4 font-extrabold text-slate-900">Total</td>
                        <td class="px-6 py-4 text-right font-extrabold tabular text-slate-900">Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-extrabold tabular text-teal-900">Rp {{ number_format($calculation->admin_total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-extrabold tabular text-amber-900">
                            Rp {{ number_format(abs($calculation->admin_total_amount - $calculation->user_total_amount), 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.verifications.index') }}" class="px-5 py-2.5 border border-slate-300 text-slate-800 text-sm font-bold rounded-xl hover:bg-slate-100 transition">Kembali</a>
        <a href="{{ route('user.result', $calculation->id) }}" class="px-5 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl transition">Lihat Detail User</a>
    </div>
</div>
@endsection
