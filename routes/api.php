<?php

use App\Http\Controllers\Api\FilterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/filter/findDtKt', [FilterController::class, 'findDtKt'])->name('filter.findDtKt');
Route::get('/filter/selectYear', [FilterController::class, 'selectYear'])->name('filter.selectYear');
Route::get('/filter/selectMonth', [FilterController::class, 'selectMonth'])->name('filter.selectMonth');
