<?php

use App\Http\Controllers\Admin\EstateController;
use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;

Route::post('admin/login', LogInController::class)->name('admin.login');
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin'], 'as' => 'admin.' ], function () {
    Route::get('logout', LogOutController::class)->name('logout');

    Route::resource('estates', EstateController::class);
});
