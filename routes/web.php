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



/*Route::get('/', function () {
    return view('login.form');
})
->name('inicio');*/
//incio de sesión
Route::get('/', 'Auth\LoginController@showLogin')->middleware('guest');

Route::get('/welcome', 'WelcomeController@index')->name('welcome');

Route::post('/login','Auth\LoginController@login')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/storage', 'FileController@index')->name('storage');
Route::post('/load', 'FileController@load');
Route::delete('/storage/{id}','FileController@destroy')
->where('id','[0-9]+');


Route::post('/excel','ExcelController@procesar')->name('excel');


//certificados
Route::get('/certificates','CertificateController@index')->name('certificates');

Route::post('/certificates','CertificateController@store');

Route::get('/certificates/nueva','CertificateController@create')
->name('certificates.create');

Route::get('/certificates/{codigo}','CertificateController@show')
->where('codigo','[0-9]+')
->name('certificates.show');

Route::get('/certificates/editar/{codigo}','CertificateController@edit')
->where('codigo','[0-9]+')
->name('certificates.edit');

Route::put('/certificates/{codigo}','CertificateController@update')
->name('certificates.update');

//usuarios
Route::get('/users','Auth\RegisterController@index')->name('users');

Route::post('/users','Auth\RegisterController@store');

Route::get('/users/nueva','Auth\RegisterController@new')
->name('users.new');

Route::get('/users/{codigo}','Auth\RegisterController@show')
->where('codigo','[0-9]+')
->name('users.show');

Route::get('/users/editar/{codigo}','Auth\RegisterController@edit')
->where('codigo','[0-9]+')
->name('users.edit');

Route::put('/users/{codigo}','Auth\RegisterController@update')
->name('users.update');

//ruta para consulta externa
Route::get('/consulta/{placa}',array('middleware' => 'cors', 'uses' => 'ConsultaController@consulta'));
