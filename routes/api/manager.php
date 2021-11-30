<?php

use App\Http\Controllers\Manager\Auth\LogInController;
use App\Http\Controllers\Manager\Auth\LogOutController;


Route::post('manager/login', LogInController::class)->name('manager.login');
Route::group(['prefix' => 'manager', 'middleware' => ['auth:manager-api', 'scopes:manager']], function () {
    Route::get('/logout', LogOutController::class)->name('manager.logout');
});
