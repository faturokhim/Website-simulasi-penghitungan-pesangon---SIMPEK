<?php

namespace App\Services;

class WageService
{
    /**
     * Dasar upah = Upah Pokok + Tunjangan Tetap.
     * Sesuai UU No. 6/2023 Pasal 157 dan PP No. 35/2021.
     *
     * Untuk pekerja harian: Upah sebulan = 30 x Upah sehari
     * Untuk pekerja satuan hasil: Upah sebulan = rata-rata penghasilan 12 bulan terakhir
     *
     * Batas bawah UMK HANYA berlaku bila pengguna mengisi kolom UMK secara
     * eksplisit (nilai > 0). Kolom UMK yang dikosongkan berarti tidak ada
     * pembanding, sehingga dasar upah murni berasal dari komponen upah
     * yang dimasukkan. Tunjangan tidak tetap tidak pernah masuk dasar upah.
     */
    public function calculateWageBasis(array $wages): float
    {
        $basicSalary = (float) ($wages['basic_salary'] ?? 0);
        $fixedAllowance = (float) ($wages['fixed_allowance'] ?? 0);
        $dailyWage = (float) ($wages['daily_wage'] ?? 0);
        $pieceRateAvg = (float) ($wages['piece_rate_avg'] ?? 0);
        $minimumWage = $this->resolveMinimumWage($wages);

        $wageBasis = 0;

        if ($dailyWage > 0) {
            $wageBasis = 30 * $dailyWage;
        } elseif ($pieceRateAvg > 0) {
            $wageBasis = $pieceRateAvg;
        } else {
            $wageBasis = $basicSalary + $fixedAllowance;
        }

        if ($minimumWage !== null && $wageBasis < $minimumWage) {
            $wageBasis = $minimumWage;
        }

        return round($wageBasis, 2);
    }

    /**
     * Kembalikan nilai UMK pembanding bila pengguna mengisinya (angka > 0),
     * atau null bila kolom dikosongkan (tidak ada pembanding UMK).
     */
    public function resolveMinimumWage(array $wages): ?float
    {
        if (!isset($wages['minimum_wage']) || $wages['minimum_wage'] === null || $wages['minimum_wage'] === '') {
            return null;
        }

        $value = (float) $wages['minimum_wage'];

        return $value > 0 ? $value : null;
    }

    public function breakdown(array $wages): array
    {
        $basicSalary = (float) ($wages['basic_salary'] ?? 0);
        $fixedAllowance = (float) ($wages['fixed_allowance'] ?? 0);
        $nonFixedAllowance = (float) ($wages['non_fixed_allowance'] ?? 0);
        $dailyWage = (float) ($wages['daily_wage'] ?? 0);
        $pieceRateAvg = (float) ($wages['piece_rate_avg'] ?? 0);
        $minimumWage = $this->resolveMinimumWage($wages);

        $wageBasis = $this->calculateWageBasis($wages);
        $calculationMethod = 'monthly';

        if ($dailyWage > 0) {
            $calculationMethod = 'daily';
        } elseif ($pieceRateAvg > 0) {
            $calculationMethod = 'piece_rate';
        }

        $note = 'Dasar upah = Upah Pokok + Tunjangan Tetap (sesuai UU 6/2023 Ps. 157 & PP 35/2021). ';
        $note .= 'Tunjangan tidak tetap tidak masuk dasar upah. ';

        if ($calculationMethod === 'daily') {
            $note .= 'Perhitungan berbasis upah harian: 30 x upah harian. ';
        } elseif ($calculationMethod === 'piece_rate') {
            $note .= 'Perhitungan berbasis satuan hasil: rata-rata 12 bulan terakhir. ';
        }

        if ($minimumWage !== null) {
            $note .= 'Dibandingkan dengan UMK Rp ' . number_format($minimumWage, 0, ',', '.') . ' (dipakai bila hasil di bawah UMK).';
        } else {
            $note .= 'Tanpa pembanding UMK (kolom UMK dikosongkan).';
        }

        return [
            'basic_salary' => $basicSalary,
            'fixed_allowance' => $fixedAllowance,
            'non_fixed_allowance' => $nonFixedAllowance,
            'daily_wage' => $dailyWage,
            'piece_rate_avg' => $pieceRateAvg,
            'minimum_wage' => $minimumWage,
            'wage_basis' => $wageBasis,
            'calculation_method' => $calculationMethod,
            'note' => $note,
        ];
    }
}