<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Recette;
use App\User;
use App\Feedback;

use Illuminate\Support\Facades\Log;

class feedbacksTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPutMarkOnRecetteIfLogin()
    {
        $user = factory(User::class)->create();
        $auteur = factory(User::class)->create();
        $recette = factory (Recette::class);

        $testRecette = new Recette([
            "titre" => $recette->titre,
            "text" => $recette->text,
            "auteur" => $auteur->id,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]);

        $testRecette->create();

        $feedback = factory(Feedback::class)->create();

        $feedback->recette_id = $recette->id;
         
        $response = $this-> actingAs ($user) ->post('/note', $feedback->getAttributes());
        $response -> assertSuccessful ();

        $this ->assertDatabaseHas ('feedback', ['user_id' => $feedback->user_id, 'recette_id' => $feedback->recette_id]);
    }
}
