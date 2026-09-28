@extends('layouts.app')

@section('header')
    <x-page-header eyebrow="Acuan rumus" title="Aturan Penghitungan" description="Pengali UP dan UPMK per alasan PHK. Perubahan di sini dipakai hitungan berikutnya.">
        <x-slot name="actions">
            <x-button type="button" variant="primary" size="md" icon="plus">
                Tambah Aturan
            </x-button>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
<div class="table-shell">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[760px]">
            <thead class="table-head text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Alasan PHK</th>
                    <th class="px-6 py-3 text-right">Pesangon</th>
                    <th class="px-6 py-3 text-right">UPMK</th>
                    <th class="px-6 py-3 text-left">Aturan UPH</th>
                    <th class="px-6 py-3 text-left">Versi</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($rules as $rule)
                <tr class="hover:bg-primary-50/50">
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $rule->terminationReason->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-right font-bold text-primary-900 tabular">{{ $rule->severance_multiplier ?? '-' }}x</td>
                    <td class="px-6 py-4 text-right font-bold text-slate-900 tabular">{{ $rule->upmk_multiplier ?? '-' }}x</td>
                    <td class="px-6 py-4 text-xs text-slate-600">{{ $rule->uph_rule ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $rule->rule_version ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($rule->is_active)
                            <span class="badge bg-emerald-100 text-emerald-900 border-emerald-300">Aktif</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-700 border-slate-300">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <button class="px-2.5 py-1.5 text-xs font-bold text-primary-900 hover:underline underline-offset-2">Ubah</button>
                        <button class="px-2.5 py-1.5 text-xs font-bold text-red-800 hover:underline underline-offset-2">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-10 text-center text-sm text-slate-600">Belum ada aturan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
