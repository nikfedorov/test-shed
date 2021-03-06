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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('authenticate', 'AuthController@authenticate')->name('api.authenticate');
    Route::post('register', 'AuthController@register')->name('api.register');
});

/**
 * Users CRUD routes
 */
Route::group(['middleware' => ['api', 'auth'], 'prefix' => 'users'], function () {
    Route::get('','UsersController@index')->name('api.users.index');
    Route::post('', 'UsersController@create')->name('api.users.create');
    Route::put('{id}', 'UsersController@update')->name('api.users.update');
    Route::delete('{id}', 'UsersController@delete')->name('api.users.delete');
});
