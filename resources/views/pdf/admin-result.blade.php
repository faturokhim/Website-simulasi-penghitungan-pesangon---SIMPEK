<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMPEK - Laporan Penghitungan & Verifikasi Admin #{{ $calculation->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 20px; font-size: 11px; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 10px; margin-bottom: 12px; }
        .header h1 { color: #1e40af; margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .header .subtitle { color: #555; margin: 3px 0 0 0; font-size: 11px; }
        .header .meta { color: #777; font-size: 9.5px; margin-top: 4px; }
        
        .status-box { padding: 6px 12px; border-radius: 4px; font-weight: bold; text-align: center; margin-bottom: 10px; font-size: 11px; }
        .status-final { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .status-verified { background: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
        .status-simulasi { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

        h2 { font-size: 12px; color: #1e40af; border-bottom: 1px solid #cbd5e1; padding-bottom: 3px; margin: 12px 0 6px 0; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        th, td { border: 1px solid #cbd5e1; padding: 5px 8px; text-align: left; font-size: 10.5px; }
        th { background: #f8fafc; font-weight: bold; color: #334155; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }

        .two-col-table { width: 100%; border: none; margin: 0; }
        .two-col-table td { border: none; padding: 0 4px; vertical-align: top; }

        .note-box { border: 1px solid #cbd5e1; padding: 8px 12px; background: #f8fafc; border-radius: 4px; font-size: 10.5px; margin-bottom: 8px; }
        
        .disclaimer { margin-top: 15px; padding: 8px; background: #fffbeb; border-left: 3px solid #f59e0b; font-size: 9px; color: #78350f; line-height: 1.35; }
        .footer { text-align: center; margin-top: 20px; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 6px; }

        .sig-table { width: 100%; border: none; margin-top: 15px; }
        .sig-table td { border: none; text-align: center; font-size: 10px; padding: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIMPEK</h1>
        <div class="subtitle">Sistem Informasi Penghitungan Pesangon dan Penghargaan Masa Kerja</div>
        <div class="meta">Laporan Resmi Hasil Penghitungan & Verifikasi Admin • ID: #{{ str_pad($calculation->id, 5, '0', STR_PAD_LEFT) }} • {{ $calculation->created_at->format('d F Y') }}</div>
    </div>

    @if($calculation->status === 'FINAL')
        <div class="status-box status-final">STATUS DOKUMEN: FINAL (TELAH DITETAPKAN & TERKUNCI)</div>
    @elseif($calculation->status === 'DIVERIFIKASI')
        <div class="status-box status-verified">STATUS DOKUMEN: DIVERIFIKASI OLEH ADMINISTRATOR</div>
    @else
        <div class="status-box status-simulasi">STATUS DOKUMEN: {{ $calculation->status }}</div>
    @endif

    <table class="two-col-table">
        <tr>
            <td style="width: 50%;">
                <h2>1. Data Pekerja</h2>
                <table>
                    <tr><th style="width: 38%;">Nama Pekerja</th><td><strong>{{ $calculation->employee_name }}</strong></td></tr>
                    <tr><th>NIK / KTP</th><td>{{ $calculation->identity_number ?? '-' }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $calculation->position ?? '-' }}</td></tr>
                    <tr><th>Akun User</th><td>{{ $calculation->user->name ?? 'Admin Input' }}</td></tr>
                    <tr><th>Periode</th><td>{{ $calculation->start_date ? \Carbon\Carbon::parse($calculation->start_date)->format('d/m/Y') : '-' }} s/d {{ $calculation->termination_date ? \Carbon\Carbon::parse($calculation->termination_date)->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Masa Kerja</th><td><strong>{{ $calculation->work_years }} Thn {{ $calculation->work_months }} Bln {{ $calculation->work_days }} Hr</strong></td></tr>
                </table>
            </td>
            <td style="width: 50%;">
                <h2>2. Komponen Upah & Regulasi</h2>
                <table>
                    <tr><th style="width: 42%;">Upah Pokok</th><td class="text-right">Rp {{ number_format($calculation->basic_salary, 0, ',', '.') }}</td></tr>
                    <tr><th>Tunjangan Tetap</th><td class="text-right">Rp {{ number_format($calculation->fixed_allowance, 0, ',', '.') }}</td></tr>
                    <tr><th>Tunj. Tidak Tetap</th><td class="text-right" style="color: #94a3b8;">Rp {{ number_format($calculation->non_fixed_allowance, 0, ',', '.') }} *</td></tr>
                    <tr style="background: #f0fdf4;"><th>Dasar Upah</th><td class="text-right"><strong>Rp {{ number_format($calculation->wage_basis, 0, ',', '.') }}</strong></td></tr>
                    <tr><th>Alasan PHK</th><td>{{ $calculation->terminationReason->name ?? '-' }}</td></tr>
                    <tr><th>Dasar Hukum</th><td style="font-size: 9.5px;">{{ $calculation->terminationReason->legal_basis ?? '-' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <h2>3. Perbandingan & Hasil Akhir (User vs Admin)</h2>
    <table>
        <thead>
            <tr style="background: #f1f5f9;">
                <th style="width: 25%;">Komponen Hak</th>
                <th class="text-right" style="width: 25%;">Hasil User (Simulasi)</th>
                <th class="text-right" style="width: 25%;">Hasil Admin (Resmi)</th>
                <th class="text-right" style="width: 25%;">Selisih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Uang Pesangon (UP)</strong><br><span style="font-size: 9px; color: #64748b;">(PP 35/2021 Ps. 40 (2))</span></td>
                <td class="text-right">Rp {{ number_format($calculation->user_severance_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #1e40af;">Rp {{ number_format($calculation->admin_severance_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: {{ $calculation->admin_severance_amount != $calculation->user_severance_amount ? '#dc2626' : '#16a34a' }};">
                    Rp {{ number_format(abs($calculation->admin_severance_amount - $calculation->user_severance_amount), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td><strong>UPMK</strong><br><span style="font-size: 9px; color: #64748b;">(PP 35/2021 Ps. 40 (3))</span></td>
                <td class="text-right">Rp {{ number_format($calculation->user_upmk_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #166534;">Rp {{ number_format($calculation->admin_upmk_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: {{ $calculation->admin_upmk_amount != $calculation->user_upmk_amount ? '#dc2626' : '#16a34a' }};">
                    Rp {{ number_format(abs($calculation->admin_upmk_amount - $calculation->user_upmk_amount), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td><strong>UPH (Penggantian Hak)</strong><br><span style="font-size: 9px; color: #64748b;">(PP 35/2021 Ps. 40 (4))</span></td>
                <td class="text-right">Rp {{ number_format($calculation->user_uph_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #6b21a8;">Rp {{ number_format($calculation->admin_uph_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: {{ $calculation->admin_uph_amount != $calculation->user_uph_amount ? '#dc2626' : '#16a34a' }};">
                    Rp {{ number_format(abs($calculation->admin_uph_amount - $calculation->user_uph_amount), 0, ',', '.') }}
                </td>
            </tr>
            @if((($calculation->user_separation_money ?? 0) > 0) || (($calculation->admin_separation_money ?? 0) > 0))
            <tr>
                <td><strong>Uang Pisah</strong><br><span style="font-size: 9px; color: #64748b;">(Sesuai PK/PP/PKB)</span></td>
                <td class="text-right">Rp {{ number_format($calculation->user_separation_money ?? 0, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #0f766e;">Rp {{ number_format($calculation->admin_separation_money ?? 0, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: {{ ($calculation->admin_separation_money ?? 0) != ($calculation->user_separation_money ?? 0) ? '#dc2626' : '#16a34a' }};">
                    Rp {{ number_format(abs(($calculation->admin_separation_money ?? 0) - ($calculation->user_separation_money ?? 0)), 0, ',', '.') }}
                </td>
            </tr>
            @endif
            <tr style="background: #eff6ff; font-size: 11px;">
                <td><strong>TOTAL HAK PHK</strong></td>
                <td class="text-right font-bold">Rp {{ number_format($calculation->user_total_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: #1e40af; font-size: 12px;">Rp {{ number_format($calculation->admin_total_amount, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="color: {{ $calculation->admin_total_amount != $calculation->user_total_amount ? '#dc2626' : '#16a34a' }}; font-size: 12px;">
                    Rp {{ number_format(abs($calculation->admin_total_amount - $calculation->user_total_amount), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    @if($calculation->admin_note)
    <h2>4. Catatan Verifikasi Administrator</h2>
    <div class="note-box">
        {{ $calculation->admin_note }}
    </div>
    @endif

    <h2>5. Dasar Regulasi & Rule Engine</h2>
    <table>
        <tr>
            <th style="width: 25%;">Peraturan Utama</th>
            <td>{{ $calculation->regulation ? $calculation->regulation->name . ' (' . $calculation->regulation->article . ')' : 'PP No. 35 Tahun 2021' }}</td>
            <th style="width: 20%;">Rule Version</th>
            <td>{{ $calculation->rule_version ?? '2026.01' }}</td>
        </tr>
        <tr>
            <th>Verifikator</th>
            <td>{{ $calculation->verifiedBy->name ?? 'Petugas SIMPEK' }}</td>
            <th>Waktu Verifikasi</th>
            <td>{{ $calculation->verified_at ? $calculation->verified_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
    </table>

    <div class="disclaimer">
        <strong>Catatan Legal:</strong> Hasil penghitungan ini merupakan penetapan kalkulasi hak pekerja akibat PHK yang telah diverifikasi oleh administrator sistem SIMPEK berdasarkan PP No. 35 Tahun 2021, UU No. 13/2003 jo. UU No. 6/2023, serta bukti komponen upah yang diserahkan.
    </div>

    <table class="sig-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">
                Diverifikasi di Jakarta, {{ $calculation->verified_at ? $calculation->verified_at->format('d F Y') : now()->format('d F Y') }}<br>
                <strong>Administrator Sistem SIMPEK</strong>
                <br><br><br><br>
                <u>( {{ $calculation->verifiedBy->name ?? 'Admin SIMPEK' }} )</u>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dicetak secara resmi oleh SIMPEK Admin pada {{ now()->format('d/m/Y H:i:s') }} WIB • Dokumen Sah
    </div>
</body>
</html>