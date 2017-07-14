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


Route::group(['middleware' => 'auth:api'], function (){
    Route::get('events','EventsController@index');
    Route::post('events/create','EventsController@create');
    Route::get('users','UsersController@index');

    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/user/create', 'UsersController@create');
    Route::post('/user/remove', 'UsersController@remove');
});