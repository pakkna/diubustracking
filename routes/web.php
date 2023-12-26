<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackendControllers\RouteController;
use App\Http\Controllers\BackendControllers\BusController;
use App\Http\Controllers\BackendControllers\DriverController;
use App\Http\Controllers\BackendControllers\DashboardController;
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

    // Bus Registration
    Route::get('/bus-registration', [BusController::class, 'bus_registration_view']);
    Route::post('/bus-store', [BusController::class, 'busStore'])->name("bus.store");
    Route::post('/bus-list', [BusController::class, 'busList'])->name("bus.list");
    Route::get('/bus-status/{status}/{id}', [BusController::class, 'busStatusChange'])->name("bus.status");
    Route::get('/bus-delete/{id}', [BusController::class, 'busDelete'])->name("bus.delete");

    // Bus Registration
    Route::get('/route-create', [RouteController::class, 'route_create']);
    Route::post('/route-store', [RouteController::class, 'routeStore'])->name("route.store");
    Route::get('/route-list', [RouteController::class, 'routeList'])->name("route.list");
    Route::post('/route-list-data', [RouteController::class, 'routeData'])->name("route.data");
    Route::post('/route-info-get', [RouteController::class, 'routeInfoGet'])->name("route.info.get");
    Route::get('/route-delete/{id}', [RouteController::class, 'routedelete'])->name("route.delete");
});
