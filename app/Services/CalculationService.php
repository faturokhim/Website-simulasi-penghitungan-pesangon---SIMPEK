<?php

namespace App\Services;

use App\Models\Calculation;
use App\Models\CalculationRule;
use App\Models\Regulation;

class CalculationService
{
    protected WorkPeriodService $workPeriodService;
    protected WageService $wageService;
    protected RuleService $ruleService;

    public function __construct()
    {
        $this->workPeriodService = new WorkPeriodService();
        $this->wageService = new WageService();
        $this->ruleService = new RuleService();
    }

    public function calculate(array $data): array
    {
        $workPeriod = $this->workPeriodService->calculate(
            $data['start_date'],
            $data['termination_date']
        );

        $wageBasis = $this->wageService->calculateWageBasis($data);

        $rule = null;
        $reason = null;
        if (!empty($data['termination_reason_id'])) {
            $rule = $this->ruleService->getRuleByReason($data['termination_reason_id']);
            $reason = $this->ruleService->getReason($data['termination_reason_id']);
        }

        $baseSeveranceMonths = $this->calculateBaseSeveranceMonths(
            $workPeriod['years'],
            $workPeriod['months'],
            $workPeriod['days']
        );

        $baseUpmkMonths = $this->calculateBaseUpmkMonths(
            $workPeriod['years'],
            $workPeriod['months'],
            $workPeriod['days']
        );

        $category = $reason?->category ?? 'standard_phk';

        $calculation = match ($category) {
            'resignation', 'absence', 'urgent_violation', 'court_rejected_worker', 'detained_loss' =>
                $this->calculateResignationType($data, $wageBasis, $baseSeveranceMonths, $baseUpmkMonths, $rule, $reason),
            'detained_no_loss' =>
                $this->calculateDetainedNoLoss($data, $wageBasis, $baseSeveranceMonths, $baseUpmkMonths, $rule, $reason),
            'sickness_disability' =>
                $this->calculateSicknessDisability($data, $wageBasis, $baseSeveranceMonths, $baseUpmkMonths, $rule, $reason),
            'retirement' => 
                $this->calculateRetirement($data, $wageBasis, $baseSeveranceMonths, $baseUpmkMonths, $rule, $reason),
            'death' => 
                $this->calculateDeath($data, $wageBasis, $baseSeveranceMonths, $baseUpmkMonths, $rule, $reason),
            default => 
                $this->calculateStandardPhk($data, $wageBasis, $baseSeveranceMonths, $baseUpmkMonths, $rule, $reason),
        };

        $calculation['work_period'] = $workPeriod;
        $calculation['wage_basis'] = $wageBasis;
        $calculation['base_severance_months'] = $baseSeveranceMonths;
        $calculation['base_upmk_months'] = $baseUpmkMonths;
        $calculation['rule'] = $rule;
        $calculation['termination_category'] = $category;
        $calculation['reason'] = $reason;

        return $calculation;
    }

