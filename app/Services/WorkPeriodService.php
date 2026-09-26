<?php

namespace App\Services;

class WorkPeriodService
{
    public function calculate(string $startDate, string $endDate): array
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        if ($end < $start) {
            return ['years' => 0, 'months' => 0, 'days' => 0];
        }

        $years = $start->diff($end)->y;
        $months = $start->diff($end)->m;
        $days = $start->diff($end)->d;

        return [
            'years' => $years,
            'months' => $months,
            'days' => $days,
        ];
    }

    public function getTotalYears(int $years, int $months, int $days): float
    {
        return round($years + ($months / 12) + ($days / 365), 2);
    }
}