<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $calculations = Calculation::with('user', 'terminationReason')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reports.index', compact('calculations'));
    }
}