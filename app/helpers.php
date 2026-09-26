<?php

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('lucide_icon_svg')) {
    /**
     * Return the inner SVG markup of a Lucide outline icon, or null when unknown.
     */
    function lucide_icon_svg(string $name): ?string
    {
        static $icons = null;

        if ($icons === null) {
            $icons = require resource_path('icons/lucide.php');
        }

        return $icons[$name] ?? null;
    }
}

if (!function_exists('simpek_nav_items')) {
    /**
     * Single source of truth for primary navigation, shared by navbar and sidebar.
     *
     * @return array<int, array{label: string, route: string, match: string, icon: string}>
     */
    function simpek_nav_items(?string $role = null): array
    {
        $role = $role ?? (Auth::user()?->isAdmin() ? 'admin' : 'user');

        if ($role === 'admin') {
            return [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'layout-dashboard'],
                ['label' => 'Hitung Baru', 'route' => 'admin.calculator', 'match' => 'admin.calculator', 'icon' => 'calculator'],
                ['label' => 'Penghitungan', 'route' => 'admin.calculations.index', 'match' => 'admin.calculations.*', 'icon' => 'table-2'],
                ['label' => 'Verifikasi', 'route' => 'admin.verifications.index', 'match' => 'admin.verifications.*', 'icon' => 'clipboard-check'],
                ['label' => 'Laporan', 'route' => 'admin.reports.index', 'match' => 'admin.reports.*', 'icon' => 'file-text'],
                ['label' => 'Pengguna', 'route' => 'admin.users.index', 'match' => 'admin.users.*', 'icon' => 'users'],
                ['label' => 'Aturan', 'route' => 'admin.rules.index', 'match' => 'admin.rules.*', 'icon' => 'list-checks'],
                ['label' => 'Regulasi', 'route' => 'admin.regulations.index', 'match' => 'admin.regulations.*', 'icon' => 'book-open'],
                ['label' => 'Alasan PHK', 'route' => 'admin.reasons.index', 'match' => 'admin.reasons.*', 'icon' => 'clipboard-list'],
            ];
        }

        return [
            ['label' => 'Dashboard', 'route' => 'user.dashboard', 'match' => 'user.dashboard', 'icon' => 'layout-dashboard'],
            ['label' => 'Hitung Pesangon', 'route' => 'user.calculator', 'match' => 'user.calculator', 'icon' => 'calculator'],
            ['label' => 'Riwayat', 'route' => 'user.history', 'match' => 'user.history', 'icon' => 'history'],
            ['label' => 'Regulasi', 'route' => 'user.regulations', 'match' => 'user.regulations', 'icon' => 'book-open'],
            ['label' => 'Profil', 'route' => 'user.profile', 'match' => 'user.profile', 'icon' => 'user'],
        ];
    }
}

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
