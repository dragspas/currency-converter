<?php

use App\Http\Controllers\Api\CurrenciesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('currencies')->name('currencies.')->group(function () {
        Route::get('', [CurrenciesController::class, 'get'])->name('get');
        Route::get('convert', [CurrenciesController::class, 'convert'])->name('convert');
    });
});
