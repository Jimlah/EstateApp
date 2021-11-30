<?php

use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\LogOutController;

Route::post('user/login', LoginController::class)->name('user.login');
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    Route::get('user/logout', LogOutController::class)->name('user.logout');
});
