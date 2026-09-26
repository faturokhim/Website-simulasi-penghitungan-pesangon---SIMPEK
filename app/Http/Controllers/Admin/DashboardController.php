<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSimulations = Calculation::where('status', 'SIMULASI')->count();
        $waitingVerification = Calculation::where('status', 'MENUNGGU_VERIFIKASI')->count();
        $verified = Calculation::where('status', 'DIVERIFIKASI')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalSimulations', 'waitingVerification', 'verified'));
    }
}