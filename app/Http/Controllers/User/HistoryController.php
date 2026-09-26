<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Calculation;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $calculations = Calculation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.history', compact('calculations'));
    }
}