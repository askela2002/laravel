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
    Route::group(['prefix' => 'user'], function () {
        Route::get('{id}', 'UserController@show');
        Route::get('', 'UserController@index');
        Route::put('{id}', 'UserController@update');
        Route::delete('{id}', 'UserController@destroy');
    });

    Route::group(['prefix' => 'organization'], function () {
        Route::get('', 'OrganizationController@index');
        Route::post('', 'OrganizationController@store');
        Route::get('{id}', 'OrganizationController@show');
        Route::put('{id}', 'OrganizationController@update');
        Route::delete('{id}', 'OrganizationController@destroy');
    });

    Route::group(['prefix' => 'vacancy'], function () {
        Route::get('', 'VacancyController@index');
        Route::post('', 'VacancyController@store');
        Route::get('{id}', 'VacancyController@show');
        Route::put('{id}', 'VacancyController@update');
        Route::delete('{id}', 'VacancyController@destroy');
    });

    Route::post('vacancy-book', 'VacancyController@book');
    Route::post('vacancy-unbook', 'VacancyController@unbook');

    Route::group(['prefix' => 'stats'], function (){
       Route::get('vacancy', 'StatController@vacancy');
       Route::get('organisation', 'StatController@organisation');
       Route::get('user', 'StatController@user');
    });
});