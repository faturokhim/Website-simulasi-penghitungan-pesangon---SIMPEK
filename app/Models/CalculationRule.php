<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'termination_reason_id', 'regulation_id', 'severance_multiplier',
        'upmk_multiplier', 'uph_rule', 'separation_money_multiplier',
        'pension_fund_deduction', 'special_notes', 'rule_version',
        'effective_date', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'severance_multiplier' => 'decimal:2',
            'upmk_multiplier' => 'decimal:2',
            'separation_money_multiplier' => 'decimal:2',
            'pension_fund_deduction' => 'decimal:2',
            'effective_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function terminationReason(): BelongsTo
    {
        return $this->belongsTo(TerminationReason::class);
    }

    public function regulation(): BelongsTo
    {
        return $this->belongsTo(Regulation::class);
    }
}