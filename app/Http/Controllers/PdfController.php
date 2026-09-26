<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Services\PdfService;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function user(Calculation $calculation, PdfService $pdf)
    {
        if (Auth::user()->role !== 'admin' && $calculation->user_id !== Auth::id()) {
            abort(403);
        }

        $calculation->loadMissing(['terminationReason', 'regulation', 'user']);

        return $pdf->generateUserPdf($calculation)
            ->download('SIMPEK-simulasi-' . $calculation->id . '.pdf');
    }

    public function admin(Calculation $calculation, PdfService $pdf)
    {
        if (Auth::user()->role !== 'admin' && $calculation->user_id !== Auth::id()) {
            abort(403);
        }

        $calculation->loadMissing(['terminationReason', 'regulation', 'user', 'verifiedBy']);

        return $pdf->generateAdminPdf($calculation)
            ->download('SIMPEK-verifikasi-' . $calculation->id . '.pdf');
    }
}
