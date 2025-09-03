<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('welcome');});
Route::get('/', HomeController::class . '@index')->name('home');
// buses
Route::group(['prefix' => 'buses'], function () {
    Route::get('/', [BusController::class, 'index'])->name('buses');
    Route::post('/edit', [BusController::class, 'edit'])->name('buses.edit');
    Route::post('/store', [BusController::class, 'store'])->name('buses.store');
    Route::post('/update', [BusController::class, 'update'])->name('buses.update');
});
// stations
Route::group(['prefix' => 'stations'], function () {
    Route::get('/', [StationController::class, 'index'])->name('stations');
    Route::post('/store', [StationController::class, 'store'])->name('stations.store');
    Route::post('/update', [StationController::class, 'update'])->name('stations.update');
});
// routes
Route::group(['prefix' => 'routes'], function () {
    Route::get('/', [RouteController::class, 'index'])->name('routes');
    Route::get('/create', [RouteController::class, 'create'])->name('routes.create');
    Route::get('/edit/{route_id}', [RouteController::class, 'edit'])->name('routes.edit');
    Route::post('/store', [RouteController::class, 'store'])->name('routes.store');
    Route::post('/update', [RouteController::class, 'update'])->name('routes.update');
    Route::post('/delete', [RouteController::class, 'deactivate'])->name('routes.delete');
    Route::post('/get-stops', [RouteController::class, 'getRouteStops'])->name('routes.getStops');
});
