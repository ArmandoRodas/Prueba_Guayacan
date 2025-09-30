<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Algoritmos\FactorialController;
use App\Http\Controllers\Algoritmos\AmortizacionController;
use App\Http\Controllers\Algoritmos\BinomioController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceStatusController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceItemController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('algoritmos')->name('alg.')->group(function () {
    Route::match(['get', 'post'], '/factorial',    FactorialController::class)->name('factorial');
    Route::match(['get', 'post'], '/amortizacion', AmortizacionController::class)->name('amort');
    Route::match(['get', 'post'], '/binomio',      BinomioController::class)->name('binomio');
});

//Ruta marcas
Route::resource('brands', BrandController::class)->names('brands');
//Ruta tipos de diospositivos
Route::resource('device-types', DeviceTypeController::class)->names('device-types');
//Ruta cliente
Route::resource('clients', ClientController::class)->names('clients');
//Ruta usuarios
Route::resource('users', UserController::class)->names('users');
//Ruta Estado de servicios
Route::resource('service-statuses', ServiceStatusController::class)->names('service-statuses');
//Ruta Dispositivos
Route::resource('devices', DeviceController::class)->names('devices');
//Ruta Servicios
Route::resource('services', ServiceController::class)->names('services');
//Ruta service items
Route::prefix('services/{service}')
    ->name('services.')
    ->group(function () {
        Route::resource('items', ServiceItemController::class)
            ->parameter('items', 'item')
            ->names('items')
            ->except(['show']);
    });
