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

// Dashboard
Route::redirect('/', '/home');
Route::get('/home', 'HomeController@index')->name('home');

// Routes disponibles si l'utilisateur est authentifié et que son adresse email est vérifiée
Route::middleware(['auth', 'verified']) -> group(function () {
    // --- Gestion des recettes ---
    Route::get('recette/edition', 'Recette\RecetteEditionController@create')->name('recette.create');
    Route::get('recette/edition/{id}', 'Recette\RecetteEditionController@edit')->name('recette.edit');
    Route::post('recette', 'Recette\RecetteController@store')->name('recette.store');
    Route::patch('recette/{id}', 'Recette\RecetteController@update')->name('recette.update');

    // --- Gestion des Ingrédients ---
    Route::post('ingredients', 'IngredientController@store')->name('ingredients.store');
    Route::get('ingredients/recette/{id}', 'IngredientController@getByRecette')->name('assets.by.recette');

    // --- Gestion des assets ---
    Route::post('photo', 'PhotoController@store');
    Route::get('assets/recette/{id}', 'PhotoController@getByRecette')->name('assets.by.recette');

    // --- Gestion des préférences utilisateur ---
    Route::post('preferences', 'PreferencesController@store')->name('preferences.store');
    Route::delete('recette/{id}', 'Recette\RecetteController@delete')->name('recette.delete');
    Route::post('/social', 'SocialController@follow')->name('social.follow');

    // --- Gestion du profile ---
    Route::get('profile', 'UserController@index')->name('profile.edit');
    Route::delete('/social/{id}', 'SocialController@unFollow')->name('social.unFollow');

    // --- Gestion des notes et des commentaires ---
    Route::post('/note', 'FeedbackController@storeNote');
    Route::get('/myNote/{id}', 'FeedbackController@indexMyNote');
    Route::post('/commentaire', 'FeedbackController@storeCommentaire');

    Route::post('photo', 'PhotoController@store');
    Route::get('contact', 'ContactController@index');
    Route::post('contact', 'ContactController@store');

    Route::get('assets/recette/{id}', 'PhotoController@getByRecette')->name('assets.by.recette');
    Route::get('ingredients/recette/{id}', 'IngredientController@getByRecette')->name('assets.by.recette');
    Route::get('categories/recette/{id}', 'CategorieController@getByRecette')->name('cats.by.recette');
});

// --- Formulaire de contact ---
Route::get('contact', 'ContactController@index');
Route::post('contact', 'ContactController@store');

// --- Récupération des informations pour une recette ---
Route::get('recette/{id}', 'Recette\RecetteController@index');
Route::get('recette/categorie/{id}', 'Recette\RecetteController@indexByCategorie');
Route::get('recettes/', 'Recette\RecetteController@indexAll');

Route::get('/noteMoyenne/{id}', 'FeedbackController@indexNoteMoyenne');
Route::get('/commentaires/{id}', 'FeedbackController@indexCommentaires');
Route::get('recettes/{nom}',  'Recette\RecetteController@list')->name('recette.liste');

// --- Récupérations des ingrédients existants ---
Route::get('/ingredients', 'IngredientController@get');

// --- Authentification ---
Route::post('/login', 'LoginController@loger');
Auth::routes(['verify' => true]);






Route::get('/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/callback', 'SocialAuthGoogleController@callback');

Route::get('/ingredients', 'IngredientController@get');
Route::get('/categories', 'CategorieController@get');

