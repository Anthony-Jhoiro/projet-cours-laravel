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

Route::redirect('/', '/home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@filtre')->name('home');


Route::middleware(['auth']) -> group(function () {
    Route::post('recette', 'RecetteEditionController@store')->name('recette.store');
    Route::patch('recette/{id}', 'RecetteController@update')->name('recette.update');
    Route::get('recette/edition', 'RecetteController@create')->name('recette.create');
    Route::get('recette/edition/{id}', 'RecetteController@edit')->name('recette.edit');
    Route::post('ingredients', 'IngredientController@store')->name('ingredients.store');

    Route::post('preferences', 'PreferencesController@store')->name('preferences.store');
    Route::delete('recette/{id}', 'RecetteController@delete')->name('recette.delete');

    Route::get('profile', 'UserController@index')->name('profile.edit');

    Route::delete('/social/{id}', 'SocialController@unFollow')->name('social.unFollow');
    Route::post('/social', 'SocialController@follow')->name('social.follow');

    Route::post('/note', 'NotesController@store');
    Route::post('photo', 'PhotoController@store');
});


Route::get('recette/{id}', 'RecetteController@index');

Route::get('recettes/{nom}',  'RecetteController@list')->name('recette.liste');

Route::post('/login', 'LoginController@loger');

Route::get('/wow', 'RecetteController@store');


Auth::routes();


Route::get('/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/callback', 'SocialAuthGoogleController@callback');

Route::get('/ingredients', 'IngredientController@get');


