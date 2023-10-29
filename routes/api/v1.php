<?php

use Illuminate\Support\Facades\Route;

Route::post('/login','UserController@login');
Route::post('/register','UserController@register');

Route::group(['middleware' => ['auth:sanctum']] , function() {


    Route::get('post','UserController@index');
});