    /**
     * PHK Standar (Pasal 41-47 PP 35/2021):
     * - Merger/Peleburan/Pemisahan: Pesangon 1x, UPMK 1x
     * - Pengambilalihan: Pesangon 1x, UPMK 1x
     * - Pengambilalihan + perubahan syarat kerja: Pesangon 0.5x, UPMK 1x
     * - Efisiensi karena kerugian: Pesangon 0.5x, UPMK 1x
     * - Efisiensi mencegah kerugian: Pesangon 1x, UPMK 1x
     * - Tutup karena kerugian: Pesangon 0.5x, UPMK 1x
     * - Tutup bukan karena kerugian: Pesangon 1x, UPMK 1x
     * - Force majeure + tutup: Pesangon 0.5x, UPMK 1x
     * - Force majeure tanpa tutup: Pesangon 0.75x, UPMK 1x
     * - PKPU karena kerugian: Pesangon 0.5x, UPMK 1x
     * - PKPU bukan karena kerugian: Pesangon 1x, UPMK 1x
     * - Pailit: Pesangon 0.5x, UPMK 1x
     * Semua + UPH
     */
    protected function calculateStandardPhk(array $data, float $wageBasis, int $baseSeveranceMonths, int $baseUpmkMonths, ?CalculationRule $rule, $reason): array
    {
        $severanceMultiplier = $rule ? (float) $rule->severance_multiplier : 1.0;
        $upmkMultiplier = $rule ? (float) $rule->upmk_multiplier : 1.0;
        $uphRule = $rule ? $rule->uph_rule : null;

        $pensionFundDeduction = $rule && $rule->pension_fund_deduction ? (float) $rule->pension_fund_deduction : 0;

        $severanceAmount = round($wageBasis * $baseSeveranceMonths * $severanceMultiplier, 2);
        $upmkAmount = round($wageBasis * $baseUpmkMonths * $upmkMultiplier, 2);
        $uphAmount = $this->calculateUph($data, $uphRule, $wageBasis);

        $totalBeforePension = $severanceAmount + $upmkAmount + $uphAmount;
        $totalAmount = $totalBeforePension;

        if ($pensionFundDeduction > 0) {
            $totalAmount = max(0, $totalAmount - $pensionFundDeduction);
        }

        return [
            'severance_amount' => $severanceAmount,
            'upmk_amount' => $upmkAmount,
            'uph_amount' => $uphAmount,
            'uph_breakdown' => $this->uphBreakdown($data, $wageBasis),
            'pension_fund_deduction' => $pensionFundDeduction,
            'total_before_pension' => round($totalBeforePension, 2),
            'total_amount' => round($totalAmount, 2),
            'severance_multiplier' => $severanceMultiplier,
            'upmk_multiplier' => $upmkMultiplier,
            'calculation_type' => 'standard_phk',
            'formula' => [
                'severance' => $severanceMultiplier > 0
                    ? "{$baseSeveranceMonths} bulan × {$severanceMultiplier} × Rp " . number_format($wageBasis, 0, ',', '.')
                    : 'Tidak berhak uang pesangon',
                'upmk' => $upmkMultiplier > 0
                    ? "{$baseUpmkMonths} bulan × {$upmkMultiplier} × Rp " . number_format($wageBasis, 0, ',', '.')
                    : 'Tidak berhak UPMK',
                'uph' => 'Penggantian Hak Cuti + Biaya Transportasi Pulang + Hak Lainnya',
            ],
        ];
    }

    /**
     * Pengunduran Diri / Mangkir / Pelanggaran Mendesak (Pasal 50, 51, 52 ayat 2 PP 35/2021):
     * UPH + Uang Pisah (bukan Pesangon + UPMK)
     * Uang Pisah = 1 x Upah Dasar (bisa disesuaikan peraturan perusahaan/PKB)
     */
    protected function calculateResignationType(array $data, float $wageBasis, int $baseSeveranceMonths, int $baseUpmkMonths, ?CalculationRule $rule, $reason): array
    {
        $uphRule = $rule ? $rule->uph_rule : null;
        $separationMoneyMultiplier = $rule && $rule->separation_money_multiplier ? (float) $rule->separation_money_multiplier : 1.0;
        $pensionFundDeduction = $rule && $rule->pension_fund_deduction ? (float) $rule->pension_fund_deduction : 0;

        $uphAmount = $this->calculateUph($data, $uphRule, $wageBasis);
        $separationMoney = round($wageBasis * $separationMoneyMultiplier, 2);

        $totalBeforePension = $uphAmount + $separationMoney;
        $totalAmount = $totalBeforePension;

        if ($pensionFundDeduction > 0) {
            $totalAmount = max(0, $totalAmount - $pensionFundDeduction);
        }

        return [
            'severance_amount' => 0,
            'upmk_amount' => 0,
            'uph_amount' => $uphAmount,
            'uph_breakdown' => $this->uphBreakdown($data, $wageBasis),
            'separation_money' => $separationMoney,
            'separation_money_multiplier' => $separationMoneyMultiplier,
            'pension_fund_deduction' => $pensionFundDeduction,
            'total_before_pension' => round($totalBeforePension, 2),
            'total_amount' => round($totalAmount, 2),
            'severance_multiplier' => 0,
            'upmk_multiplier' => 0,
            'calculation_type' => 'resignation_type',
            'formula' => [
                'severance' => 'Tidak berlaku (berhak Uang Pisah & UPH)',
                'upmk' => 'Tidak berlaku (berhak Uang Pisah & UPH)',
                'uph' => 'Penggantian Hak Cuti + Biaya Transportasi Pulang + Hak Lainnya',
                'separation_money' => "Uang Pisah: 1 × Upah Dasar (Rp " . number_format($wageBasis, 0, ',', '.') . ") sesuai PK/PP/PKB",
            ],
        ];
    }

