<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TerminationReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'legal_basis', 'is_active',
        'category', 'uses_separation_money', 'uses_pension_fund'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'uses_separation_money' => 'boolean',
        'uses_pension_fund' => 'boolean',
    ];

    public function calculationRules(): HasMany
    {
        return $this->hasMany(CalculationRule::class);
    }

    /**
     * Alias relasi agar konsisten dengan pemakaian di Blade
     * ($reason->rules) dan eager-load with('rules').
     */
    public function rules(): HasMany
    {
        return $this->hasMany(CalculationRule::class);
    }

    public function isStandardPhk(): bool
    {
        return in_array($this->category, [
            'standard_phk', 'merger_acquisition', 'efficiency_loss',
            'efficiency_prevention', 'closure_loss', 'closure_no_loss',
            'force_majeure_closure', 'force_majeure_no_closure',
            'pkpu_loss', 'pkpu_no_loss', 'bankruptcy',
            'employer_violation', 'sp_warning', 'detained_no_loss',
        ]);
    }

    public function usesSeparationMoney(): bool
    {
        return $this->uses_separation_money || in_array($this->category, [
            'resignation', 'absence', 'urgent_violation',
            'court_rejected_worker', 'detained_loss',
        ]);
    }
}