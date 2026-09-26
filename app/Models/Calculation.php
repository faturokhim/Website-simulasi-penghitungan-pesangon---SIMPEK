<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'employee_name', 'start_date', 'termination_date',
        'identity_number', 'position', 'basic_salary', 'fixed_allowance',
        'non_fixed_allowance', 'daily_wage', 'piece_rate_avg', 'minimum_wage',
        'wage_basis', 'termination_reason_id',
        'cuti_remaining', 'other_rights', 'return_cost',
        'work_years', 'work_months', 'work_days',
        'user_severance_amount', 'user_upmk_amount', 'user_uph_amount', 'user_separation_money', 'user_pension_fund_deduction', 'user_total_amount',
        'admin_severance_amount', 'admin_upmk_amount', 'admin_uph_amount', 'admin_separation_money', 'admin_pension_fund_deduction', 'admin_total_amount',
        'admin_note', 'status', 'verified_by', 'verified_at',
        'rule_version', 'regulation_id', 'calculation_type'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'fixed_allowance' => 'decimal:2',
        'non_fixed_allowance' => 'decimal:2',
        'daily_wage' => 'decimal:2',
        'piece_rate_avg' => 'decimal:2',
        'minimum_wage' => 'decimal:2',
        'wage_basis' => 'decimal:2',
        'user_severance_amount' => 'decimal:2',
        'user_upmk_amount' => 'decimal:2',
        'user_uph_amount' => 'decimal:2',
        'user_separation_money' => 'decimal:2',
        'user_pension_fund_deduction' => 'decimal:2',
        'user_total_amount' => 'decimal:2',
        'admin_severance_amount' => 'decimal:2',
        'admin_upmk_amount' => 'decimal:2',
        'admin_uph_amount' => 'decimal:2',
        'admin_separation_money' => 'decimal:2',
        'admin_pension_fund_deduction' => 'decimal:2',
        'admin_total_amount' => 'decimal:2',
        'start_date' => 'date',
        'termination_date' => 'date',
        'verified_at' => 'datetime',
        'effective_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function terminationReason(): BelongsTo
    {
        return $this->belongsTo(TerminationReason::class);
    }

    public function regulation(): BelongsTo
    {
        return $this->belongsTo(Regulation::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getRuleAttribute(): ?CalculationRule
    {
        if ($this->relationLoaded('ruleCache')) {
            return $this->getRelation('ruleCache');
        }

        $rule = CalculationRule::where('termination_reason_id', $this->termination_reason_id)
            ->when($this->rule_version, fn ($q) => $q->where('rule_version', $this->rule_version))
            ->orderByDesc('effective_date')
            ->first()
            ?? CalculationRule::where('termination_reason_id', $this->termination_reason_id)
                ->orderByDesc('effective_date')
                ->first();

        $this->setRelation('ruleCache', $rule);

        return $rule;
    }

    public function getBaseSeveranceMonthsAttribute(): int
    {
        $years = (int) $this->work_years;
        if ($years < 1) return 1;
        if ($years < 2) return 2;
        if ($years < 3) return 3;
        if ($years < 4) return 4;
        if ($years < 5) return 5;
        if ($years < 6) return 6;
        if ($years < 7) return 7;
        if ($years < 8) return 8;
        return 9;
    }

    public function getBaseUpmkMonthsAttribute(): int
    {
        $years = (int) $this->work_years;
        if ($years < 3) return 0;
        if ($years < 6) return 2;
        if ($years < 9) return 3;
        if ($years < 12) return 4;
        if ($years < 15) return 5;
        if ($years < 18) return 6;
        if ($years < 21) return 7;
        if ($years < 24) return 8;
        return 10;
    }
}