    /**
     * Pekerja Ditahan >6 Bulan Tanpa Kerugian Perusahaan (Pasal 54 ayat 2 PP 35/2021):
     * Tanpa Uang Pesangon, UPMK 1x dari standar masa kerja, ditambah UPH.
     * Handler eksplisit agar tidak tercampur logika standar maupun uang pisah.
     */
    protected function calculateDetainedNoLoss(array $data, float $wageBasis, int $baseSeveranceMonths, int $baseUpmkMonths, ?CalculationRule $rule, $reason): array
    {
        $uphRule = $rule ? $rule->uph_rule : null;
        $upmkMultiplier = $rule ? (float) $rule->upmk_multiplier : 1.0;
        $pensionFundDeduction = $rule && $rule->pension_fund_deduction ? (float) $rule->pension_fund_deduction : 0;

        $upmkAmount = round($wageBasis * $baseUpmkMonths * $upmkMultiplier, 2);
        $uphAmount = $this->calculateUph($data, $uphRule, $wageBasis);

        $totalBeforePension = $upmkAmount + $uphAmount;
        $totalAmount = $pensionFundDeduction > 0
            ? max(0, $totalBeforePension - $pensionFundDeduction)
            : $totalBeforePension;

        return [
            'severance_amount' => 0,
            'upmk_amount' => $upmkAmount,
            'uph_amount' => $uphAmount,
            'uph_breakdown' => $this->uphBreakdown($data, $wageBasis),
            'pension_fund_deduction' => $pensionFundDeduction,
            'total_before_pension' => round($totalBeforePension, 2),
            'total_amount' => round($totalAmount, 2),
            'severance_multiplier' => 0,
            'upmk_multiplier' => $upmkMultiplier,
            'calculation_type' => 'detained_no_loss',
            'formula' => [
                'severance' => 'Tidak berhak uang pesangon (Pasal 54 ayat 2)',
                'upmk' => "{$baseUpmkMonths} bulan × {$upmkMultiplier} × Rp " . number_format($wageBasis, 0, ',', '.'),
                'uph' => 'Penggantian Hak Cuti + Biaya Transportasi Pulang + Hak Lainnya',
            ],
        ];
    }

    /**
     * PHK Karena Sakit/Cacat (Pasal 55 PP 35/2021):
     * Pesangon = 2 × Pesangon Dasar
     * UPMK = 1 × UPMK Dasar
     * UPH = sesuai Pasal 40
     */
    protected function calculateSicknessDisability(array $data, float $wageBasis, int $baseSeveranceMonths, int $baseUpmkMonths, ?CalculationRule $rule, $reason): array
    {
        $uphRule = $rule ? $rule->uph_rule : null;
        $pensionFundDeduction = $rule && $rule->pension_fund_deduction ? (float) $rule->pension_fund_deduction : 0;

        $severanceAmount = round($wageBasis * $baseSeveranceMonths * 2.0, 2);
        $upmkAmount = round($wageBasis * $baseUpmkMonths * 1.0, 2);
        $uphAmount = $this->calculateUph($data, $uphRule, $wageBasis);

        $totalBeforePension = $severanceAmount + $upmkAmount + $uphAmount;
        $totalAmount = $totalBeforePension;

        if ($pensionFundDeduction > 0) {
            $totalAmount = max(0, $totalAmount - $pensionFundDeduction);
        }

        return [
            'severance_amount' => $severanceAmount,
            'upmk_amount' => $upmkAmount,
            'uph_amount' => $uphAmount,
            'uph_breakdown' => $this->uphBreakdown($data, $wageBasis),
            'pension_fund_deduction' => $pensionFundDeduction,
            'total_before_pension' => round($totalBeforePension, 2),
            'total_amount' => round($totalAmount, 2),
            'severance_multiplier' => 2.0,
            'upmk_multiplier' => 1.0,
            'calculation_type' => 'sickness_disability',
            'formula' => [
                'severance' => "{$baseSeveranceMonths} bulan × 2.0 × Rp " . number_format($wageBasis, 0, ',', '.'),
                'upmk' => "{$baseUpmkMonths} bulan × 1.0 × Rp " . number_format($wageBasis, 0, ',', '.'),
                'uph' => 'Cuti + Biaya Pulang + Hak Lainnya',
            ],
        ];
    }

