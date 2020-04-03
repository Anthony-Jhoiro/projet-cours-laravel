<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Recette;
use App\User;
use App\Feedback;

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
        $user = factory(User::class)->make();
        $recette = factory (Recette::class)->make ();

        $feedback = factory(Feedback::class)->make();

        $feedback->recette_id = $recette->id;
        $feedback->commentaire = null;
         
        $response = $this-> actingAs ($user) ->post('/note', $feedback->getAttributes());
        $response -> assertSuccessful ();

        $this ->assertDatabaseHas ('feedback', ['user_id' => $feedback->user_id, 'recette_id' => $feedback->recette_id]);
    }
}
