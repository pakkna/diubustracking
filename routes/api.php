<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\ApiAuthController;
//use App\Http\Controllers\Api\V1\PayBuilderApi\PayBuilderController;
use App\Http\Controllers\Api\V1\PayBuilderApi\HomebuilderController;
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
    Route::get('/clear', [ApiAuthController::class, 'cache_clear']);
});

//Home Builder Api

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
