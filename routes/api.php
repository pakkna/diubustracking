<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\ApiAuthController;
use App\Http\Controllers\BackendControllers\UserController;
use App\Http\Controllers\BackendControllers\RouteController;

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

// Auth api
Route::group(['middleware' => 'api', 'namespace' => 'App\Http\Controllers\Api\V1\Auth'], function () {

    Route::post('user_registration', [ApiAuthController::class, 'registration']);
    Route::post('user_login', [ApiAuthController::class, 'login_for_user']);
    Route::post('LoginWithThirdPartyApi', [ApiAuthController::class, 'LoginWithThirdPartyApi']);
    Route::any('logout', [ApiAuthController::class, 'logout']);
    Route::post('refresh', [ApiAuthController::class, 'refresh']);
    Route::post('userinfo', [ApiAuthController::class, 'userInfo']);
});

//Afer Login Route List
Route::group(['middleware' => 'api'], function () {

    Route::get('/route-schedule-list', [RouteController::class, 'route_schedule_list']);
    Route::get('/route-wise-bus', [RouteController::class, 'route_wise_bus']);
    Route::get('/active-bus-list/{route_id}', [RouteController::class, 'active_bus_list']);

    //Driver Bus Info
    Route::get('/driver-bus-info', [UserController::class, 'driver_bus_info']);
    Route::post('/driver-bus-location-send', [UserController::class, 'driver_bus_location_post']);
    Route::post('/bus-location-get', [UserController::class, 'bus_location_get']);
});


/* Route::group(['middleware' => 'api', 'namespace' => 'App\Http\Controllers\Api\V1\PayBuilderApi'], function () {

    //Matarial API
    Route::post('/matarials/add', [HomebuilderController::class, 'matarials_create']);

    Route::post('/matarial/show_and_delete', [HomebuilderController::class, 'show_and_delete_matarial_data']);

    Route::post('/matarial/update', [HomebuilderController::class, 'matarial_update']);

    Route::post('/matarials/list', [HomebuilderController::class, 'matarials_lists']);

    //Transaction API
    Route::post('/transaction/create', [HomebuilderController::class, 'transaction_create']);

    Route::post('/transaction/show_and_delete', [HomebuilderController::class, 'show_and_delete_transaction_data']);

    Route::post('/transaction/update', [HomebuilderController::class, 'transaction_update']);

    Route::post('/transaction/list', [HomebuilderController::class, 'transaction_lists']);

    //Category Page Api

    Route::get('/category-list/{user_id}', [HomebuilderController::class, 'category_list']);

    // Home page Api

    Route::get('/home-page-data/{user_id}', [HomebuilderController::class, 'home_page_data']);

    //Estimate info and update
    Route::get('/setup-info/{user_id}', [HomebuilderController::class, 'setup_info']);
    Route::post('/estimate-update', [HomebuilderController::class, 'estimate_update']);
});

 */
