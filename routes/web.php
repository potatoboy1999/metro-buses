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
    Route::post('/store', [BusController::class, 'store'])->name('buses.store');
});
// stations
Route::group(['prefix' => 'stations'], function () {
    Route::get('/', [StationController::class, 'index'])->name('stations');
    Route::post('/store', [StationController::class, 'store'])->name('stations.store');
});
// routes
Route::group(['prefix' => 'routes'], function () {
    Route::get('/', [RouteController::class, 'index'])->name('routes');
    Route::get('/create', [RouteController::class, 'create'])->name('routes.create');
    Route::post('/store', [RouteController::class, 'store'])->name('routes.store');
});
