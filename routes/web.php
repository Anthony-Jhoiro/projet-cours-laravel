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
    // --- Gestion des recettes ---
    // Page de création
    Route::get('recette/edition', 'Recette\RecetteEditionController@create')->name('recette.create');

    // Page de modification
    Route::get('recette/edition/{id}', 'Recette\RecetteEditionController@edit')->name('recette.edit');


    Route::post('recette', 'Recette\RecetteController@store')->name('recette.store');
    Route::patch('recette/{id}', 'Recette\RecetteController@update')->name('recette.update');


    Route::post('ingredients', 'IngredientController@store')->name('ingredients.store');

    Route::post('preferences', 'PreferencesController@store')->name('preferences.store');
    Route::delete('recette/{id}', 'Recette\RecetteController@delete')->name('recette.delete');

    Route::get('profile', 'UserController@index')->name('profile.edit');

    Route::delete('/social/{id}', 'SocialController@unFollow')->name('social.unFollow');
    Route::post('/social', 'SocialController@follow')->name('social.follow');

    Route::post('/note', 'FeedbackController@storeNote');
    Route::get('/myNote/{id}', 'FeedbackController@indexMyNote');

    Route::post('photo', 'PhotoController@store');
    Route::get('contact', 'ContactController@index');
    Route::post('contact', 'ContactController@store');

    Route::get('assets/recette/{id}', 'PhotoController@getByRecette')->name('assets.by.recette');
    Route::get('ingredients/recette/{id}', 'IngredientController@getByRecette')->name('assets.by.recette');
});

Route::get('/noteMoyenne/{id}', 'FeedbackController@indexNoteMoyenne');


Route::get('recette/{id}', 'Recette\RecetteController@index');

Route::get('recettes/{nom}',  'Recette\RecetteController@list')->name('recette.liste');

Route::post('/login', 'LoginController@loger');

Route::get('/wow', 'Recette\RecetteController@store');


Auth::routes();


Route::get('/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/callback', 'SocialAuthGoogleController@callback');

Route::get('/ingredients', 'IngredientController@get');

