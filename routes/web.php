<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth.codigo')->get('/', 'UsuarioController@index');

Route::group(['prefix' => 'usuario'], function() {
    Route::middleware('guest')->get('/login', 'UsuarioController@login');
    Route::post('/signin', 'UsuarioController@signIn');
});