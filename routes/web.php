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

Route::middleware('auth.codigo')->get('/', 'HomeController@index')->name('index');

Route::group(['prefix' => 'login'], function() {
    Route::middleware('guest')->get('/', 'LoginController@login')->name('login');
    Route::post('/signin', 'LoginController@signIn');
    Route::get('/logout', 'LoginController@logout');
});

Route::group(['prefix' => 'usuarios', 'middleware' => 'auth.codigo.admin'], function() {
    Route::get('/', 'UsuarioController@index')->name('usuarios.index');
    Route::get('/buscar', 'UsuarioController@buscar');
    Route::get('/nuevo', 'UsuarioController@nuevo');
    Route::get('/editar/{id}', 'UsuarioController@editar');
    Route::post('/createorupdate', 'UsuarioController@createOrUpdate');
});

Route::group(['prefix' => 'quinielas', 'middleware' => 'auth.codigo.admin'], function() {
    Route::get('/', 'QuinielaController@index')->name('quinielas.index');
    Route::get('/buscar', 'QuinielaController@buscar');
    Route::get('/nuevo', 'QuinielaController@nuevo');
    Route::get('/editar/{id}', 'QuinielaController@editar');
    Route::post('/create', 'QuinielaController@create');
    Route::post('/update/{id}', 'QuinielaController@update');
});