<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculationRule;
use App\Models\Regulation;
use App\Models\TerminationReason;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    public function index()
    {
        $rules = CalculationRule::with('terminationReason', 'regulation')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $reasons = TerminationReason::where('is_active', true)->get();
        $regulations = Regulation::where('is_active', true)->get();

        return view('admin.rules.index', compact('rules', 'reasons', 'regulations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'termination_reason_id' => 'required|exists:termination_reasons,id',
            'regulation_id' => 'nullable|exists:regulations,id',
            'severance_multiplier' => 'required|numeric',
            'upmk_multiplier' => 'required|numeric',
            'uph_rule' => 'nullable|string',
            'rule_version' => 'nullable|string',
            'effective_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        CalculationRule::create($validated);

        return back()->with('success', 'Aturan berhasil ditambahkan!');
    }

    public function update(Request $request, CalculationRule $rule)
    {
        $validated = $request->validate([
            'severance_multiplier' => 'required|numeric',
            'upmk_multiplier' => 'required|numeric',
            'uph_rule' => 'nullable|string',
            'rule_version' => 'nullable|string',
            'effective_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $rule->update($validated);

        return back()->with('success', 'Aturan berhasil diperbarui!');
    }

    public function destroy(CalculationRule $rule)
    {
        $rule->delete();
        return back()->with('success', 'Aturan berhasil dihapus!');
    }
}