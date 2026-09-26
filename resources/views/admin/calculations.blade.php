@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Arsip admin</p>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Penghitungan</h1>
            <p class="text-sm text-slate-600 mt-0.5">Buka detail, bandingkan hasil, atau unduh PDF.</p>
        </div>
        <a href="{{ route('admin.calculator') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl shadow-sm transition">+ Baru</a>
    </div>
@endsection

@section('content')
<div class="table-shell">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[820px]">
            <thead class="table-head text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Hasil User</th>
                    <th class="px-6 py-3 text-right">Hasil Admin</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @php
                    $calculations = \App\Models\Calculation::with('user', 'terminationReason')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
                @endphp
                @forelse($calculations as $calc)
                <tr class="hover:bg-teal-50/50">
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $calc->employee_name }}</td>
                    <td class="px-6 py-4 text-slate-700 whitespace-nowrap">{{ $calc->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="badge
                            @if($calc->status === 'SIMULASI') bg-slate-100 text-slate-800 border-slate-300
                            @elseif($calc->status === 'MENUNGGU_VERIFIKASI') bg-amber-100 text-amber-900 border-amber-300
                            @elseif($calc->status === 'DIPERIKSA') bg-amber-100 text-amber-900 border-amber-300
                            @elseif($calc->status === 'DIVERIFIKASI') bg-teal-100 text-teal-900 border-teal-300
                            @elseif($calc->status === 'FINAL') bg-emerald-100 text-emerald-900 border-emerald-300
                            @else bg-slate-100 text-slate-800 border-slate-300 @endif">
                            {{ str_replace('_', ' ', $calc->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-slate-900 tabular">Rp {{ number_format($calc->user_total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-slate-900 tabular">Rp {{ number_format($calc->admin_total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <a href="{{ route('admin.calculations.show', $calc->id) }}" class="inline-block px-2.5 py-1.5 text-xs font-bold text-teal-900 bg-teal-50 border border-teal-300 rounded-lg hover:bg-teal-100">Detail</a>
                        <a href="{{ route('admin.verifications.compare', $calc->id) }}" class="inline-block px-2.5 py-1.5 text-xs font-bold text-slate-800 bg-slate-100 border border-slate-300 rounded-lg hover:bg-slate-200">Banding</a>
                        <a href="{{ route('admin.verifications.show', $calc->id) }}" class="inline-block px-2.5 py-1.5 text-xs font-bold text-emerald-900 bg-emerald-50 border border-emerald-300 rounded-lg hover:bg-emerald-100">Verifikasi</a>
                        <a href="{{ route('admin.calculations.pdf', $calc->id) }}" class="inline-block px-2.5 py-1.5 text-xs font-bold text-slate-700 underline underline-offset-2 hover:text-slate-900">PDF</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-slate-600">Belum ada penghitungan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
