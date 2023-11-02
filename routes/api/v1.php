<?php

use Illuminate\Support\Facades\Route;

Route::post('/login','UserController@login');
Route::post('/register','UserController@register');

Route::group(['middleware' => ['auth:sanctum']] , function() {
    Route::group(['prefix' => 'blog'] , function() {
        Route::get('/','BlogController@index');
        Route::post('create','BlogController@create');
        Route::get('{blog}/like','BlogController@like');


    });
    Route::get('logout','UserController@logout');

});
