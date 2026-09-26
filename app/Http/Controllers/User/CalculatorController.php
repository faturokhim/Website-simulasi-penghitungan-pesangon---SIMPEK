<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use App\Models\TerminationReason;
use App\Services\CalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    public function index()
    {
        $reasons = TerminationReason::with('rules')->where('is_active', true)->orderBy('name')->get();
        // Peta data alasan untuk callout yuridis di form (disusun di controller
        // agar Blade tidak perlu menjalankan closure di dalam @json).
        $reasonsData = [];
        foreach ($reasons as $reason) {
            $rule = $reason->rules->first();
            $reasonsData[$reason->id] = [
                'name' => $reason->name,
                'legal' => $reason->legal_basis,
                'desc' => $reason->description,
                'rule' => $rule ? [
                    'sev' => (float) $rule->severance_multiplier,
                    'upmk' => (float) $rule->upmk_multiplier,
                ] : null,
            ];
        }

        return view('user.calculator', compact('reasons', 'reasonsData'));
    }

    public function store(Request $request, CalculationService $service)
    {
        $validated = $request->validate([
            'employee_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'termination_date' => 'required|date|after_or_equal:start_date',
            'identity_number' => 'nullable|string',
            'position' => 'nullable|string',
            'basic_salary' => 'nullable|numeric|min:0',
            'fixed_allowance' => 'nullable|numeric|min:0',
            'non_fixed_allowance' => 'nullable|numeric|min:0',
            'daily_wage' => 'nullable|numeric|min:0',
            'piece_rate_avg' => 'nullable|numeric|min:0',
            'minimum_wage' => 'nullable|numeric|min:0',
            'termination_reason_id' => 'required|exists:termination_reasons,id',
            'cuti_remaining' => 'nullable|numeric|min:0|max:365',
            'other_rights' => 'nullable|numeric|min:0',
            'return_cost' => 'nullable|numeric|min:0',
        ]);

        // Set defaults for nullable fields
        $validated['basic_salary'] = $validated['basic_salary'] ?? 0;
        $validated['fixed_allowance'] = $validated['fixed_allowance'] ?? 0;
        $validated['non_fixed_allowance'] = $validated['non_fixed_allowance'] ?? 0;
        $validated['daily_wage'] = $validated['daily_wage'] ?? null;
        $validated['piece_rate_avg'] = $validated['piece_rate_avg'] ?? null;
        $validated['minimum_wage'] = $validated['minimum_wage'] ?? null;

        $calculation = new Calculation();
        $calculation->user_id = Auth::id();

        $service->saveCalculation($validated, $calculation, 'user');

        return redirect()->route('user.result', $calculation->id)
            ->with('success', 'Penghitungan berhasil disimpan!');
    }
}