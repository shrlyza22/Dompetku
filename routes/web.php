<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('transactions/export/csv', [TransactionController::class, 'exportCsv'])->name('transactions.export.csv');
    Route::get('transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    Route::resource('transactions', TransactionController::class);
    Route::resource('wallets', WalletController::class)->only(['index', 'store', 'destroy']);
});

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/set-locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('set-locale');

require __DIR__.'/auth.php';
