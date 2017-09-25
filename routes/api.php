<?php

use Illuminate\Http\Request;
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


Route::group(['prefix' => '/v1'], function ()
{
    Route::group(['prefix' => '/', 'namespace' => '\Api\v1'], function ()
    {
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');
    });

    Route::group(['prefix' => '/users', 'namespace' => '\Api\v1', 'middleware' => 'auth:api'], function ()
    {
        Route::get('/', 'UserController@getUsers');
        Route::get('/self', 'AccountController@getUser');
        Route::get('/remove/{user}', 'UserController@removeUser');
        Route::post('/update', 'UserController@updateUser');
    });

    Route::group(['prefix' => '/events', 'namespace' => '\Api\v1', 'middleware' => 'auth:api'], function ()
    {
        Route::get('/', 'EventController@getEvents');
        Route::post('/create', 'EventController@create');
    });
});