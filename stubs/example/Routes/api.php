<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/example', 'ExampleController@index');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1'], function () {
    Route::group(['prefix' => 'examples'], function () {
        Route::get('/', 'ExampleController@index');
        Route::post('/', 'ExampleController@store');
        Route::get('/{id}', 'ExampleController@show')->where('id', '\d+');
        Route::put('/{id}', 'ExampleController@update')->where('id', '\d+');
        Route::delete('/{id}', 'ExampleController@destroy')->where('id', '\d+');
    });
});
