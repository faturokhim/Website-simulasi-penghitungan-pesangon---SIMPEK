<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function show(Calculation $calculation)
    {
        $this->authorize('view', $calculation);
        $calculation->loadMissing(['terminationReason', 'regulation', 'user']);

        return view('user.result', compact('calculation'));
    }

    /**
     * PRD §31: SIMULASI -> MENUNGGU_VERIFIKASI saat user mengajukan pemeriksaan.
     */
    public function submit(Calculation $calculation)
    {
        $this->authorize('update', $calculation);

        if ($calculation->status !== 'SIMULASI') {
            return back()->with('error', 'Hanya simulasi yang bisa diajukan untuk verifikasi.');
        }

        $old = $calculation->status;
        $calculation->status = 'MENUNGGU_VERIFIKASI';
        $calculation->save();

        activity_log(auth()->id(), $calculation->id, 'SUBMIT_VERIFICATION', $old, $calculation->status);

        return redirect()->route('user.history')->with('success', 'Penghitungan diajukan untuk verifikasi admin.');
    }
}