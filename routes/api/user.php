<?php


Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {});
