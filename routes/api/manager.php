<?php


Route::group(['prefix' => 'manager', 'middleware' => ['auth:manager-api', 'scopes:manager']], function () {
});
