<?php

use Illuminate\Support\Facades\Route;

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
});
