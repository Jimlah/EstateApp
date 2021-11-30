<?php

use App\Http\Controllers\User\Auth\LoginController;

Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    Route::get('login', LoginController::class);
});
