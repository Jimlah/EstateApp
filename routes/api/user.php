<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\VisitorController;
use App\Http\Controllers\ValidateTokenController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogOutController;

Route::post('user/login', LoginController::class)->name('user.login');
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user'], "as" => 'user.'], function () {
    Route::get('validate-token', ValidateTokenController::class)->name('validate-token');
    Route::get('logout', LogOutController::class)->name('user.logout');
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::apiResource('users', UserController::class);
    Route::apiResource('vehicles', VehicleController::class)->except(['show']);
    Route::apiResource('visitors', VisitorController::class);
});
