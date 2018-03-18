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
    Route::post('/eliminar', 'UsuarioController@eliminar');
    Route::get('/autocomplete', 'UsuarioController@autocomplete');
});


Route::middleware('auth.codigo')->get('/usuarios/editar/{id}', 'UsuarioController@editar');
Route::middleware('auth.codigo')->post('/usuarios/createorupdate', 'UsuarioController@createOrUpdate');

Route::group(['prefix' => 'quinielas', 'middleware' => 'auth.codigo.admin'], function() {
    Route::get('/', 'QuinielaController@index')->name('quinielas.index');
    Route::get('/buscar', 'QuinielaController@buscar');
    Route::get('/nuevo', 'QuinielaController@nuevo');
    Route::get('/editar/{id}', 'QuinielaController@editar');
    Route::post('/create', 'QuinielaController@create');
    Route::post('/update/{id}', 'QuinielaController@update');
    Route::post('/agregarparticipante', 'QuinielaController@agregarParticipante');
    Route::post('/actualizarbolsa', 'QuinielaController@actualizarBolsa');
    Route::post('/datos_jornada_admin', 'QuinielaController@datosJornadaAdmin');
    Route::post('/eliminar', 'QuinielaController@eliminar');
    Route::post('/eliminar_participacion', 'QuinielaController@eliminarParticipacion');
    Route::get('/reponche/{id_participacion}/{id_jornada}', 'QuinielaController@reponche');
    Route::get('/reglas/editar/{id_quiniela}', 'QuinielaController@editarReglas');
    Route::post('/actualizar', 'QuinielaController@actualizar');
});

Route::group(['prefix' => 'ligas', 'middleware' => 'auth.codigo.admin'], function() {
    Route::get('/', 'LigaController@index')->name('ligas.index');
    Route::get('/buscar', 'LigaController@buscar');
    Route::get('/nuevo', 'LigaController@nuevo');
    Route::get('/editar/{id}', 'LigaController@editar');
    Route::get('/detalle/{id}', 'LigaController@detalle');
    Route::post('/eliminar', 'LigaController@eliminar');
    Route::post('/createorupdate', 'LigaController@createOrUpdate');
    Route::post('/update/{id}', 'LigaController@update');
    Route::post('/agregarjornada', 'LigaController@agregarJornada');
    Route::post('/eliminarjornadas', 'LigaController@eliminarJornadas');
});

Route::group(['prefix' => 'equipos', 'middleware' => 'auth.codigo.admin'], function() {
    Route::get('/nuevo', 'EquipoController@nuevo');
    Route::get('/editar/{id}', 'EquipoController@editar');
    Route::post('/createorupdate', 'EquipoController@createOrUpdate');
    Route::post('/eliminar', 'EquipoController@eliminar');
});

Route::group(['prefix' => 'jornadas', 'middleware' => 'auth.codigo.admin'], function() {
    Route::get('/nuevo', 'JornadaController@nuevo');
    Route::get('/editar/{id}', 'JornadaController@editar');
    Route::post('/createorupdate', 'JornadaController@createOrUpdate');
    Route::post('/eliminar', 'JornadaController@eliminar');
    Route::get('/editar/partidos/{id}', 'JornadaController@editarPartidos');
    Route::get('/editar/resultados/{id}', 'JornadaController@editarResultados');
    Route::post('/actualizar_equipos', 'JornadaController@actualizarEquipos');
    Route::post('/actualizar_resultados', 'JornadaController@actualizarResultados');
});


Route::group(['prefix' => 'quinielas', 'middleware' => 'auth.codigo'], function() {
    Route::get('/contestar/{id_jornada}/{id_quiniela}', 'QuinielaController@contestar')->name('contestar');
    Route::post('/contestarquiniela', 'QuinielaController@contestarQuiniela');
    Route::get('/info/{id}', 'QuinielaController@info');
    Route::post('/datos_jornada', 'QuinielaController@datosJornada');
    Route::post('/resultados_jornada', 'QuinielaController@resultadosJornada');
    Route::get('/reglas/{id_quiniela}', 'QuinielaController@reglas');
});