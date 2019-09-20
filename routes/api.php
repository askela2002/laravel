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


Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:api'], function () {

    Route::apiResource('user', 'UserController')->except('store');

    Route::apiResource('organization', 'OrganizationController');

    Route::apiResource('vacancy', 'VacancyController');

    Route::post('vacancy-book', 'VacancyController@book');
    Route::post('vacancy-unbook', 'VacancyController@unbook');

    Route::group(['prefix' => 'stats'], function (){
       Route::get('vacancy', 'StatController@vacancies');
       Route::get('organization', 'StatController@organizations');
       Route::get('user', 'StatController@users');
    });
});