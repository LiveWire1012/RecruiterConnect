<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConnectivityController;

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

Route::prefix('auth')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function() {
    Route::prefix('auth')->post('logout', [AuthController::class, 'logout']);
    Route::get('get-all-users', [UserController::class, 'getAllUsers']);
    Route::middleware('verify_user')->group(function () {
        Route::prefix('user')->group(function() {
            Route::get('user-detail/{id}', [UserController::class, 'getUserDetail']);
            Route::post('delete-user/{id}', [UserController::class, 'deleteUser']);
            Route::put('update-user/{id}', [UserController::class, 'updateUser']);
            Route::put('change-user-status/{id}', [UserController::class, 'changeStatus']);
            Route::get('show-requests', [UserController::class, 'showAllRequests']);
        });

        Route::prefix('connect')->group(function () {
            Route::get('send-request', [ConnectivityController::class, 'connect']);
            Route::post('delete-request', [ConnectivityController::class, 'deleteRequest']);
            Route::put('act-on-request', [ConnectivityController::class, 'actOnRequest']);
        });
    });

});
