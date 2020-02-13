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

Route::get('/', 'HomeController@index');

//Route::get('/recette', 'RecetteController@edit');

Route::get('recette', 'RecetteController@create')->name('recette.create');
Route::post('recette', 'RecetteController@store')->name('recette.store');

Route::post('/login', 'LoginController@loger');

Route::get('/wow', 'RecetteController@store');

Auth::routes();
