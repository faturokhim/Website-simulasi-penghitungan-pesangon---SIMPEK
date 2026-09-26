@extends('layouts.app')

@section('header')
    <div>
        <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Akun Anda</p>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Profil</h1>
    </div>
@endsection

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-4 pb-5 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-teal-700 text-white flex items-center justify-center text-xl font-extrabold" aria-hidden="true">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-lg font-extrabold text-slate-900">{{ Auth::user()->name }}</p>
                <p class="text-sm text-slate-600">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <dl class="mt-5 space-y-4 text-sm">
            <div class="flex items-center justify-between gap-3">
                <dt class="font-semibold text-slate-600">Peran</dt>
                <dd>
                    <span class="badge @if(Auth::user()->role === 'admin') bg-teal-700 text-white border-teal-700 @else bg-slate-800 text-white border-slate-800 @endif">
                        {{ Auth::user()->role === 'admin' ? 'Admin' : 'Pekerja' }}
                    </span>
                </dd>
            </div>
            <div class="flex items-center justify-between gap-3">
                <dt class="font-semibold text-slate-600">Status akun</dt>
                <dd class="font-bold text-slate-900">{{ Auth::user()->status === 'active' ? 'Aktif' : Auth::user()->status }}</dd>
            </div>
            <div class="flex items-center justify-between gap-3">
                <dt class="font-semibold text-slate-600">Bergabung sejak</dt>
                <dd class="font-bold text-slate-900">{{ Auth::user()->created_at->format('d/m/Y') }}</dd>
            </div>
        </dl>
        <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('user.calculator') }}" class="inline-flex items-center px-4 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl transition">Hitung Pesangon</a>
            <a href="{{ route('user.history') }}" class="inline-flex items-center px-4 py-2.5 border border-slate-300 text-slate-800 text-sm font-bold rounded-xl hover:bg-slate-100 transition">Riwayat Saya</a>
        </div>
    </div>
</div>
@endsection
