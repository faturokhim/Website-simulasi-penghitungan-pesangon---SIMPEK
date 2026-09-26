<?php

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('activity_log')) {
    function activity_log(?int $userId, ?int $calculationId, string $action, $oldValue = null, $newValue = null): ?AuditLog
    {
        return AuditLog::create([
            'user_id' => $userId ?? Auth::id(),
            'calculation_id' => $calculationId,
            'action' => $action,
            'old_value' => is_scalar($oldValue) || is_null($oldValue) ? (string) ($oldValue ?? '') : json_encode($oldValue),
            'new_value' => is_scalar($newValue) || is_null($newValue) ? (string) ($newValue ?? '') : json_encode($newValue),
        ]);
    }
}
