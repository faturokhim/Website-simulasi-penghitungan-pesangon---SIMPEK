@extends('layouts.app')

@section('title', 'Riwayat Penghitungan')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'href' => route('user.dashboard')],
        ['label' => 'Riwayat Penghitungan'],
    ]" />
@endsection

@section('header')
    <x-page-header
        eyebrow="Arsip simulasi Anda"
        title="Riwayat Penghitungan"
        description="Semua simulasi tersimpan di sini. Buka detail untuk lihat rincian atau unduh PDF."
    >
        <x-slot name="actions">
            <x-button href="{{ route('user.calculator') }}" variant="primary" icon="plus">
                Hitung Baru
            </x-button>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <x-card :padded="false">
        <x-table min-width="640px">
            <x-table.head>
                <tr>
                    <x-table.th>Tanggal</x-table.th>
                    <x-table.th>Nama</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th align="right">Total</x-table.th>
                    <x-table.th align="center">Aksi</x-table.th>
                </tr>
            </x-table.head>
            <x-table.body>
                @forelse ($calculations as $calc)
                    <x-table.row>
                        <x-table.cell class="whitespace-nowrap text-slate-600">{{ $calc->created_at->format('d/m/Y') }}</x-table.cell>
                        <x-table.cell class="font-medium text-slate-900">{{ $calc->employee_name }}</x-table.cell>
                        <x-table.cell>
                            @if ($calc->status === 'MENUNGGU_VERIFIKASI')
                                <x-badge variant="warning">Menunggu Verifikasi</x-badge>
                            @elseif ($calc->status === 'DIVERIFIKASI')
                                <x-badge variant="primary">Diverifikasi</x-badge>
                            @elseif ($calc->status === 'FINAL')
                                <x-badge variant="success">Final</x-badge>
                            @else
                                <x-badge variant="neutral">{{ str_replace('_', ' ', $calc->status) }}</x-badge>
                            @endif
                        </x-table.cell>
                        <x-table.cell align="right" class="font-semibold tabular text-slate-900">
                            Rp {{ number_format($calc->user_total_amount, 0, ',', '.') }}
                        </x-table.cell>
                        <x-table.cell align="center">
                            <x-button href="{{ route('user.result', $calc->id) }}" variant="outline" size="xs">
                                Detail
                            </x-button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state
                                icon="history"
                                title="Belum ada riwayat"
                                description="Hasil simulasi yang Anda simpan akan muncul di sini."
                            >
                                <x-slot name="action">
                                    <x-button href="{{ route('user.calculator') }}" variant="primary" size="sm" icon="plus">
                                        Hitung Baru
                                    </x-button>
                                </x-slot>
                            </x-empty-state>
                        </td>
                    </tr>
                @endforelse
            </x-table.body>
        </x-table>
    </x-card>
@endsection
