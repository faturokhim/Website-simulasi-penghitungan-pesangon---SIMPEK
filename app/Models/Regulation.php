<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Regulation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'year', 'article', 'description', 'document_path', 'rule_version', 'effective_date', 'is_active'];

    public function calculationRules(): HasMany
    {
        return $this->hasMany(CalculationRule::class);
    }
}