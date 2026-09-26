@extends('layouts.app')

@section('header')
    <div>
        <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Antrean pemeriksaan</p>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Verifikasi Penghitungan</h1>
        <p class="text-sm text-slate-600 mt-0.5">Pilih data user untuk diperiksa, dibandingkan, dan difinalkan.</p>
    </div>
@endsection

@section('content')
<div class="table-shell">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[720px]">
            <thead class="table-head text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-right">Hasil User</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($calculations as $calc)
                <tr class="hover:bg-teal-50/50">
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $calc->employee_name }}</td>
                    <td class="px-6 py-4 text-slate-700 whitespace-nowrap">{{ $calc->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right font-bold text-slate-900 tabular">Rp {{ number_format($calc->user_total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="badge
                            @if($calc->status === 'MENUNGGU_VERIFIKASI') bg-amber-100 text-amber-900 border-amber-300
                            @elseif($calc->status === 'DIPERIKSA') bg-amber-100 text-amber-900 border-amber-300
                            @elseif($calc->status === 'DIVERIFIKASI') bg-teal-100 text-teal-900 border-teal-300
                            @elseif($calc->status === 'FINAL') bg-emerald-100 text-emerald-900 border-emerald-300
                            @else bg-slate-100 text-slate-800 border-slate-300 @endif">
                            {{ str_replace('_', ' ', $calc->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <a href="{{ route('admin.verifications.show', $calc->id) }}" class="inline-block px-3 py-1.5 text-xs font-bold text-white bg-teal-700 rounded-lg hover:bg-teal-800">Periksa</a>
                        <a href="{{ route('admin.verifications.compare', $calc->id) }}" class="inline-block px-3 py-1.5 text-xs font-bold text-teal-900 bg-teal-50 border border-teal-300 rounded-lg hover:bg-teal-100">Bandingkan</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-sm text-slate-600">Tidak ada penghitungan menunggu verifikasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
