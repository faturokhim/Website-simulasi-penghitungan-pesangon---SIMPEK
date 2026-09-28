@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('header')
    <x-page-header
        eyebrow="Ringkasan operasional"
        title="Dashboard Admin"
        description="Pantau antrean verifikasi dan kelola data acuan."
    />
@endsection

@section('content')
    <div class="mb-6 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pengguna" :value="$totalUsers" icon="users" />
        <x-stat-card label="Total simulasi" :value="$totalSimulations" icon="calculator" />
        <x-stat-card label="Menunggu verifikasi" :value="$waitingVerification" icon="clock" tone="warning" />
        <x-stat-card label="Terverifikasi" :value="$verified" icon="badge-check" tone="primary" />
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <x-card class="flex flex-col">
            <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-badge bg-primary-100 text-primary-700">
                <x-icon name="calculator" :size="20" />
            </span>
            <h3 class="font-semibold text-slate-900">Penghitungan baru</h3>
            <p class="mt-1 mb-5 text-sm text-slate-600">Buat penghitungan admin dengan data lengkap.</p>
            <x-button href="{{ route('admin.calculator') }}" variant="primary" size="sm" class="mt-auto self-start" icon="plus">
                Mulai Penghitungan
            </x-button>
        </x-card>

        <x-card class="flex flex-col">
            <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-badge bg-primary-100 text-primary-700">
                <x-icon name="clipboard-check" :size="20" />
            </span>
            <h3 class="font-semibold text-slate-900">Penghitungan user</h3>
            <p class="mt-1 mb-5 text-sm text-slate-600">Periksa, hitung ulang, dan verifikasi hasil user.</p>
            <x-button href="{{ route('admin.verifications.index') }}" variant="dark" size="sm" class="mt-auto self-start" icon="clipboard-list">
                Lihat Antrean Verifikasi
            </x-button>
        </x-card>

        <x-card class="flex flex-col">
            <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-badge bg-primary-100 text-primary-700">
                <x-icon name="list-checks" :size="20" />
            </span>
            <h3 class="font-semibold text-slate-900">Aturan penghitungan</h3>
            <p class="mt-1 mb-5 text-sm text-slate-600">Kelola pengali UP, UPMK, dan aturan UPH.</p>
            <x-button href="{{ route('admin.rules.index') }}" variant="outline" size="sm" class="mt-auto self-start" icon="settings">
                Kelola Aturan
            </x-button>
        </x-card>

        <x-card class="flex flex-col">
            <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-badge bg-primary-100 text-primary-700">
                <x-icon name="file-text" :size="20" />
            </span>
            <h3 class="font-semibold text-slate-900">Laporan</h3>
            <p class="mt-1 mb-5 text-sm text-slate-600">Unduh rekap penghitungan dalam bentuk PDF.</p>
            <x-button href="{{ route('admin.reports.index') }}" variant="secondary" size="sm" class="mt-auto self-start" icon="download">
                Lihat Laporan
            </x-button>
        </x-card>
    </div>
@endsection
