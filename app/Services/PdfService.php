<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Calculation;

class PdfService
{
    public function generateUserPdf(Calculation $calculation): \Barryvdh\DomPDF\PDF
    {
        $calculation->loadMissing(['terminationReason', 'regulation', 'user']);
        return Pdf::loadView('pdf.user-result', ['calculation' => $calculation]);
    }

    public function generateAdminPdf(Calculation $calculation): \Barryvdh\DomPDF\PDF
    {
        $calculation->loadMissing(['terminationReason', 'regulation', 'user', 'verifiedBy']);
        return Pdf::loadView('pdf.admin-result', ['calculation' => $calculation]);
    }
}