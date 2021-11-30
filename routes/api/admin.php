<?php

use App\Http\Controllers\Admin\Auth\LogInController;
use App\Http\Controllers\Admin\Auth\LogOutController;

Route::post('admin/login', LogInController::class)->name('admin.login');
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    Route::get('logout', LogOutController::class)->name('admin.logout');
});
