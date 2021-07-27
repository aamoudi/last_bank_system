<?php

use App\Http\Controllers\API\UserApiAuthController;
use App\Http\Controllers\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth/')->namespace('API')->group(function () {
    Route::post('login', [UserApiAuthController::class, 'login']);
    Route::post('login-pgt', [UserApiAuthController::class, 'pgtLogin']);
});

Route::prefix('auth/')->middleware('auth:api')->group(function () {
    Route::get('logout', [UserApiAuthController::class, 'logout']);
    Route::get('logout-pgt', [UserApiAuthController::class, 'logoutPgt']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('cities', CityController::class);
});
