@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <x-page-header
        eyebrow="Ringkasan akun pekerja"
        title="Dashboard"
        description="Lihat simulasi terakhir dan mulai hitungan baru."
    >
        <x-slot name="actions">
            <x-button href="{{ route('user.calculator') }}" variant="primary" icon="plus">
                Hitung Pesangon
            </x-button>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <div class="mb-6 grid grid-cols-1 gap-5 md:grid-cols-2">
        <x-stat-card
            label="Total penghitungan Anda"
            :value="$totalCalculations"
            hint="Semua simulasi yang pernah Anda simpan."
            icon="calculator"
        />

        @if ($lastCalculation)
            <x-stat-card
                label="Penghitungan terakhir"
                :value="'Rp ' . number_format($lastCalculation->user_total_amount, 0, ',', '.')"
                :hint="$lastCalculation->employee_name . ' · ' . str_replace('_', ' ', $lastCalculation->status) . ' · ' . $lastCalculation->created_at->format('d/m/Y')"
                icon="clock"
                tone="primary"
                :href="route('user.result', $lastCalculation->id)"
            />
        @else
            <x-stat-card
                label="Penghitungan terakhir"
                value="—"
                hint="Belum ada penghitungan. Mulai simulasi pertama Anda."
                icon="clock"
            />
        @endif
    </div>

    <x-card :padded="false">
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-900">Penghitungan terakhir</h2>
            <a href="{{ route('user.history') }}"
               class="inline-flex items-center gap-1 text-sm font-semibold text-primary-800 transition-colors hover:text-primary-900 hover:underline focus-visible:ring-2 focus-visible:ring-primary rounded-badge">
                Lihat semua
                <x-icon name="chevron-right" :size="14" />
            </a>
        </div>

        <x-table min-width="640px">
            <x-table.head>
                <tr>
                    <x-table.th>Nama</x-table.th>
                    <x-table.th>Tanggal</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th align="right">Total</x-table.th>
                    <x-table.th align="center">Aksi</x-table.th>
                </tr>
            </x-table.head>
            <x-table.body>
                @forelse ($calculations as $calc)
                    <x-table.row>
                        <x-table.cell class="font-medium text-slate-900">{{ $calc->employee_name }}</x-table.cell>
                        <x-table.cell class="whitespace-nowrap text-slate-600">{{ $calc->created_at->format('d/m/Y') }}</x-table.cell>
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
                                icon="folder"
                                title="Belum ada data"
                                description='Klik "Hitung Pesangon" untuk membuat simulasi pertama.'
                            >
                                <x-slot name="action">
                                    <x-button href="{{ route('user.calculator') }}" variant="primary" size="sm" icon="plus">
                                        Hitung Pesangon
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
