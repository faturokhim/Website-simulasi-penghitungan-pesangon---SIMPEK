@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Arsip simulasi Anda</p>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat Penghitungan</h1>
            <p class="text-sm text-slate-600 mt-0.5">Semua simulasi tersimpan di sini. Buka detail untuk lihat rincian atau unduh PDF.</p>
        </div>
        <a href="{{ route('user.calculator') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl shadow-sm transition">+ Hitung Baru</a>
    </div>
@endsection

@section('content')
<div class="table-shell">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[640px]">
            <thead class="table-head text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-bold">Tanggal</th>
                    <th class="px-6 py-3 text-left font-bold">Nama</th>
                    <th class="px-6 py-3 text-left font-bold">Status</th>
                    <th class="px-6 py-3 text-right font-bold">Total</th>
                    <th class="px-6 py-3 text-center font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($calculations as $calc)
                <tr class="hover:bg-teal-50/50">
                    <td class="px-6 py-4 text-slate-700 whitespace-nowrap">{{ $calc->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $calc->employee_name }}</td>
                    <td class="px-6 py-4">
                        <span class="badge
                            @if($calc->status === 'SIMULASI') bg-slate-100 text-slate-800 border-slate-300
                            @elseif($calc->status === 'MENUNGGU_VERIFIKASI') bg-amber-100 text-amber-900 border-amber-300
                            @elseif($calc->status === 'DIVERIFIKASI') bg-teal-100 text-teal-900 border-teal-300
                            @elseif($calc->status === 'FINAL') bg-emerald-100 text-emerald-900 border-emerald-300
                            @else bg-slate-100 text-slate-800 border-slate-300 @endif">
                            {{ str_replace('_', ' ', $calc->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-slate-900 tabular">Rp {{ number_format($calc->user_total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('user.result', $calc->id) }}" class="inline-block px-3 py-1.5 text-xs font-bold text-teal-900 bg-teal-50 border border-teal-300 rounded-lg hover:bg-teal-100">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center">
                        <p class="font-bold text-slate-900">Belum ada riwayat</p>
                        <p class="text-sm text-slate-600 mt-1">Hasil simulasi yang Anda simpan akan muncul di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
