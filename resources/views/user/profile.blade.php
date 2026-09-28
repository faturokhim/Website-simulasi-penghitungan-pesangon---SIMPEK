@extends('layouts.app')

@section('header')
    <x-page-header eyebrow="Akun Anda" title="Profil" />
@endsection

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-card border border-slate-200 shadow-card p-6 sm:p-8">
        <div class="flex items-center gap-4 pb-5 border-b border-slate-100">
            <div class="w-12 h-12 rounded-card bg-primary-700 text-white flex items-center justify-center text-xl font-bold" aria-hidden="true">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-lg font-bold text-slate-900">{{ Auth::user()->name }}</p>
                <p class="text-sm text-slate-600">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <dl class="mt-5 space-y-4 text-sm">
            <div class="flex items-center justify-between gap-3">
                <dt class="font-semibold text-slate-600">Peran</dt>
                <dd>
                    <span class="badge @if(Auth::user()->role === 'admin') bg-primary-700 text-white border-primary-700 @else bg-slate-800 text-white border-slate-800 @endif">
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
            <x-button href="{{ route('user.calculator') }}" variant="primary" size="md" icon="calculator">Hitung Pesangon</x-button>
            <a href="{{ route('user.history') }}" class="inline-flex items-center px-4 py-2.5 border border-slate-300 text-slate-800 text-sm font-bold rounded-xl hover:bg-slate-100 transition">Riwayat Saya</a>
        </div>
    </div>
</div>
@endsection
