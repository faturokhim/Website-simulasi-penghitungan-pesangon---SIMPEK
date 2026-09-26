<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        $calculations = Calculation::whereIn('status', ['MENUNGGU_VERIFIKASI', 'DIPERIKSA'])
            ->with('user')
            ->paginate(15);

        return view('admin.verification.index', compact('calculations'));
    }

    public function show(Calculation $calculation)
    {
        return view('admin.verifications.show', compact('calculation'));
    }

    public function update(Request $request, Calculation $calculation)
    {
        // PRD §32: hasil FINAL terkunci, koreksi hanya lewat Revisi.
        if ($calculation->status === 'FINAL' && !$request->boolean('is_revision')) {
            return back()->with('error', 'Hasil FINAL terkunci. Gunakan Buat Revisi untuk koreksi.');
        }

        $validated = $request->validate([
            'admin_severance_amount' => 'required|numeric|min:0',
            'admin_upmk_amount' => 'required|numeric|min:0',
            'admin_uph_amount' => 'required|numeric|min:0',
            'admin_total_amount' => 'required|numeric|min:0',
            'admin_note' => 'nullable|string',
            'status' => 'required|in:MENUNGGU_VERIFIKASI,DIPERIKSA,DIVERIFIKASI,FINAL',
        ]);

        $oldValues = [
            'admin_severance_amount' => $calculation->admin_severance_amount,
            'admin_upmk_amount' => $calculation->admin_upmk_amount,
            'admin_uph_amount' => $calculation->admin_uph_amount,
            'admin_total_amount' => $calculation->admin_total_amount,
            'status' => $calculation->status,
        ];

        $calculation->fill($validated);

        if ($validated['status'] === 'DIVERIFIKASI') {
            $calculation->verified_by = Auth::id();
            $calculation->verified_at = now();
        }

        if ($validated['status'] === 'FINAL') {
            $calculation->verified_by = Auth::id();
            $calculation->verified_at = now();
        }

        $calculation->save();

        foreach ($oldValues as $field => $oldValue) {
            if ($oldValue != $validated[$field]) {
                activity_log(Auth::id(), $calculation->id, 'UPDATE_' . strtoupper($field), $oldValue, $validated[$field]);
            }
        }

        return redirect()->route('admin.verifications.index')
            ->with('success', 'Verifikasi berhasil diperbarui!');
    }

    public function compare(Calculation $calculation)
    {
        return view('admin.verifications.compare', compact('calculation'));
    }

    /**
     * PRD §29 + §41: hitung ulang memakai CalculationService (mesin yang sama
     * dengan user), bukan angka manual admin.
     */
    public function recount(Calculation $calculation, \App\Services\CalculationService $service)
    {
        if ($calculation->status === 'FINAL') {
            return back()->with('error', 'Hasil FINAL terkunci. Gunakan Buat Revisi.');
        }

        $data = [
            'employee_name' => $calculation->employee_name,
            'start_date' => $calculation->start_date->format('Y-m-d'),
            'termination_date' => $calculation->termination_date->format('Y-m-d'),
            'identity_number' => $calculation->identity_number,
            'position' => $calculation->position,
            'basic_salary' => $calculation->basic_salary,
            'fixed_allowance' => $calculation->fixed_allowance,
            'non_fixed_allowance' => $calculation->non_fixed_allowance,
            'termination_reason_id' => $calculation->termination_reason_id,
            'cuti_remaining' => $calculation->cuti_remaining,
            'other_rights' => $calculation->other_rights,
            'return_cost' => $calculation->return_cost,
        ];

        $oldTotal = $calculation->admin_total_amount;
        $service->saveCalculation($data, $calculation, 'admin');

        if ($calculation->status === 'MENUNGGU_VERIFIKASI') {
            $calculation->status = 'DIPERIKSA';
            $calculation->save();
        }

        activity_log(Auth::id(), $calculation->id, 'RECOUNT', $oldTotal, $calculation->admin_total_amount);

        return redirect()->route('admin.verifications.compare', $calculation->id)
            ->with('success', 'Hitung ulang selesai. Bandingkan dengan hasil user.');
    }

    /**
     * PRD §32: koreksi hasil FINAL harus lewat revisi agar riwayat terlacak.
     */
    public function revision(Calculation $calculation)
    {
        if ($calculation->status !== 'FINAL') {
            return back()->with('error', 'Hanya hasil FINAL yang bisa direvisi.');
        }

        $old = $calculation->status;
        $calculation->status = 'DIPERIKSA';
        $calculation->save();

        activity_log(Auth::id(), $calculation->id, 'REVISION_OPEN', $old, $calculation->status);

        return redirect()->route('admin.verifications.show', $calculation->id)
            ->with('success', 'Revisi dibuka. Hasil kembali ke DIPERIKSA dan tercatat di audit trail.');
    }
}