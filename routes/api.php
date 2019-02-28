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

Route::middleware('cors')->options('{any?}', function ($any = null) {
    return response(['options' => true  ], 200);
})->where('any', '.*');

Route::group(['prefix' => 'auth', 'middleware' =>['cors']], function () {
    Route::post('login', 'API\LoginController@login');
});

Route::group(['prefix' => 'quinielas', 'middleware' =>['cors', 'auth:api']], function () {
    Route::get('/', 'API\QuinielaController@index');
    Route::get('/{id_quiniela}', 'API\QuinielaController@detalleQuiniela');
});