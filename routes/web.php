<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackendControllers\DashboardController;
use App\Http\Controllers\BackendControllers\DriverController;
use App\Http\Controllers\BackendControllers\HireProcessController;
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

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    //Dashboard Routes
    Route::get('clear', [DashboardController::class, 'all_clear']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Driver Registration
    Route::get('/driver-registration', [DriverController::class, 'registration_view']);
    Route::post('/driver-store', [DriverController::class, 'driverStore'])->name("driver.store");
    Route::get('/registered-drivers', [DriverController::class, 'registered_drivers'])->name("driver.all");
    Route::get('/driver-delete/{user_id}', [DriverController::class, 'driver_delete'])->name("driver.delete");
});