    /**
     * PHK Karena Pensiun (Pasal 56 PP 35/2021):
     * Pesangon = 1.75 × Pesangon Dasar
     * UPMK = 1 × UPMK Dasar
     * UPH = sesuai Pasal 40
     */
    protected function calculateRetirement(array $data, float $wageBasis, int $baseSeveranceMonths, int $baseUpmkMonths, ?CalculationRule $rule, $reason): array
    {
        $uphRule = $rule ? $rule->uph_rule : null;
        $pensionFundDeduction = $rule && $rule->pension_fund_deduction ? (float) $rule->pension_fund_deduction : 0;

        $severanceAmount = round($wageBasis * $baseSeveranceMonths * 1.75, 2);
        $upmkAmount = round($wageBasis * $baseUpmkMonths * 1.0, 2);
        $uphAmount = $this->calculateUph($data, $uphRule, $wageBasis);

        $totalBeforePension = $severanceAmount + $upmkAmount + $uphAmount;
        $totalAmount = $totalBeforePension;

        if ($pensionFundDeduction > 0) {
            $totalAmount = max(0, $totalAmount - $pensionFundDeduction);
        }

        return [
            'severance_amount' => $severanceAmount,
            'upmk_amount' => $upmkAmount,
            'uph_amount' => $uphAmount,
            'uph_breakdown' => $this->uphBreakdown($data, $wageBasis),
            'pension_fund_deduction' => $pensionFundDeduction,
            'total_before_pension' => round($totalBeforePension, 2),
            'total_amount' => round($totalAmount, 2),
            'severance_multiplier' => 1.75,
            'upmk_multiplier' => 1.0,
            'calculation_type' => 'retirement',
            'formula' => [
                'severance' => "{$baseSeveranceMonths} bulan × 1.75 × Rp " . number_format($wageBasis, 0, ',', '.'),
                'upmk' => "{$baseUpmkMonths} bulan × 1.0 × Rp " . number_format($wageBasis, 0, ',', '.'),
                'uph' => 'Cuti + Biaya Pulang + Hak Lainnya',
            ],
        ];
    }

    /**
     * PHK Karena Meninggal Dunia (Pasal 57 PP 35/2021):
     * Pesangon = 2 × Pesangon Dasar
     * UPMK = 1 × UPMK Dasar
     * UPH = sesuai Pasal 40
     * Dibayarkan kepada ahli waris
     */
    protected function calculateDeath(array $data, float $wageBasis, int $baseSeveranceMonths, int $baseUpmkMonths, ?CalculationRule $rule, $reason): array
    {
        $uphRule = $rule ? $rule->uph_rule : null;
        $pensionFundDeduction = $rule && $rule->pension_fund_deduction ? (float) $rule->pension_fund_deduction : 0;

        $severanceAmount = round($wageBasis * $baseSeveranceMonths * 2.0, 2);
        $upmkAmount = round($wageBasis * $baseUpmkMonths * 1.0, 2);
        $uphAmount = $this->calculateUph($data, $uphRule, $wageBasis);

        $totalBeforePension = $severanceAmount + $upmkAmount + $uphAmount;
        $totalAmount = $totalBeforePension;

        if ($pensionFundDeduction > 0) {
            $totalAmount = max(0, $totalAmount - $pensionFundDeduction);
        }

        return [
            'severance_amount' => $severanceAmount,
            'upmk_amount' => $upmkAmount,
            'uph_amount' => $uphAmount,
            'uph_breakdown' => $this->uphBreakdown($data, $wageBasis),
            'pension_fund_deduction' => $pensionFundDeduction,
            'total_before_pension' => round($totalBeforePension, 2),
            'total_amount' => round($totalAmount, 2),
            'severance_multiplier' => 2.0,
            'upmk_multiplier' => 1.0,
            'calculation_type' => 'death',
            'formula' => [
                'severance' => "{$baseSeveranceMonths} bulan × 2.0 × Rp " . number_format($wageBasis, 0, ',', '.'),
                'upmk' => "{$baseUpmkMonths} bulan × 1.0 × Rp " . number_format($wageBasis, 0, ',', '.'),
                'uph' => 'Cuti + Biaya Pulang + Hak Lainnya (untuk ahli waris)',
            ],
        ];
    }

    /**
     * Standar Uang Pesangon (UP) berdasarkan Masa Kerja
     * Rujukan: PP No. 35 Tahun 2021 Pasal 40 ayat (2)
     */
    public function calculateBaseSeveranceMonths(int $years, int $months = 0, int $days = 0): int
    {
        if ($years < 1) return 1;
        if ($years < 2) return 2;
        if ($years < 3) return 3;
        if ($years < 4) return 4;
        if ($years < 5) return 5;
        if ($years < 6) return 6;
        if ($years < 7) return 7;
        if ($years < 8) return 8;
        return 9; // 8 tahun atau lebih, maksimal 9 bulan upah
    }

