<?php

use App\Http\Controllers\Manager\AdminController;
use App\Http\Controllers\Manager\Auth\LogInController;
use App\Http\Controllers\Manager\Auth\LogOutController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\HouseController;
use App\Http\Controllers\Manager\UserHouseController;
use App\Http\Controllers\Manager\VehicleController;
use App\Http\Controllers\Manager\VisitorController;
use Database\Factories\UserHouseFactory;

Route::post('manager/login', LogInController::class)->name('manager.login');
Route::group(['prefix' => 'manager', 'middleware' => ['auth:manager-api', 'scopes:manager'], 'as' => 'manager.'], function () {

    Route::get('/logout', LogOutController::class)->name('logout');
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::apiResource('managers', AdminController::class);
    Route::apiResource('houses', HouseController::class);
    Route::apiResource('visitors', VisitorController::class);
    Route::get('vehicles', VehicleController::class)->name('vehicles');

    Route::group(['prefix' => 'houses', 'as' => 'houses.'], function () {

        Route::apiResource('{house}/users', UserHouseController::class);
    });
});
