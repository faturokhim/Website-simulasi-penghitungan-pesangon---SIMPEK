<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CalculatorController;
use App\Http\Controllers\User\ResultController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CalculatorController as AdminCalculator;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\RulesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RegulationsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReasonsController;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/hitung', [CalculatorController::class, 'index'])->name('user.calculator');
    Route::post('/hitung', [CalculatorController::class, 'store'])->name('user.calculator.store');
    Route::get('/hasil/{calculation}', [ResultController::class, 'show'])->name('user.result');
    Route::get('/hasil/{calculation}/pdf', [PdfController::class, 'user'])->name('user.result.pdf');
    Route::post('/hasil/{calculation}/ajukan', [ResultController::class, 'submit'])->name('user.result.submit');
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('user.history');
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');
    Route::get('/peraturan', function () {
        return view('user.regulations');
    })->name('user.regulations');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/hitung', [AdminCalculator::class, 'index'])->name('calculator');
    Route::post('/hitung', [AdminCalculator::class, 'store'])->name('calculator.store');
    Route::get('/hitung/{calculation}', [AdminCalculator::class, 'show'])->name('calculations.show');
    Route::get('/hitung/{calculation}/pdf', [PdfController::class, 'admin'])->name('calculations.pdf');
    Route::get('/penghitungan', function () {
        return view('admin.calculations');
    })->name('calculations.index');
    Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifications.index');
    Route::get('/verifikasi/{calculation}', [VerificationController::class, 'show'])->name('verifications.show');
    Route::put('/verifikasi/{calculation}', [VerificationController::class, 'update'])->name('verifications.update');
    Route::get('/verifikasi/{calculation}/bandingkan', [VerificationController::class, 'compare'])->name('verifications.compare');
    Route::post('/verifikasi/{calculation}/hitung-ulang', [VerificationController::class, 'recount'])->name('verifications.recount');
    Route::post('/verifikasi/{calculation}/revisi', [VerificationController::class, 'revision'])->name('verifications.revision');
    Route::get('/verifikasi/{calculation}/pdf', [PdfController::class, 'admin'])->name('verifications.pdf');
    Route::get('/user', [UsersController::class, 'index'])->name('users.index');
    Route::put('/user/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::get('/aturan', [RulesController::class, 'index'])->name('rules.index');
    Route::post('/aturan', [RulesController::class, 'store'])->name('rules.store');
    Route::put('/aturan/{rule}', [RulesController::class, 'update'])->name('rules.update');
    Route::delete('/aturan/{rule}', [RulesController::class, 'destroy'])->name('rules.destroy');
    Route::get('/peraturan', [RegulationsController::class, 'index'])->name('regulations.index');
    Route::post('/peraturan', [RegulationsController::class, 'store'])->name('regulations.store');
    Route::put('/peraturan/{regulation}', [RegulationsController::class, 'update'])->name('regulations.update');
    Route::delete('/peraturan/{regulation}', [RegulationsController::class, 'destroy'])->name('regulations.destroy');
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/alasan-phk', [ReasonsController::class, 'index'])->name('reasons.index');
    Route::post('/alasan-phk', [ReasonsController::class, 'store'])->name('reasons.store');
    Route::put('/alasan-phk/{reason}', [ReasonsController::class, 'update'])->name('reasons.update');
    Route::delete('/alasan-phk/{reason}', [ReasonsController::class, 'destroy'])->name('reasons.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';