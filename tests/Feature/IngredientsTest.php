<?php

namespace Tests\Feature;

use App\Ingredients;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/home');

        $response->assertStatus(200);
    }

    public function testUserCanCreateIngredientIfLogIn()
    {
        $user = factory (User::class)->make ();
        $ingredient = factory (Ingredients::class)->make ();

        $rep = $this->actingAs ($user)->post ('/ingredients', $ingredient->getAttributes ());

        $rep->assertSuccessful ();

        $this->assertDatabaseHas ('ingredients', ['libelle' => $ingredient->libelle]);
    }

    public function testUserCanNotCreateIngredientIfLogIn()
    {
        $ingredient = factory (Ingredients::class)->make ();

        $rep = $this->post('/ingredients', $ingredient->getAttributes ());

        $rep->assertRedirect ();

        $this->assertDatabaseMissing ('ingredients', ['libelle' => $ingredient->libelle]);
    }

//    public function testUserCanNotCreateIngredientIfAlreadyExist()
//    {
//        // TODO : to implement
//    }
}
