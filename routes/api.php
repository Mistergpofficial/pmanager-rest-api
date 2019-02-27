<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::post('register', 'Api\Auth\RegisterController@register');

Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
// when the user is logged in then show all these routes

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');
    Route::get('/user', function (Request $request) {
        //return $request->user();
        return auth()->user();
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'Api\CompaniesController@index');/*
        Route::post('/create', 'Api\CompaniesController@store');
        Route::get('/{company}','Api\CompaniesController@show');
        Route::post('/{company}/edit','Api\CompaniesController@update');
        Route::delete('/{company}/delete','Api\CompaniesController@destroy');*/

    });

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', 'Api\CompaniesController@index');
        Route::post('/create', 'Api\CompaniesController@store');
        Route::get('/{company}','Api\CompaniesController@show');
        Route::post('/{company}/edit','Api\CompaniesController@update');
        Route::delete('/{company}/delete','Api\CompaniesController@destroy');

    });

    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', 'Api\ProjectsController@index');
        Route::post('/create', 'Api\ProjectsController@store');
        Route::post('/create1', 'Api\ProjectsController@store1');
        Route::get('/{id}','Api\ProjectsController@show');
        Route::post('/{project}/edit','Api\ProjectsController@update');
        Route::delete('/{project}/delete','Api\ProjectsController@destroy');
        Route::post('/adduser', 'Api\ProjectsController@adduser');


    });

    Route::group(['prefix' => 'comments'], function () {
     //   Route::get('/', 'Api\ProjectsController@index');
        Route::post('/create', 'Api\CommentsController@store');


    });


});


