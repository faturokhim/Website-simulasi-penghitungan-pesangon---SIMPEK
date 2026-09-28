@extends('layouts.app')

@section('header')
    <x-page-header eyebrow="Pemeriksaan admin" title="Verifikasi — {{ $calculation->employee_name }}" description="Nilai di kiri hasil hitungan user. Koreksi angka admin di kanan bila perlu, lalu simpan dengan status yang sesuai." />
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <form action="{{ route('admin.verifications.update', $calculation->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white p-6 rounded-card border border-slate-200 shadow-card">
            <h3 class="font-bold text-slate-900 pb-3 border-b border-slate-100">Hasil hitungan user</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-3"><dt class="text-slate-600">Nama</dt><dd class="font-bold text-slate-900 text-right">{{ $calculation->employee_name }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-600">Masa kerja</dt><dd class="font-bold text-slate-900 text-right">{{ $calculation->work_years }} thn {{ $calculation->work_months }} bln {{ $calculation->work_days }} hari</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-600">Dasar upah</dt><dd class="font-bold text-slate-900 text-right tabular">Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-600">UP</dt><dd class="font-semibold text-slate-900 text-right tabular">Rp {{ number_format($calculation->user_severance_amount, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-600">UPMK</dt><dd class="font-semibold text-slate-900 text-right tabular">Rp {{ number_format($calculation->user_upmk_amount, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-slate-600">UPH</dt><dd class="font-semibold text-slate-900 text-right tabular">Rp {{ number_format($calculation->user_uph_amount, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between gap-3 pt-3 border-t border-slate-200"><dt class="font-bold text-slate-900">Total user</dt><dd class="font-bold text-primary-900 tabular">Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}</dd></div>
            </dl>
        </div>

        <div class="bg-primary-50/60 p-6 rounded-card border border-primary-200 shadow-card">
            <h3 class="font-bold text-primary-950 pb-3 border-b border-primary-200">Angka koreksi admin</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="admin_severance_amount" class="block text-xs font-bold uppercase tracking-wide text-primary-950 mb-1.5">UP Admin (Rp)</label>
                        <input id="admin_severance_amount" type="number" name="admin_severance_amount" value="{{ $calculation->admin_severance_amount }}" required min="0" step="1000"
                            class="w-full px-4 py-2.5 text-sm bg-white border border-primary-300 rounded-xl text-right tabular focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                    </div>
                    <div>
                        <label for="admin_upmk_amount" class="block text-xs font-bold uppercase tracking-wide text-primary-950 mb-1.5">UPMK Admin (Rp)</label>
                        <input id="admin_upmk_amount" type="number" name="admin_upmk_amount" value="{{ $calculation->admin_upmk_amount }}" required min="0" step="1000"
                            class="w-full px-4 py-2.5 text-sm bg-white border border-primary-300 rounded-xl text-right tabular focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                    </div>
                    <div>
                        <label for="admin_uph_amount" class="block text-xs font-bold uppercase tracking-wide text-primary-950 mb-1.5">UPH Admin (Rp)</label>
                        <input id="admin_uph_amount" type="number" name="admin_uph_amount" value="{{ $calculation->admin_uph_amount }}" required min="0" step="1000"
                            class="w-full px-4 py-2.5 text-sm bg-white border border-primary-300 rounded-xl text-right tabular focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                    </div>
                    <div>
                        <label for="admin_total_amount" class="block text-xs font-bold uppercase tracking-wide text-primary-950 mb-1.5">Total Admin (Rp)</label>
                        <input id="admin_total_amount" type="number" name="admin_total_amount" value="{{ $calculation->admin_total_amount }}" required min="0" step="1000"
                            class="w-full px-4 py-2.5 text-sm bg-white border border-primary-300 rounded-xl text-right tabular font-bold focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                    </div>
                </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-card border border-slate-200 shadow-card">
        <label for="admin_note" class="block text-sm font-bold text-slate-900 mb-1.5">Catatan verifikasi</label>
        <p class="text-xs text-slate-600 mb-2">Tulis alasan koreksi agar user paham. Contoh: tanggal PHK dikoreksi 2 hari sehingga masa kerja bertambah 1 bulan.</p>
        <textarea id="admin_note" name="admin_note" rows="3" class="w-full px-4 py-2.5 text-sm bg-white border border-slate-300 rounded-input shadow-xs focus:ring-2 focus:ring-primary focus:border-primary"
            placeholder="Tulis alasan koreksi di sini...">{{ $calculation->admin_note }}</textarea>
    </div>

    <div class="flex flex-wrap gap-2">
        <x-button type="submit" name="status" value="DIPERIKSA" variant="warning" size="md" icon="eye">Tandai Diperiksa</x-button>
        <x-button type="submit" name="status" value="DIVERIFIKASI" variant="primary" size="md" icon="badge-check">Verifikasi</x-button>
        <x-button type="submit" name="status" value="FINAL" variant="dark" size="md" icon="lock" onclick="return confirm('Finalisasi? Hasil FINAL terkunci dan hanya bisa dikoreksi lewat Revisi.')">Finalisasi</x-button>
        <x-button href="{{ route('admin.verifications.compare', $calculation->id) }}" variant="secondary" size="md" icon="layers">Bandingkan</x-button>
        <x-button href="{{ route('admin.verifications.pdf', $calculation->id) }}" variant="secondary" size="md" icon="file-down">Unduh PDF</x-button>
    </div>
    </form>

    <div class="flex flex-wrap gap-2">
        <form action="{{ route('admin.verifications.recount', $calculation->id) }}" method="POST">
            @csrf
            <x-button type="submit" variant="primary" size="md" icon="refresh-cw">Hitung Ulang Otomatis</x-button>
        </form>
        @if($calculation->status === 'FINAL')
        <form action="{{ route('admin.verifications.revision', $calculation->id) }}" method="POST">
            @csrf
            <x-button type="submit" variant="danger" size="md" icon="rotate-ccw">Buat Revisi</x-button>
        </form>
        @endif
    </div>
</div>
@endsection
