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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


Route::middleware('auth:api')->get('user/{id}', 'UserController@show');
Route::middleware('auth:api')->get('user', 'UserController@index');
Route::middleware('auth:api')->put('user/{id}', 'UserController@update');
Route::middleware('auth:api')->delete('user/{id}', 'UserController@destroy');


Route::middleware('auth:api')->get('organization', 'OrganizationController@index');
Route::middleware('auth:api')->post('organization', 'OrganizationController@store');
Route::middleware('auth:api')->get('organization/{id}', 'OrganizationController@show');
Route::middleware('auth:api')->put('organization/{id}', 'OrganizationController@update');
Route::middleware('auth:api')->delete('organization/{id}', 'OrganizationController@destroy');


Route::middleware('auth:api')->get('vacancy', 'VacancyController@index');
Route::middleware('auth:api')->post('vacancy', 'VacancyController@store');
Route::middleware('auth:api')->get('vacancy/{id}', 'VacancyController@show');
Route::middleware('auth:api')->put('vacancy/{id}', 'VacancyController@update');
Route::middleware('auth:api')->delete('vacancy/{id}', 'VacancyController@destroy');


Route::middleware('auth:api')->post('vacancy-book', 'BookingController@book');
Route::middleware('auth:api')->post('vacancy-unbook', 'BookingController@unbook');
