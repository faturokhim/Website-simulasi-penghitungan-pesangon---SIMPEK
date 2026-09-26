<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulation;
use Illuminate\Http\Request;

class RegulationsController extends Controller
{
    public function index()
    {
        $regulations = Regulation::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.regulations.index', compact('regulations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string',
            'year' => 'required|string',
            'article' => 'nullable|string',
            'description' => 'nullable|string',
            'rule_version' => 'nullable|string',
            'effective_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        Regulation::create($validated);

        return back()->with('success', 'Peraturan berhasil ditambahkan!');
    }

    public function update(Request $request, Regulation $regulation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string',
            'year' => 'required|string',
            'article' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $regulation->update($validated);

        return back()->with('success', 'Peraturan berhasil diperbarui!');
    }

    public function destroy(Regulation $regulation)
    {
        $regulation->delete();
        return back()->with('success', 'Peraturan berhasil dihapus!');
    }
}