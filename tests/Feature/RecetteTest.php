<?php

namespace Tests\Feature;

use App\Recette;
use App\User;
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

    public function testUserCanCreateRecette() {
        $user = factory(User::class)->create();
        $req = factory (Recette::class)->make ();

        $this -> actingAs ($user) -> post ('/recette', $req->getAttributes ());

        $this ->assertDatabaseHas ('recettes', ['titre' => $req->titre, 'text' => $req->text]);
    }




}
