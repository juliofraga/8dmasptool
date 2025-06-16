<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->middleware('jwt.auth')->group(function() {
    Route::prefix('user')->group(function () {
        Route::post('/store', 'UserController@store');
        Route::get('/', 'UserController@index');
        Route::get('/{id}', 'UserController@show');
        Route::patch('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
        Route::post('/inactivate/{id}', 'UserController@inactivate');
        Route::post('/activate/{id}', 'UserController@activate');
        Route::get('/all/{active}', 'UserController@getAll');
    });
    Route::prefix('area')->group(function () {
        Route::post('/store', 'AreaController@store');
        Route::get('/', 'AreaController@index');
        Route::get('/{id}', 'AreaController@show');
        Route::patch('/{id}', 'AreaController@update');
        Route::delete('/{id}', 'AreaController@destroy');
        Route::post('/inactivate/{id}', 'AreaController@inactivate');
        Route::post('/activate/{id}', 'AreaController@activate');
        Route::get('/all/{active}', 'AreaController@getAll');
    });
    Route::prefix('incident')->group(function () {
        Route::post('/store', 'IncidentController@store');
        Route::post('/storeteam', 'IncidentController@storeteam');
        Route::get('/team/{visual_id}', 'IncidentController@getteam');
        Route::get('/', 'IncidentController@index');
        Route::get('/{visual_id}', 'IncidentController@show');
        Route::patch('/{visual_id}', 'IncidentController@update');
        Route::get('/exists/{visual_id}', 'IncidentController@exists');
        Route::prefix('containmentaction')->group(function () {
            Route::get('/{visual_id}', 'ContainmentActionController@show');
            Route::post('/store', 'ContainmentActionController@store');
            Route::patch('/{id}', 'ContainmentActionController@update');
            Route::delete('/{id}', 'ContainmentActionController@destroy');
        });
        Route::prefix('rootcausepotential')->group(function () {
            Route::post('/store', 'RootCausePotentialController@store');
            Route::get('/{visual_id}', 'RootCausePotentialController@show');
            Route::delete('/{id}', 'RootCausePotentialController@destroy');
            Route::patch('/{id}', 'RootCausePotentialController@setascausaraiz');
        });
    });
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
});

Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');