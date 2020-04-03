<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Recette;
use App\User;
use App\Feedback;

class NotesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPutMarkOnRecetteIfLogin()
    {
        $user = factory(User::class)->create();
        $recette = factory (Recette::class)->make ();

        $note = factory(Note::class)->make();
         
        $response = $this->post('/note', [$user->id, $recette->id,]);
        $response -> assertSuccessful ();

        $this ->assertDatabaseHas ('feedback', ['user_id' => $req->titre, 'text' => $req->text]);

        $response->assertStatus(200);
    }
}
