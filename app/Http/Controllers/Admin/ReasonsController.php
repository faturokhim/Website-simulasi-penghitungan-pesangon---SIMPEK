<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TerminationReason;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReasonsController extends Controller
{
    public function index()
    {
        $reasons = TerminationReason::orderBy('name')->paginate(15);

        return view('admin.reasons.index', compact('reasons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'legal_basis' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        $validated['is_active'] = $request->boolean('is_active', true);

        TerminationReason::create($validated);

        return back()->with('success', 'Alasan PHK berhasil ditambahkan!');
    }

    public function update(Request $request, TerminationReason $reason)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'legal_basis' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $reason->update($validated);

        return back()->with('success', 'Alasan PHK berhasil diperbarui!');
    }

    public function destroy(TerminationReason $reason)
    {
        if ($reason->calculationRules()->exists()) {
            return back()->with('error', 'Alasan PHK dipakai rule aktif, nonaktifkan dulu.');
        }

        $reason->delete();

        return back()->with('success', 'Alasan PHK berhasil dihapus!');
    }
}
