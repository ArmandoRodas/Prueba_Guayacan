<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Algoritmos\FactorialController;
use App\Http\Controllers\Algoritmos\AmortizacionController;
use App\Http\Controllers\Algoritmos\BinomioController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('algoritmos')->name('alg.')->group(function () {
    Route::match(['get','post'], '/factorial',    FactorialController::class)->name('factorial');
    Route::match(['get','post'], '/amortizacion', AmortizacionController::class)->name('amort');
    Route::match(['get','post'], '/binomio',      BinomioController::class)->name('binomio');
});
