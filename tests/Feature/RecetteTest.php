<?php

namespace Tests\Feature;

use App\Assets;
use App\Recette;
use App\User;
use App\Ingredients;
use App\Categorie;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Factory\Faker;
use Tests\TestCase;

class RecetteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Vérifier que la page de test est bien fonctionnelle
        $this -> assertTrue ( 1 + 1 == 2 );
    }

    public function testUserCanCreateRecette()
    {

        // Création de l'utitilisateur et de la recette
        $user = factory ( User::class ) -> create ();
        $recette = factory ( Recette::class ) -> make ();

        // création des ingrédients test
        $nbIngredients = 5;
        $Ingredients = [];
        for ($i = 0; $i < $nbIngredients; $i++) {
            $ingredient = factory ( Ingredients::class ) -> create ();
            $id = $ingredient -> id;
            array_push ( $Ingredients, $id );
        }
        $recette -> ingredients = $Ingredients;

        // création des catégories test
        $nbCats = 2;
        $categories = [];
        for ($i = 0; $i < $nbCats; $i++) {
            $categorie = factory ( Categorie::class ) -> create ();
            $id = $categorie -> id;
            array_push ( $categories, $id );
        }
        $recette -> categories = $categories;

        $response = $this -> actingAs ( $user ) -> post ( '/recette', $recette -> getAttributes () );
        $response -> assertSuccessful ();

        // Vérification de l'insertion de la recette
        $this -> assertDatabaseHas ( 'recettes', [ 'titre' => $recette -> titre, 'text' => $recette -> text ] );

        // Récupération de l'id de la recette inséré
        $recetteId = Recette::first() -> id;

        // Vérification de la création des assets
        $this -> assertDatabaseHas ('assets', ['url' => $recette->photoUrls[0], 'recette_id' => $recetteId]);

        // Vérification de l'assignation des categories
        $this -> assertDatabaseHas ('recette_categorie', ['id_categorie' => $categories[0], 'id_recette' => $recetteId]);

        // Vérification de l'assignation des ingrédients
        $this -> assertDatabaseHas ('recette_ingredient', ['id_ingredient' => $Ingredients[0], 'id_recette' => $recetteId]);
    }

    public function testUserCanNotCreateRecetteIfNotLogin()
    {
        $req = factory ( Recette::class ) -> make ();
        $response = $this -> post ( '/recette', $req -> getAttributes () );

        $response -> assertRedirect ();
    }


}
