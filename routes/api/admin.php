<?php

use App\Http\Controllers\Admin\EstateController;
use App\Http\Controllers\ValidateTokenController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;

Route::post('admin/login', LogInController::class)->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin'], 'as' => 'admin.'], function () {
    Route::get('validate-token', ValidateTokenController::class)->name('validate-token');
    Route::get('logout', LogOutController::class)->name('logout');
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::apiResource('estates', EstateController::class);
});
