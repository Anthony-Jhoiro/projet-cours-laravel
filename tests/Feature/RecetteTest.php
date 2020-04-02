<?php

namespace Tests\Feature;

use App\Recette;
use App\User;
use App\Ingredients;
use App\Categorie;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->assertTrue (1 + 1 == 2);
    }

//    public function testUserCanCreateRecette() {
//        $recette = factory (Recette::class)->make ();
//    }

    // TODO : implement
   public function testUserCanCreateRecette() {
       $user = factory(User::class)->create();
       $req = factory (Recette::class)->make ();

       // création des ingrédients test
       $newIngredients = [];
       $ingredientsLibelle = $req->ingredients;
       foreach ($ingredientsLibelle as $ingredientLibelle) {
           $ingredient = factory(Ingredients::class)->create();
           $id = $ingredient->id;
           array_push($newIngredients, $id);
       }
       $req->ingredients = $newIngredients;

       // création des catégories test
       $newCategories = [];
       $categoriesLibelle = $req->categories;
       foreach ($categoriesLibelle as $categorieLibelle) {
           $categorie = factory(Categorie::class)->create();
           $id = $categorie->id;
           array_push($newCategories, $id);
       }
       $req->categories = $newCategories;

       $response = $this -> actingAs ($user) -> post ('/recette', $req->getAttributes ());
       $response -> assertSuccessful ();

       $this ->assertDatabaseHas ('recettes', ['titre' => $req->titre, 'text' => $req->text]);
   }

    public function testUserCanNotCreateRecetteIfNotLogin() {
        $req = factory (Recette::class)->make ();
        $response = $this -> post ('/recette', $req->getAttributes ());

        $response -> assertRedirect ();
    }

    public function testUserCanUploadImages() {
        // TODO : implement
        $this ->assertTrue (true);
    }



}
