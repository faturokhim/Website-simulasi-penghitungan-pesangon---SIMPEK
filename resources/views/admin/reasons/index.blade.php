@extends('layouts.app')

@section('header')
    <div>
        <p class="text-xs font-bold text-teal-800 uppercase tracking-wide">Data acuan hukum</p>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Alasan PHK</h1>
        <p class="text-sm text-slate-600 mt-0.5">Daftar alasan yang bisa dipilih user di kalkulator.</p>
    </div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-5">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
        <h2 class="font-bold text-slate-900 mb-4">Tambah alasan PHK</h2>
        <form action="{{ route('admin.reasons.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label for="reason_name" class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-1.5">Nama alasan</label>
                <input id="reason_name" type="text" name="name" required placeholder="Contoh: Perusahaan tutup karena rugi"
                    class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600">
            </div>
            <div>
                <label for="reason_legal" class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-1.5">Dasar hukum</label>
                <input id="reason_legal" type="text" name="legal_basis" placeholder="Contoh: PP No. 35/2021 Pasal 44"
                    class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600">
            </div>
            <div class="md:col-span-2">
                <label for="reason_desc" class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-1.5">Penjelasan singkat</label>
                <textarea id="reason_desc" name="description" rows="2" placeholder="Satu-dua kalimat penjelasan untuk user"
                    class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600"></textarea>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="px-5 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-sm font-bold rounded-xl transition">Tambah</button>
            </div>
        </form>
    </div>

    <div class="table-shell">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="table-head text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Dasar hukum</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reasons as $reason)
                    <tr class="hover:bg-teal-50/50">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $reason->name }}</td>
                        <td class="px-6 py-4"><span class="inline-block px-2 py-0.5 rounded-lg text-xs font-mono font-bold bg-slate-100 text-slate-800 border border-slate-300">{{ $reason->legal_basis ?? '-' }}</span></td>
                        <td class="px-6 py-4 text-center">
                            @if($reason->is_active)
                                <span class="badge bg-emerald-100 text-emerald-900 border-emerald-300">Aktif</span>
                            @else
                                <span class="badge bg-slate-100 text-slate-700 border-slate-300">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.reasons.update', $reason->id) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="name" value="{{ $reason->name }}">
                                <input type="hidden" name="legal_basis" value="{{ $reason->legal_basis }}">
                                <input type="hidden" name="is_active" value="{{ $reason->is_active ? 0 : 1 }}">
                                <button class="px-3 py-1.5 text-xs font-bold text-teal-900 bg-teal-50 border border-teal-300 rounded-lg hover:bg-teal-100">{{ $reason->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-slate-600">Belum ada data alasan PHK.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($reasons, 'links'))
        <div class="px-4 py-3 border-t border-slate-200">{{ $reasons->links() }}</div>
        @endif
    </div>
</div>
@endsection
