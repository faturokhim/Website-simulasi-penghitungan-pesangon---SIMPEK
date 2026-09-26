<?php

namespace App\Services;

use App\Models\CalculationRule;
use App\Models\TerminationReason;

class RuleService
{
    public function getRuleByReason(int $reasonId): ?CalculationRule
    {
        return CalculationRule::where('termination_reason_id', $reasonId)
            ->where('is_active', true)
            ->latest('effective_date')
            ->first();
    }

    public function getReason(int $reasonId): ?TerminationReason
    {
        return TerminationReason::find($reasonId);
    }

    public function getActiveReasons(): \Illuminate\Database\Eloquent\Collection
    {
        return TerminationReason::where('is_active', true)->orderBy('name')->get();
    }
}