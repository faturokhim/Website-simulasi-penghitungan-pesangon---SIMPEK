<?php

namespace App\Policies;

use App\Models\Calculation;
use App\Models\User;

class CalculationPolicy
{
    public function view(User $user, Calculation $calculation): bool
    {
        return $user->role === 'admin' || $calculation->user_id === $user->id;
    }

    public function update(User $user, Calculation $calculation): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $calculation->user_id === $user->id && $calculation->status === 'SIMULASI';
    }
}
