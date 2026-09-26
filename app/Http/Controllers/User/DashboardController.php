<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $calculations = Calculation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalCalculations = Calculation::where('user_id', Auth::id())->count();
        $lastCalculation = Calculation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        return view('user.dashboard', compact('calculations', 'totalCalculations', 'lastCalculation'));
    }
}