<?php

use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogOutController;
use App\Http\Controllers\User\UserController;

Route::post('user/login', LoginController::class)->name('user.login');
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user'], "as" => 'user.'], function () {

    Route::get('logout', LogOutController::class)->name('user.logout');
    Route::apiResource('users', UserController::class);
});
