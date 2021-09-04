<?php

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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::group(['middleware' =>['auth']],function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients');
    Route::get('/client/{slug}', [App\Http\Controllers\ClientController::class, 'show'])->name('client.show');
    Route::post('/client', [App\Http\Controllers\ClientController::class, 'store'])->name('client.create');
    Route::put('/client/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/{id}', [App\Http\Controllers\ClientController::class, 'delete'])->name('client.delte');

    Route::get('/parking', [App\Http\Controllers\ParkingController::class, 'index'])->name('parking');
    Route::get('/parking/{id}', [App\Http\Controllers\ParkingController::class, 'show'])->name('parking.show');
    Route::post('/parking', [App\Http\Controllers\ParkingController::class, 'store'])->name('parking.create');
    Route::put('/parking/{id}', [App\Http\Controllers\ParkingController::class, 'update'])->name('parking.update');
    Route::delete('/parking/{id}', [App\Http\Controllers\ParkingController::class, 'delete'])->name('parking.delete');

    Route::get('/pick-up-parking', [App\Http\Controllers\PickUpParkingController::class, 'index'])->name('pick_up_parking');
    Route::post('/pick-up-parking', [App\Http\Controllers\PickUpParkingController::class, 'store'])->name('pick_up_parking.create');
    Route::delete('/pick-up-parking/{id}', [App\Http\Controllers\PickUpParkingController::class, 'delete'])->name('pick_up_parking.delete');

    Route::get('/report', [App\Http\Controllers\ReportController::class, 'report'])->name('report');
    Route::get('/report/search', [App\Http\Controllers\ReportController::class, 'reportSearch'])->name('report.search');
});