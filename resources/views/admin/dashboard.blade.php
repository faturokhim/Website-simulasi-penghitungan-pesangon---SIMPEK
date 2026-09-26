@extends('layouts.app')

@section('header')
    <div>
        <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Ringkasan operasional</p>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Admin</h1>
        <p class="text-sm text-slate-600 mt-0.5">Pantau antrean verifikasi dan kelola data acuan.</p>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="text-sm font-semibold text-slate-600 mb-1">Total pengguna</div>
        <div class="text-3xl font-extrabold text-slate-900 tabular">{{ $totalUsers }}</div>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="text-sm font-semibold text-slate-600 mb-1">Total simulasi</div>
        <div class="text-3xl font-extrabold text-slate-900 tabular">{{ $totalSimulations }}</div>
    </div>
    <div class="bg-amber-50 p-6 rounded-3xl border border-amber-300 shadow-sm">
        <div class="text-sm font-semibold text-amber-900 mb-1">Menunggu verifikasi</div>
        <div class="text-3xl font-extrabold text-amber-900 tabular">{{ $waitingVerification }}</div>
    </div>
    <div class="bg-teal-700 p-6 rounded-3xl shadow-sm text-white">
        <div class="text-sm font-semibold text-teal-100 mb-1">Terverifikasi</div>
        <div class="text-3xl font-extrabold tabular">{{ $verified }}</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col">
        <h3 class="font-bold text-slate-900">Penghitungan baru</h3>
        <p class="text-sm text-slate-600 mt-1 mb-4">Buat penghitungan admin dengan data lengkap.</p>
        <a href="{{ route('admin.calculator') }}" class="mt-auto inline-flex items-center justify-center px-4 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl transition">
            Mulai Penghitungan
        </a>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col">
        <h3 class="font-bold text-slate-900">Penghitungan user</h3>
        <p class="text-sm text-slate-600 mt-1 mb-4">Periksa, hitung ulang, dan verifikasi hasil user.</p>
        <a href="{{ route('admin.verifications.index') }}" class="mt-auto inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl transition">
            Lihat Antrean Verifikasi
        </a>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col">
        <h3 class="font-bold text-slate-900">Aturan penghitungan</h3>
        <p class="text-sm text-slate-600 mt-1 mb-4">Kelola pengali UP, UPMK, dan aturan UPH.</p>
        <a href="{{ route('admin.rules.index') }}" class="mt-auto inline-flex items-center justify-center px-4 py-2.5 border-2 border-teal-700 text-teal-900 hover:bg-teal-50 text-sm font-bold rounded-xl transition">
            Kelola Aturan
        </a>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col">
        <h3 class="font-bold text-slate-900">Laporan</h3>
        <p class="text-sm text-slate-600 mt-1 mb-4">Unduh rekap penghitungan dalam bentuk PDF.</p>
        <a href="{{ route('admin.reports.index') }}" class="mt-auto inline-flex items-center justify-center px-4 py-2.5 border border-slate-300 text-slate-800 hover:bg-slate-100 text-sm font-bold rounded-xl transition">
            Lihat Laporan
        </a>
    </div>
</div>
@endsection
