<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPEK - Laporan Hasil Simulasi #{{ $calculation->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 20px; font-size: 12px; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 12px; margin-bottom: 15px; }
        .header h1 { color: #1e40af; margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
        .header .subtitle { color: #555; margin: 4px 0 0 0; font-size: 12px; font-weight: normal; }
        .header .meta { color: #777; font-size: 10px; margin-top: 5px; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        
        .total-box { background: #f0f7ff; border: 2px solid #2563eb; padding: 12px; text-align: center; margin: 15px 0; border-radius: 6px; }
        .total-box .amount { font-size: 24px; font-weight: bold; color: #1e40af; margin: 4px 0; }
        .total-box .label { color: #475569; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }

        h2 { font-size: 13px; color: #1e40af; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; margin: 16px 0 8px 0; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 10px; text-align: left; font-size: 11px; }
        th { background: #f8fafc; font-weight: bold; color: #334155; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .disclaimer { margin-top: 20px; padding: 10px; background: #fffbeb; border-left: 4px solid #f59e0b; font-size: 9.5px; color: #78350f; line-height: 1.4; border-radius: 0 4px 4px 0; }
        .footer { text-align: center; margin-top: 25px; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 8px; }
        
        .row-two-col { width: 100%; border: none; margin: 0; }
        .row-two-col td { border: none; padding: 0 5px; vertical-align: top; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIMPEK</h1>
        <div class="subtitle">Sistem Informasi Penghitungan Pesangon dan Penghargaan Masa Kerja</div>
        <div class="meta">Laporan Simulasi Perhitungan Hak Pekerja Akibat PHK • Dokumen #{{ str_pad($calculation->id, 5, '0', STR_PAD_LEFT) }} • Tanggal: {{ $calculation->created_at->format('d/m/Y') }}</div>
    </div>

    <table style="width: 100%; border: none; margin-bottom: 5px;">
        <tr>
            <td style="border: none; padding: 0;">
                <span class="badge">Status Dokumen: {{ $calculation->status }}</span>
            </td>
            <td style="border: none; padding: 0; text-align: right; font-size: 10px; color: #64748b;">
                Peraturan Rujukan: {{ $calculation->regulation ? $calculation->regulation->name : 'PP No. 35 Tahun 2021' }}
            </td>
        </tr>
    </table>

    <div class="total-box">
        <div class="label">Estimasi Total Hak PHK (Simulasi User)</div>
        <div class="amount">Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}</div>
        <div style="font-size: 10px; color: #64748b;">{{ $calculation->employee_name }} • Masa Kerja: {{ $calculation->work_years }} Tahun {{ $calculation->work_months }} Bulan {{ $calculation->work_days }} Hari</div>
    </div>

    <table class="row-two-col">
        <tr>
            <td style="width: 50%; padding-right: 6px;">
                <h2>1. Data Pekerja</h2>
                <table>
                    <tr><th style="width: 40%;">Nama Pekerja</th><td><strong>{{ $calculation->employee_name }}</strong></td></tr>
                    <tr><th>Nomor Identitas</th><td>{{ $calculation->identity_number ?? '-' }}</td></tr>
                    <tr><th>Jabatan / Posisi</th><td>{{ $calculation->position ?? '-' }}</td></tr>
                    <tr><th>Mulai Bekerja</th><td>{{ $calculation->start_date ? \Carbon\Carbon::parse($calculation->start_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Tanggal PHK</th><td>{{ $calculation->termination_date ? \Carbon\Carbon::parse($calculation->termination_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Total Masa Kerja</th><td><strong>{{ $calculation->work_years }} Thn {{ $calculation->work_months }} Bln {{ $calculation->work_days }} Hr</strong></td></tr>
                </table>
            </td>
            <td style="width: 50%; padding-left: 6px;">
                <h2>2. Komponen Upah & Alasan</h2>
                <table>
                    <tr><th style="width: 45%;">Upah Pokok</th><td class="text-right">Rp {{ number_format($calculation->basic_salary, 0, ',', '.') }}</td></tr>
                    <tr><th>Tunjangan Tetap</th><td class="text-right">Rp {{ number_format($calculation->fixed_allowance, 0, ',', '.') }}</td></tr>
                    <tr><th>Tunj. Tidak Tetap</th><td class="text-right" style="color: #94a3b8;">Rp {{ number_format($calculation->non_fixed_allowance, 0, ',', '.') }} *</td></tr>
                    <tr style="background: #f0fdf4;"><th>Dasar Upah</th><td class="text-right"><strong>Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }}</strong></td></tr>
                    <tr><th>Alasan PHK</th><td>{{ $calculation->terminationReason->name ?? '-' }}</td></tr>
                    <tr><th>Dasar Hukum</th><td style="font-size: 10px;">{{ $calculation->terminationReason->legal_basis ?? '-' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <h2>3. Rincian Perhitungan Hak (PP No. 35 Tahun 2021)</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Komponen Hak</th>
                <th style="width: 20%;">Rujukan Regulasi</th>
                <th style="width: 35%;">Formula / Rincian</th>
                <th class="text-right" style="width: 20%;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>A. Uang Pesangon (UP)</strong></td>
                <td>PP 35/2021 Ps. 40 (2)</td>
                <td>
                    Upah (Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }})
                    × {{ $calculation->base_severance_months }} bln
                    × {{ $calculation->rule ? $calculation->rule->severance_multiplier : '1.0' }}x
                </td>
                <td class="text-right font-bold">Rp {{ number_format($calculation->user_severance_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>B. UPMK</strong></td>
                <td>PP 35/2021 Ps. 40 (3)</td>
                <td>
                    Upah (Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }})
                    × {{ $calculation->base_upmk_months }} bln
                    × {{ $calculation->rule ? $calculation->rule->upmk_multiplier : '1.0' }}x
                </td>
                <td class="text-right font-bold">Rp {{ number_format($calculation->user_upmk_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>C. UPH (Penggantian)</strong></td>
                <td>PP 35/2021 Ps. 40 (4)</td>
                <td>
                    @php
                        $cutiVal = $calculation->wage_basis > 0 && $calculation->cuti_remaining > 0
                            ? round(($calculation->wage_basis / 25) * $calculation->cuti_remaining, 2)
                            : 0;
                    @endphp
                    Cuti ({{ $calculation->cuti_remaining ?? 0 }} hari): Rp {{ number_format($cutiVal, 0, ',', '.') }}<br>
                    Ongkos: Rp {{ number_format($calculation->return_cost ?? 0, 0, ',', '.') }} |
                    Lain: Rp {{ number_format($calculation->other_rights ?? 0, 0, ',', '.') }}
                </td>
                <td class="text-right font-bold">Rp {{ number_format($calculation->user_uph_amount, 0, ',', '.') }}</td>
            </tr>
            @if(($calculation->user_separation_money ?? 0) > 0)
            <tr>
                <td><strong>D. Uang Pisah</strong></td>
                <td>Sesuai PK/PP/PKB</td>
                <td>
                    1 × Upah Dasar (Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }})
                </td>
                <td class="text-right font-bold">Rp {{ number_format($calculation->user_separation_money, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr style="background: #eff6ff; font-size: 12px;">
                <td colspan="3" style="text-align: right;"><strong>TOTAL HAK KOMPENSASI PHK</strong></td>
                <td class="text-right font-bold" style="color: #1e40af; font-size: 13px;">Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="disclaimer">
        <strong>Catatan & Disclaimer Resmi:</strong><br>
        Hasil penghitungan ini merupakan simulasi administratif mandiri berdasarkan data upah dan masa kerja yang dimasukkan oleh pengguna serta aturan sistem yang berlaku. Dokumen ini bukan merupakan penetapan hak final secara hukum peradilan atau dinas tenaga kerja. Hak aktual dapat dipengaruhi oleh ketentuan Perjanjian Kerja (PK), Peraturan Perusahaan (PP), Perjanjian Kerja Bersama (PKB), atau verifikasi lanjutan oleh administrator.
    </div>

    <div class="footer">
        Dicetak secara otomatis oleh SIMPEK pada {{ now()->format('d/m/Y H:i:s') }} WIB • Dokumen Elektronik Sah
    </div>
</body>
</html>