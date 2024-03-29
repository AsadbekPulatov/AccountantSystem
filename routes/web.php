<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.master');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/download/report/write', [DownloadController::class, 'write'])->name('download.report.write');
    Route::get('/download/report/calculate', [DownloadController::class, 'calculate'])->name('download.report.calculate');
    Route::get('/download/report/debts', [DownloadController::class, 'debt'])->name('download.report.debts');

    Route::get('/reports/calculate', [ReportController::class, 'calculate'])->name('reports.calculate');
    Route::resource('users', UserController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('debts', DebtController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
