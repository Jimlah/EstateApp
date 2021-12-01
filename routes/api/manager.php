<?php

use App\Http\Controllers\Manager\AdminController;
use App\Http\Controllers\Manager\Auth\LogInController;
use App\Http\Controllers\Manager\Auth\LogOutController;
use App\Http\Controllers\Manager\HouseController;

Route::post('manager/login', LogInController::class)->name('manager.login');
Route::group(['prefix' => 'manager', 'middleware' => ['auth:manager-api', 'scopes:manager'], 'as' => 'manager.'], function () {
    Route::get('/logout', LogOutController::class)->name('logout');

    Route::apiResource('managers', AdminController::class);
    Route::apiResource('houses', HouseController::class);
});
