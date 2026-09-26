@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-teal-50 text-teal-800 border border-teal-200/70 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                Sesuai PP No. 35/2021 & UU No. 6/2023
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kalkulator Simulasi Hak PHK</h1>
        </div>
        <a href="{{ route('user.regulations') }}" class="inline-flex items-center text-xs font-semibold text-teal-700 hover:text-teal-900">
            <span>Lihat Tabel Pengali Regulasi</span>
            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white/95 backdrop-blur-sm rounded-3xl border border-teal-100 shadow-sm p-6 sm:p-8">
        <!-- Interactive Multi-Step Indicator -->
        <div class="mb-8">
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-xs font-semibold">
                <button type="button" onclick="goToStep(0)" id="stepTab0" class="step-tab flex items-center p-3 rounded-2xl border text-left transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs">
                    <span class="w-6 h-6 rounded-xl bg-teal-600 text-white flex items-center justify-center mr-2 text-xs font-bold">1</span>
                    <span class="truncate">1. Masa Kerja</span>
                </button>
                <button type="button" onclick="goToStep(1)" id="stepTab1" class="step-tab flex items-center p-3 rounded-2xl border text-left transition bg-white border-slate-200 text-slate-500 hover:bg-slate-50">
                    <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center mr-2 text-xs">2</span>
                    <span class="truncate">2. Data Upah</span>
                </button>
                <button type="button" onclick="goToStep(2)" id="stepTab2" class="step-tab flex items-center p-3 rounded-2xl border text-left transition bg-white border-slate-200 text-slate-500 hover:bg-slate-50">
                    <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center mr-2 text-xs">3</span>
                    <span class="truncate">3. Alasan PHK</span>
                </button>
                <button type="button" onclick="goToStep(3)" id="stepTab3" class="step-tab flex items-center p-3 rounded-2xl border text-left transition bg-white border-slate-200 text-slate-500 hover:bg-slate-50">
                    <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center mr-2 text-xs">4</span>
                    <span class="truncate">4. Hak UPH</span>
                </button>
                <button type="button" onclick="goToStep(4)" id="stepTab4" class="step-tab flex items-center p-3 rounded-2xl border text-left transition bg-white border-slate-200 text-slate-500 hover:bg-slate-50">
                    <span class="w-6 h-6 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center mr-2 text-xs">5</span>
                    <span class="truncate">5. Konfirmasi</span>
                </button>
            </div>
        </div>

        <form id="calculatorForm" action="{{ route('user.calculator.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- STEP 1: IDENTITAS & MASA KERJA -->
            <div id="step1" class="step-section space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Langkah 1: Identitas & Tanggal Masa Kerja</h3>
                    <span class="text-xs text-rose-600 font-semibold">* Wajib diisi</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nama Lengkap Pekerja *</label>
                        <input type="text" name="employee_name" id="employeeNameInput" value="{{ old('employee_name', Auth::user()->name) }}" required
                            placeholder="Contoh: Budi Santoso"
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
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal Mulai Bekerja *</label>
                        <input type="date" name="start_date" id="startDateInput" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        @error('start_date')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tanggal Pengakhiran Hubungan Kerja (PHK) *</label>
                        <input type="date" name="termination_date" id="terminationDateInput" value="{{ old('termination_date', date('Y-m-d')) }}" required
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        @error('termination_date')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jabatan / Bagian</label>
                        <input type="text" name="position" value="{{ old('position') }}"
                            placeholder="Contoh: Operasional / Staff Akuntansi"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    </div>
                </div>

                <!-- Live Tenure Badge Box -->
                <div id="masaKerjaInfo" class="p-4 bg-teal-50/70 border border-teal-200/80 rounded-2xl hidden">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                        <h4 class="font-bold text-teal-900 text-xs uppercase tracking-wider">Perhitungan Masa Kerja Riil</h4>
                    </div>
                    <p class="text-teal-950 font-extrabold text-xl mt-1" id="masaKerjaDisplay"></p>
                    <p class="text-[11px] text-teal-700 mt-0.5">Masa kerja ini menjadi dasar penentuan bulan hak uang pesangon dan UPMK sesuai Pasal 40 PP No. 35 Tahun 2021.</p>
                </div>
            </div>

            <!-- STEP 2: KOMPONEN UPAH -->
            <div id="step2" class="step-section space-y-4 hidden">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Langkah 2: Komponen Upah Pekerja</h3>
                    <span class="text-xs text-slate-500">Pasal 32 & 33 PP 35/2021</span>
                </div>

                <!-- Pilihan Metode Upah -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Metode Penerimaan Upah:</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <button type="button" onclick="selectWageMethod('monthly')" id="methodMonthlyBtn"
                            class="method-btn p-3.5 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs">
                            <div class="text-lg mb-1">📅</div>
                            <div class="text-xs font-bold">Upah Bulanan</div>
                            <div class="text-[10px] text-teal-700 mt-0.5">Pokok + Tunjangan Tetap</div>
                        </button>
                        <button type="button" onclick="selectWageMethod('daily')" id="methodDailyBtn"
                            class="method-btn p-3.5 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300">
                            <div class="text-lg mb-1">☀️</div>
                            <div class="text-xs font-bold">Upah Harian</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">30 × Upah Sehari</div>
                        </button>
                        <button type="button" onclick="selectWageMethod('piece_rate')" id="methodPieceBtn"
                            class="method-btn p-3.5 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300">
                            <div class="text-lg mb-1">📦</div>
                            <div class="text-xs font-bold">Satuan Hasil / Borongan</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">Rata-rata 12 Bulan</div>
                        </button>
                    </div>
                </div>

                <!-- Input Upah Bulanan -->
                <div id="wageMonthly" class="wage-method-section space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upah Pokok (Rp) *</label>
                            <input type="number" name="basic_salary" id="basicSalaryInput" value="{{ old('basic_salary') }}" min="0" step="1000"
                                placeholder="Cth: 5000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                            @error('basic_salary')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tunjangan Tetap (Rp)</label>
                            <input type="number" name="fixed_allowance" id="fixedAllowanceInput" value="{{ old('fixed_allowance', 0) }}" min="0" step="1000"
                                placeholder="Cth: 1000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tunjangan Tidak Tetap (Rp)</label>
                            <input type="number" name="non_fixed_allowance" value="{{ old('non_fixed_allowance', 0) }}" min="0" step="1000"
                                placeholder="Cth: 500000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                            <p class="text-[10px] text-slate-400 mt-1">Tidak diperhitungkan dalam upah dasar</p>
                        </div>
                    </div>
                </div>

                <!-- Input Upah Harian -->
                <div id="wageDaily" class="wage-method-section space-y-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upah Sehari (Rp) *</label>
                            <input type="number" name="daily_wage" id="dailyWageInput" value="{{ old('daily_wage') }}" min="0" step="1000"
                                placeholder="Cth: 200000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upah Minimum Wilayah / UMK (Rp) - Opsional</label>
                            <input type="number" name="minimum_wage" id="minimumWageInputDaily" value="{{ old('minimum_wage') }}" min="0" step="1000"
                                placeholder="Cth: 5000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                            <p class="text-[10px] text-slate-400 mt-1">Jika perhitungan sebulan di bawah UMK, sistem otomatis menggunakan UMK</p>
                        </div>
                    </div>
                </div>

                <!-- Input Satuan Hasil -->
                <div id="wagePieceRate" class="wage-method-section space-y-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Rata-rata Penghasilan 12 Bulan Terakhir (Rp) *</label>
                            <input type="number" name="piece_rate_avg" id="pieceRateAvgInput" value="{{ old('piece_rate_avg') }}" min="0" step="1000"
                                placeholder="Cth: 6000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upah Minimum Wilayah / UMK (Rp) - Opsional</label>
                            <input type="number" name="minimum_wage" id="minimumWageInputPiece" value="{{ old('minimum_wage') }}" min="0" step="1000"
                                placeholder="Cth: 5000000"
                                class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        </div>
                    </div>
                </div>

                <!-- Live Wage Basis Counter -->
                <div id="wageBasisInfo" class="p-4 bg-teal-50/70 border border-teal-200/80 rounded-2xl hidden">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                        <h4 class="font-bold text-teal-900 text-xs uppercase tracking-wider">Dasar Upah Bulanan Penghitungan</h4>
                    </div>
                    <p class="text-teal-950 font-extrabold text-2xl mt-1" id="wageBasisDisplay">Rp 0</p>
                    <p class="text-[11px] text-teal-700 mt-0.5">Sesuai Pasal 157 UU No. 6 Tahun 2023, dasar perhitungan uang pesangon terdiri atas Upah Pokok dan Tunjangan Tetap.</p>
                </div>
            </div>

            <!-- STEP 3: ALASAN PHK -->
            <div id="step3" class="step-section space-y-4 hidden">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Langkah 3: Alasan Pemutusan Hubungan Kerja (PHK)</h3>
                    <span class="text-xs text-slate-500">23 Alasan Resmi PP 35/2021</span>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Pilih Alasan Pengakhiran Hubungan Kerja *</label>
                    <select name="termination_reason_id" id="terminationReasonId" required
                        class="w-full px-4 py-3 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition font-medium">
                        <option value="">-- Pilih Skenario Alasan PHK --</option>
                        @foreach($reasons as $reason)
                        <option value="{{ $reason->id }}" {{ old('termination_reason_id') == $reason->id ? 'selected' : '' }}>
                            {{ $reason->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('termination_reason_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dynamic Legal Callout Box -->
                <div id="reasonInfo" class="p-5 bg-teal-50/70 border border-teal-200 rounded-2xl hidden space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-teal-700 text-white" id="reasonArticleBadge">Rujukan Hukum</span>
                        <h4 class="font-bold text-teal-950 text-sm" id="reasonTitle"></h4>
                    </div>
                    <p class="text-xs text-teal-800 leading-relaxed" id="reasonDescription"></p>
                    <div class="grid grid-cols-2 gap-3 pt-2 text-xs font-semibold border-t border-teal-200/80">
                        <div>
                            <span class="text-[10px] text-teal-700 block uppercase">Pengali Pesangon (UP)</span>
                            <span class="text-teal-950 font-bold" id="reasonSeveranceMultiplier">-</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-teal-700 block uppercase">Pengali UPMK</span>
                            <span class="text-teal-950 font-bold" id="reasonUpmkMultiplier">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4: DATA HAK UPH -->
            <div id="step4" class="step-section space-y-4 hidden">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Langkah 4: Komponen Uang Penggantian Hak (UPH)</h3>
                    <span class="text-xs text-slate-500">Pasal 40 ayat (4)</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Sisa Cuti Tahunan (Hari)</label>
                        <input type="number" name="cuti_remaining" id="cutiRemainingInput" value="{{ old('cuti_remaining', 0) }}" min="0" max="365"
                            placeholder="Cth: 10"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <p class="text-[10px] text-slate-400 mt-1">Dikonversi resmi: (Upah/25) × Hari Cuti</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Biaya / Ongkos Transportasi Pulang (Rp)</label>
                        <input type="number" name="return_cost" id="returnCostInput" value="{{ old('return_cost', 0) }}" min="0" step="1000"
                            placeholder="Cth: 500000"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <p class="text-[10px] text-slate-400 mt-1">Bagi pekerja yang direkrut dari luar daerah</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Hak Lainnya Sesuai PK/PP/PKB (Rp)</label>
                        <input type="number" name="other_rights" id="otherRightsInput" value="{{ old('other_rights', 0) }}" min="0" step="1000"
                            placeholder="Cth: 1000000"
                            class="w-full px-4 py-2.5 text-sm bg-slate-50/70 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                        <p class="text-[10px] text-slate-400 mt-1">Hak yang diatur dalam perjanjian perusahaan</p>
                    </div>
                </div>
            </div>

            <!-- STEP 5: KONFIRMASI & SUBMIT -->
            <div id="step5" class="step-section space-y-5 hidden">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Langkah 5: Konfirmasi Data Simulasi</h3>
                    <span class="text-xs text-teal-800 font-bold">✓ Siap Dihitung</span>
                </div>

                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 space-y-4 text-xs">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Nama Pekerja</span>
                            <span class="font-extrabold text-slate-900 text-sm" id="reviewName">-</span>
                        </div>
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Masa Kerja Terhitung</span>
                            <span class="font-extrabold text-teal-800 text-sm" id="reviewMasaKerja">-</span>
                        </div>
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Dasar Upah Bulanan</span>
                            <span class="font-extrabold text-teal-800 text-sm" id="reviewWageBasis">-</span>
                        </div>
                        <div class="p-3.5 bg-white rounded-xl border border-slate-200">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Alasan PHK & Rujukan Hukum</span>
                            <span class="font-extrabold text-slate-800 text-sm" id="reviewReason">-</span>
                        </div>
                    </div>
                </div>

                <!-- Prominent Submit Card -->
                <div class="p-6 bg-gradient-to-r from-teal-50 via-teal-100/40 to-slate-50 border-2 border-teal-300/80 rounded-3xl text-center space-y-3">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-teal-700 text-white text-2xl shadow-sm mb-1">
                        🧮
                    </div>
                    <h4 class="text-lg font-extrabold text-slate-900">Proses Perhitungan Hak Kompensasi</h4>
                    <p class="text-xs text-slate-600 max-w-md mx-auto">
                        Sistem akan menjalankan formula resmi perundang-undangan untuk menghasilkan tabel rincian matematis lengkap serta dokumen PDF resmi.
                    </p>
                    <div class="pt-2">
                        <button type="submit" id="submitBtnStep5" class="inline-flex items-center justify-center px-10 py-3.5 bg-gradient-to-r from-teal-700 to-teal-800 hover:from-teal-800 hover:to-teal-900 text-white text-base font-bold rounded-2xl shadow-lg shadow-teal-800/25 hover:shadow-xl transition transform active:scale-98">
                            <span class="mr-2">🧮</span> Hitung & Buat Rincian Lengkap
                        </button>
                    </div>
                </div>
            </div>

            <!-- Global Action Bottom Bar -->
            <div class="pt-6 border-t border-slate-200 flex items-center justify-between gap-3">
                <button type="button" id="prevBtn" class="px-5 py-2.5 border border-slate-300/80 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100 transition hidden">
                    ← Kembali
                </button>

                <div class="flex items-center gap-3 ms-auto">
                    <button type="button" id="nextBtn" class="inline-flex items-center px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl shadow-sm transition">
                        <span>Lanjutkan</span>
                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button type="submit" id="submitBtn" class="inline-flex items-center px-7 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl shadow-md transition hidden">
                        <span class="mr-1.5">🧮</span> Hitung Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const steps = ['step1', 'step2', 'step3', 'step4', 'step5'];
    let current = 0;
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    window.goToStep = function(i) {
        if (i < 0 || i >= steps.length) return;
        if (i > current) {
            for (let s = 0; s < i; s++) {
                if (!validStep(s)) return;
            }
        }
        current = i;
        showStep(current);
    };

    function showStep(i) {
        steps.forEach((id, idx) => {
            const el = document.getElementById(id);
            if (el) {
                if (idx === i) el.classList.remove('hidden');
                else el.classList.add('hidden');
            }

            const tab = document.getElementById('stepTab' + idx);
            if (tab) {
                if (idx === i) {
                    tab.className = 'step-tab flex items-center p-3 rounded-2xl border text-left transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
                    tab.querySelector('span:first-child').className = 'w-6 h-6 rounded-xl bg-teal-600 text-white flex items-center justify-center mr-2 text-xs font-bold';
                } else if (idx < i) {
                    tab.className = 'step-tab flex items-center p-3 rounded-2xl border text-left transition bg-emerald-50 border-emerald-300 text-emerald-800 font-semibold';
                    tab.querySelector('span:first-child').className = 'w-6 h-6 rounded-xl bg-emerald-600 text-white flex items-center justify-center mr-2 text-xs font-bold';
                } else {
                    tab.className = 'step-tab flex items-center p-3 rounded-2xl border text-left transition bg-white border-slate-200 text-slate-500 hover:bg-slate-50';
                    tab.querySelector('span:first-child').className = 'w-6 h-6 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center mr-2 text-xs';
                }
            }
        });

        prevBtn.classList.toggle('hidden', i === 0);
        nextBtn.classList.toggle('hidden', i === steps.length - 1);
        submitBtn.classList.toggle('hidden', i !== steps.length - 1);

        if (i === steps.length - 1) buildReview();
    }

    function validStep(i) {
        const el = document.getElementById(steps[i]);
        if (!el) return true;
        const required = el.querySelectorAll('[required]');
        for (const input of required) {
            if (!input.value) { input.reportValidity(); return false; }
        }
        if (i === 0) {
            const s = document.querySelector('[name=start_date]').value;
            const t = document.querySelector('[name=termination_date]').value;
            if (s && t && new Date(t) < new Date(s)) { 
                alert('Tanggal PHK tidak boleh mendahului tanggal mulai kerja.'); 
                return false; 
            }
        }
        return true;
    }

    nextBtn.addEventListener('click', () => {
        if (validStep(current) && current < steps.length - 1) {
            current++;
            showStep(current);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (current > 0) {
            current--;
            showStep(current);
        }
    });

    function calcMasaKerja() {
        const s = document.querySelector('[name=start_date]').value;
        const t = document.querySelector('[name=termination_date]').value;
        const box = document.getElementById('masaKerjaInfo');
        const out = document.getElementById('masaKerjaDisplay');
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
        const b = parseFloat(document.querySelector('[name=basic_salary]').value || 0);
        const f = parseFloat(document.querySelector('[name=fixed_allowance]').value || 0);
        const daily = parseFloat(document.querySelector('[name=daily_wage]').value || 0);
        const piece = parseFloat(document.querySelector('[name=piece_rate_avg]').value || 0);
        const minWage = parseFloat(document.querySelector('[name=minimum_wage]').value || 0);

        const box = document.getElementById('wageBasisInfo');
        const out = document.getElementById('wageBasisDisplay');

        let wageBasis = 0;
        let method = '';

        if (daily > 0) {
            wageBasis = 30 * daily;
            method = '30 × Upah Harian';
            if (minWage > 0 && wageBasis < minWage) {
                wageBasis = minWage;
                method += ' → Disesuaikan ke UMK';
            }
        } else if (piece > 0) {
            wageBasis = piece;
            method = 'Rata-rata 12 Bulan (Borongan)';
            if (minWage > 0 && wageBasis < minWage) {
                wageBasis = minWage;
                method += ' → Disesuaikan ke UMK';
            }
        } else {
            wageBasis = b + f;
            method = 'Upah Pokok + Tunjangan Tetap';
            if (minWage > 0 && wageBasis < minWage) {
                wageBasis = minWage;
                method += ' → Disesuaikan ke UMK';
            }
        }

        if (wageBasis > 0) {
            box.classList.remove('hidden');
            out.textContent = 'Rp ' + wageBasis.toLocaleString('id-ID') + ' (' + method + ')';
        } else {
            box.classList.add('hidden');
        }
    }

    function selectWageMethod(method) {
        document.getElementById('wageMonthly').classList.add('hidden');
        document.getElementById('wageDaily').classList.add('hidden');
        document.getElementById('wagePieceRate').classList.add('hidden');

        document.getElementById('methodMonthlyBtn').className = 'method-btn p-3.5 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300';
        document.getElementById('methodDailyBtn').className = 'method-btn p-3.5 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300';
        document.getElementById('methodPieceBtn').className = 'method-btn p-3.5 border-2 rounded-2xl text-center transition bg-white border-slate-200 text-slate-600 hover:border-slate-300';

        if (method === 'monthly') {
            document.getElementById('wageMonthly').classList.remove('hidden');
            document.getElementById('methodMonthlyBtn').className = 'method-btn p-3.5 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
        } else if (method === 'daily') {
            document.getElementById('wageDaily').classList.remove('hidden');
            document.getElementById('methodDailyBtn').className = 'method-btn p-3.5 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
        } else if (method === 'piece_rate') {
            document.getElementById('wagePieceRate').classList.remove('hidden');
            document.getElementById('methodPieceBtn').className = 'method-btn p-3.5 border-2 rounded-2xl text-center transition bg-teal-50 border-teal-600 text-teal-900 font-bold shadow-xs';
        }

        calcWage();
    }

    const reasons = @json($reasonsData ?? []);

    function updateReasonInfo() {
        const id = document.getElementById('terminationReasonId').value;
        const box = document.getElementById('reasonInfo');
        if (!id || !reasons[id]) { 
            box.classList.add('hidden'); 
            return; 
        }
        const r = reasons[id];
        box.classList.remove('hidden');
        document.getElementById('reasonArticleBadge').textContent = r.legal || 'Dasar Hukum';
        document.getElementById('reasonTitle').textContent = r.name;
        document.getElementById('reasonDescription').textContent = r.desc || '-';
        
        if (r.rule) {
            document.getElementById('reasonSeveranceMultiplier').textContent = r.rule.sev + 'x Ketentuan Masa Kerja';
            document.getElementById('reasonUpmkMultiplier').textContent = r.rule.upmk + 'x Ketentuan Masa Kerja';
        } else {
            document.getElementById('reasonSeveranceMultiplier').textContent = 'Sesuai Ketentuan';
            document.getElementById('reasonUpmkMultiplier').textContent = 'Sesuai Ketentuan';
        }
    }

    function buildReview() {
        document.getElementById('reviewName').textContent = document.querySelector('[name=employee_name]').value || '-';
        document.getElementById('reviewMasaKerja').textContent = document.getElementById('masaKerjaDisplay').textContent || '-';
        document.getElementById('reviewWageBasis').textContent = document.getElementById('wageBasisDisplay').textContent || '-';
        const sel = document.getElementById('terminationReasonId');
        document.getElementById('reviewReason').textContent = sel.selectedOptions[0] && sel.value ? sel.selectedOptions[0].text.trim() : '-';
    }

    ['start_date', 'termination_date'].forEach(n => {
        const el = document.querySelector('[name=' + n + ']');
        if (el) el.addEventListener('change', calcMasaKerja);
    });

    ['basic_salary', 'fixed_allowance', 'daily_wage', 'piece_rate_avg', 'minimum_wage'].forEach(n => {
        const el = document.querySelector('[name=' + n + ']');
        if (el) el.addEventListener('input', calcWage);
    });

    document.getElementById('terminationReasonId').addEventListener('change', updateReasonInfo);

    calcMasaKerja();
    calcWage();
    updateReasonInfo();
    showStep(0);
})();
</script>
@endpush