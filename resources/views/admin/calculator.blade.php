@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200/70 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                Kalkulator Auditor & Admin
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Penghitungan Resmi Admin</h1>
        </div>
        <a href="{{ route('admin.reasons.index') }}" class="inline-flex items-center text-xs font-semibold text-teal-700 hover:text-teal-900">
            <span>Kelola 23 Alasan PHK</span>
            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white/95 backdrop-blur-sm rounded-3xl border border-teal-100 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.calculator.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section 1: Identitas & Tanggal -->
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900">1. Data Pekerja & Periode Hubungan Kerja</h3>
                    <span class="text-xs text-rose-600 font-semibold">* Wajib</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nama Lengkap Pekerja *</label>
                        <input type="text" name="employee_name" value="{{ old('employee_name') }}" required
                            placeholder="Cth: Budi Santoso"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        @error('employee_name')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nomor Identitas (NIK/KTP)</label>
                        <input type="text" name="identity_number" value="{{ old('identity_number') }}"
                            placeholder="16 digit NIK"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jabatan / Bagian</label>
                        <input type="text" name="position" value="{{ old('position') }}"
                            placeholder="Cth: Supervisor Produksi"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tautkan ke Akun Pengguna (Opsional)</label>
                        <select name="user_id" class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition font-medium">
                            <option value="">- Tanpa Akun Pengguna Tertaut -</option>
                            @foreach(\App\Models\User::where('role', 'user')->orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal Mulai Bekerja *</label>
                        <input type="date" name="start_date" id="adminStartDate" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        @error('start_date')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal Efektif PHK *</label>
                        <input type="date" name="termination_date" id="adminTerminationDate" value="{{ old('termination_date', date('Y-m-d')) }}" required
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        @error('termination_date')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Live Masa Kerja Box -->
                <div id="masaKerjaPreview" class="p-4 bg-teal-50/70 border border-teal-200/80 rounded-2xl hidden">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                        <h4 class="font-bold text-teal-900 text-xs uppercase tracking-wider">Perhitungan Masa Kerja Riil</h4>
                    </div>
                    <p class="text-teal-950 font-extrabold text-lg mt-1" id="masaKerjaText"></p>
                </div>
            </div>

            <!-- Section 2: Komponen Upah -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900">2. Komponen Upah & Metode Penerimaan</h3>
                    <span class="text-xs text-slate-500">UU 6/2023 Ps. 157</span>
                </div>

                <!-- Pilihan Metode Upah -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <button type="button" onclick="selectAdminWageMethod('monthly')" id="adminMethodMonthlyBtn"
                        class="p-3 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs">
                        <div class="text-base mb-0.5">📅</div>
                        <div class="text-xs font-bold">Upah Bulanan</div>
                        <div class="text-[10px] text-teal-700">Pokok + Tunjangan Tetap</div>
                    </button>
                    <button type="button" onclick="selectAdminWageMethod('daily')" id="adminMethodDailyBtn"
                        class="p-3 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300">
                        <div class="text-base mb-0.5">☀️</div>
                        <div class="text-xs font-bold">Upah Harian</div>
                        <div class="text-[10px] text-slate-400">30 × Upah Harian</div>
                    </button>
                    <button type="button" onclick="selectAdminWageMethod('piece_rate')" id="adminMethodPieceBtn"
                        class="p-3 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300">
                        <div class="text-base mb-0.5">📦</div>
                        <div class="text-xs font-bold">Satuan Hasil / Borongan</div>
                        <div class="text-[10px] text-slate-400">Rata-rata 12 Bulan</div>
                    </button>
                </div>

                <!-- Input Upah Bulanan -->
                <div id="adminWageMonthly" class="wage-section space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upah Pokok (Rp) *</label>
                            <input type="number" name="basic_salary" id="adminBasicSalary" value="{{ old('basic_salary') }}" min="0" step="1000"
                                placeholder="Cth: 6000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tunjangan Tetap (Rp)</label>
                            <input type="number" name="fixed_allowance" id="adminFixedAllowance" value="{{ old('fixed_allowance', 0) }}" min="0" step="1000"
                                placeholder="Cth: 1500000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tunjangan Tidak Tetap (Rp)</label>
                            <input type="number" name="non_fixed_allowance" value="{{ old('non_fixed_allowance', 0) }}" min="0" step="1000"
                                placeholder="Cth: 500000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                            <p class="text-[10px] text-slate-400 mt-1">Tidak masuk dasar upah pesangon</p>
                        </div>
                    </div>
                </div>

                <!-- Input Upah Harian -->
                <div id="adminWageDaily" class="wage-section space-y-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upah Sehari (Rp) *</label>
                            <input type="number" name="daily_wage" id="adminDailyWage" value="{{ old('daily_wage') }}" min="0" step="1000"
                                placeholder="Cth: 200000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">UMK Wilayah (Rp) - Opsional</label>
                            <input type="number" name="minimum_wage" id="adminMinWageDaily" value="{{ old('minimum_wage') }}" min="0" step="1000"
                                placeholder="Cth: 5000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                    </div>
                </div>

                <!-- Input Satuan Hasil -->
                <div id="adminWagePiece" class="wage-section space-y-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Rata-rata 12 Bulan (Rp) *</label>
                            <input type="number" name="piece_rate_avg" id="adminPieceAvg" value="{{ old('piece_rate_avg') }}" min="0" step="1000"
                                placeholder="Cth: 6500000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">UMK Wilayah (Rp) - Opsional</label>
                            <input type="number" name="minimum_wage" id="adminMinWagePiece" value="{{ old('minimum_wage') }}" min="0" step="1000"
                                placeholder="Cth: 5000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                    </div>
                </div>

                <!-- Live Wage Preview -->
                <div id="adminWagePreview" class="p-4 bg-teal-50/70 border border-teal-200/80 rounded-2xl hidden">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                        <h4 class="font-bold text-teal-900 text-xs uppercase tracking-wider">Dasar Upah Bulanan Terhitung</h4>
                    </div>
                    <p class="text-teal-950 font-extrabold text-xl mt-1" id="adminWageText">Rp 0</p>
                </div>
            </div>

            <!-- Section 3: Alasan PHK & Hak Tambahan -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-extrabold text-slate-900">3. Skenario Alasan PHK &amp; Komponen UPH</h3>
                    <span class="text-xs text-slate-500">PP 35/2021 Bab V</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alasan PHK *</label>
                        <select name="termination_reason_id" id="adminTerminationReasonId" required
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition font-medium">
                            <option value="">-- Pilih Skenario Alasan PHK --</option>
                            @foreach($reasons as $reason)
                            <option value="{{ $reason->id }}" {{ old('termination_reason_id') == $reason->id ? 'selected' : '' }}>
                                {{ $reason->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Callout Yuridis -->
                    <div id="adminRulePreview" class="md:col-span-2 p-4 bg-teal-50 border border-teal-200 rounded-2xl text-xs space-y-1 hidden"></div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Sisa Cuti Tahunan (Hari)</label>
                        <input type="number" name="cuti_remaining" value="{{ old('cuti_remaining', 0) }}" min="0" max="365"
                            placeholder="Cth: 12"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <p class="text-[10px] text-slate-400 mt-1">Dikonversi: (Upah/25) × Hari Cuti</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Biaya / Ongkos Transportasi Pulang (Rp)</label>
                        <input type="number" name="return_cost" value="{{ old('return_cost', 0) }}" min="0" step="1000"
                            placeholder="Cth: 500000"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Hak Lainnya Sesuai PK/PP/PKB (Rp)</label>
                        <input type="number" name="other_rights" value="{{ old('other_rights', 0) }}" min="0" step="1000"
                            placeholder="Cth: 1000000"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    </div>
                </div>
            </div>

            <!-- Submit Action Bar -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="button" onclick="history.back()" class="px-5 py-2.5 border border-slate-300 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100 transition w-full sm:w-auto">
                    ← Kembali
                </button>
                <button type="submit" id="adminSubmitBtn" class="inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white font-bold text-sm rounded-2xl shadow-lg shadow-teal-800/25 hover:shadow-xl transition transform active:scale-98 w-full sm:w-auto">
                    <span class="text-lg mr-2">🧮</span> Hitung &amp; Simpan Dokumen Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    function fmt(n) { return 'Rp ' + Number(n || 0).toLocaleString('id-ID'); }

    function calcMasaKerja() {
        const s = document.getElementById('adminStartDate').value;
        const t = document.getElementById('adminTerminationDate').value;
        const box = document.getElementById('masaKerjaPreview');
        const out = document.getElementById('masaKerjaText');
        if (!s || !t) { box.classList.add('hidden'); return; }
        const start = new Date(s), end = new Date(t);
        if (end < start) { box.classList.add('hidden'); return; }
        let y = end.getFullYear() - start.getFullYear();
        let m = end.getMonth() - start.getMonth();
        let d = end.getDate() - start.getDate();
        if (d < 0) { m--; d += new Date(end.getFullYear(), end.getMonth(), 0).getDate(); }
        if (m < 0) { y--; m += 12; }
        box.classList.remove('hidden');
        out.textContent = y + ' Tahun ' + m + ' Bulan ' + d + ' Hari';
    }

    function calcWage() {
        const b = parseFloat(document.getElementById('adminBasicSalary').value || 0);
        const f = parseFloat(document.getElementById('adminFixedAllowance').value || 0);
        const daily = parseFloat(document.getElementById('adminDailyWage').value || 0);
        const piece = parseFloat(document.getElementById('adminPieceAvg').value || 0);
        const minWageDaily = parseFloat(document.getElementById('adminMinWageDaily').value || 0);
        const minWagePiece = parseFloat(document.getElementById('adminMinWagePiece').value || 0);

        const box = document.getElementById('adminWagePreview');
        const out = document.getElementById('adminWageText');

        let wageBasis = 0;
        let method = '';

        if (daily > 0) {
            wageBasis = 30 * daily;
            method = '30 × Upah Harian';
            if (minWageDaily > 0 && wageBasis < minWageDaily) {
                wageBasis = minWageDaily;
                method += ' → Disesuaikan ke UMK';
            }
        } else if (piece > 0) {
            wageBasis = piece;
            method = 'Rata-rata 12 Bulan (Borongan)';
            if (minWagePiece > 0 && wageBasis < minWagePiece) {
                wageBasis = minWagePiece;
                method += ' → Disesuaikan ke UMK';
            }
        } else {
            wageBasis = b + f;
            method = 'Upah Pokok + Tunjangan Tetap';
        }

        if (wageBasis > 0) {
            box.classList.remove('hidden');
            out.textContent = fmt(wageBasis) + ' (' + method + ')';
        } else {
            box.classList.add('hidden');
        }
    }

    window.selectAdminWageMethod = function(method) {
        document.getElementById('adminWageMonthly').classList.add('hidden');
        document.getElementById('adminWageDaily').classList.add('hidden');
        document.getElementById('adminWagePiece').classList.add('hidden');

        document.getElementById('adminMethodMonthlyBtn').className = 'p-3 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300';
        document.getElementById('adminMethodDailyBtn').className = 'p-3 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300';
        document.getElementById('adminMethodPieceBtn').className = 'p-3 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300';

        if (method === 'monthly') {
            document.getElementById('adminWageMonthly').classList.remove('hidden');
            document.getElementById('adminMethodMonthlyBtn').className = 'p-3 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
        } else if (method === 'daily') {
            document.getElementById('adminWageDaily').classList.remove('hidden');
            document.getElementById('adminMethodDailyBtn').className = 'p-3 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
        } else if (method === 'piece_rate') {
            document.getElementById('adminWagePiece').classList.remove('hidden');
            document.getElementById('adminMethodPieceBtn').className = 'p-3 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
        }

        if (method !== 'monthly') {
            document.getElementById('adminBasicSalary').value = '';
            document.getElementById('adminFixedAllowance').value = '';
        }
        if (method !== 'daily') {
            document.getElementById('adminDailyWage').value = '';
        }
        if (method !== 'piece_rate') {
            document.getElementById('adminPieceAvg').value = '';
        }

        calcWage();
    };

    const reasons = @json($reasonsData ?? []);

    function updateAdminRuleInfo() {
        const id = document.getElementById('adminTerminationReasonId').value;
        const box = document.getElementById('adminRulePreview');
        if (!id || !reasons[id]) { box.classList.add('hidden'); return; }
        const r = reasons[id];
        box.classList.remove('hidden');
        let ruleText = '';
        if (r.rule) {
            ruleText = '<div class="mt-1 font-semibold text-teal-950">Pengali: UP ' + r.rule.sev + 'x | UPMK ' + r.rule.upmk + 'x</div>';
        }
        box.innerHTML = '<strong>' + r.name + '</strong><br><span class="text-teal-700">Dasar Hukum: ' + (r.legal || '-') + '</span>' + (r.desc ? '<p class="mt-0.5 text-slate-600">' + r.desc + '</p>' : '') + ruleText;
    }

    document.getElementById('adminStartDate').addEventListener('change', calcMasaKerja);
    document.getElementById('adminTerminationDate').addEventListener('change', calcMasaKerja);
    ['adminBasicSalary', 'adminFixedAllowance', 'adminDailyWage', 'adminPieceAvg', 'adminMinWageDaily', 'adminMinWagePiece'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', calcWage);
    });
    document.getElementById('adminTerminationReasonId').addEventListener('change', updateAdminRuleInfo);

    calcMasaKerja();
    calcWage();
    updateAdminRuleInfo();
})();
</script>
@endpush