    /**
     * Standar Uang Penghargaan Masa Kerja (UPMK) berdasarkan Masa Kerja
     * Rujukan: PP No. 35 Tahun 2021 Pasal 40 ayat (3)
     */
    public function calculateBaseUpmkMonths(int $years, int $months = 0, int $days = 0): int
    {
        if ($years < 3) return 0;
        if ($years < 6) return 2;
        if ($years < 9) return 3;
        if ($years < 12) return 4;
        if ($years < 15) return 5;
        if ($years < 18) return 6;
        if ($years < 21) return 7;
        if ($years < 24) return 8;
        return 10; // 24 tahun atau lebih, 10 bulan upah
    }

    protected function calculateUph(array $data, ?string $uphRule, float $wageBasis = 0): float
    {
        $cutiDays = (float) ($data['cuti_remaining'] ?? 0);
        $cutiValue = $wageBasis > 0 && $cutiDays > 0
            ? round(($wageBasis / 25) * $cutiDays, 2)
            : 0;
        $otherRights = (float) ($data['other_rights'] ?? 0);
        $returnCost = (float) ($data['return_cost'] ?? 0);

        return round($cutiValue + $otherRights + $returnCost, 2);
    }

    public function uphBreakdown(array $data, float $wageBasis): array
    {
        $cutiDays = (float) ($data['cuti_remaining'] ?? 0);
        $cutiValue = $wageBasis > 0 && $cutiDays > 0
            ? round(($wageBasis / 25) * $cutiDays, 2)
            : 0;

        return [
            'cuti_days' => $cutiDays,
            'cuti_value' => $cutiValue,
            'other_rights' => (float) ($data['other_rights'] ?? 0),
            'return_cost' => (float) ($data['return_cost'] ?? 0),
        ];
    }

    public function saveCalculation(array $data, Calculation $calculation, string $type = 'user'): Calculation
    {
        $result = $this->calculate($data);

        $calculation->employee_name = $data['employee_name'];
        $calculation->start_date = $data['start_date'];
        $calculation->termination_date = $data['termination_date'];
        $calculation->identity_number = $data['identity_number'] ?? null;
        $calculation->position = $data['position'] ?? null;
        $calculation->basic_salary = $data['basic_salary'] ?? 0;
        $calculation->fixed_allowance = $data['fixed_allowance'] ?? 0;
        $calculation->non_fixed_allowance = $data['non_fixed_allowance'] ?? 0;
        $calculation->daily_wage = $data['daily_wage'] ?? null;
        $calculation->piece_rate_avg = $data['piece_rate_avg'] ?? null;
        $calculation->minimum_wage = $data['minimum_wage'] ?? null;
        $calculation->wage_basis = $result['wage_basis'];
        $calculation->termination_reason_id = $data['termination_reason_id'] ?? null;
        $calculation->cuti_remaining = $data['cuti_remaining'] ?? 0;
        $calculation->other_rights = $data['other_rights'] ?? 0;
        $calculation->return_cost = $data['return_cost'] ?? 0;
        $calculation->work_years = $result['work_period']['years'];
        $calculation->work_months = $result['work_period']['months'];
        $calculation->work_days = $result['work_period']['days'];
        $calculation->rule_version = $result['rule'] ? $result['rule']->rule_version : null;
        $calculation->regulation_id = $result['rule'] ? $result['rule']->regulation_id : null;
        $calculation->calculation_type = $result['calculation_type'] ?? 'standard_phk';

        if ($type === 'user') {
            $calculation->user_severance_amount = $result['severance_amount'] ?? 0;
            $calculation->user_upmk_amount = $result['upmk_amount'] ?? 0;
            $calculation->user_uph_amount = $result['uph_amount'] ?? 0;
            $calculation->user_separation_money = $result['separation_money'] ?? 0;
            $calculation->user_pension_fund_deduction = $result['pension_fund_deduction'] ?? 0;
            $calculation->user_total_amount = $result['total_amount'];
            $calculation->status = 'SIMULASI';
        } else {
            $calculation->admin_severance_amount = $result['severance_amount'] ?? 0;
            $calculation->admin_upmk_amount = $result['upmk_amount'] ?? 0;
            $calculation->admin_uph_amount = $result['uph_amount'] ?? 0;
            $calculation->admin_separation_money = $result['separation_money'] ?? 0;
            $calculation->admin_pension_fund_deduction = $result['pension_fund_deduction'] ?? 0;
            $calculation->admin_total_amount = $result['total_amount'];
        }

        $calculation->save();

        return $calculation;
    }
}