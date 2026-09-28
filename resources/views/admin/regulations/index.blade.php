@extends('layouts.app')

@section('header')
    <x-page-header eyebrow="Referensi peraturan" title="Data Peraturan" description="Acuan pasal yang dipakai sebagai dasar hitungan." />
@endsection

@section('content')
<div class="table-shell">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[680px]">
            <thead class="table-head text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Peraturan</th>
                    <th class="px-6 py-3 text-left">Nomor</th>
                    <th class="px-6 py-3 text-left">Tahun</th>
                    <th class="px-6 py-3 text-left">Pasal</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($regulations as $reg)
                <tr class="hover:bg-primary-50/50">
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $reg->name }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $reg->number }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $reg->year }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $reg->article ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge @if($reg->is_active) bg-emerald-100 text-emerald-900 border-emerald-300 @else bg-slate-100 text-slate-700 border-slate-300 @endif">
                            {{ $reg->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <button class="px-2.5 py-1.5 text-xs font-bold text-primary-900 hover:underline underline-offset-2">Ubah</button>
                        <button class="px-2.5 py-1.5 text-xs font-bold text-red-800 hover:underline underline-offset-2">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-slate-600">Belum ada data peraturan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
