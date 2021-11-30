<?php

use App\Http\Controllers\User\Auth\LoginController;

Route::post('user/login', LoginController::class)->name('user.login');
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
});
