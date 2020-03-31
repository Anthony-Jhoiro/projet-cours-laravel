<?php

namespace Tests\Feature;

use App\Categorie;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreferencesTest extends TestCase
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

    public function testCanSaveUserPreferences()
    {
        $user = factory (User::class)->create ();
        $categorie = factory (Categorie::class)->create ();

        $rep = $this->actingAs ($user)->post ('/preferences', ['categorie_id' => $categorie->id]);

        $rep->assertSuccessful ();

        $this->assertDatabaseHas ('cats_prefs', ['user_id' => $user->id, 'categorie_id' => $categorie->id, 'nb_visite' => 1]);
    }

    public function testCanUpdateUserPreferences()
    {
        $user = factory (User::class)->create ();
        $categorie = factory (Categorie::class)->create ();

        $this->actingAs ($user)->post ('/preferences', ['categorie_id' => $categorie->id]);
        $rep = $this->actingAs ($user)->post ('/preferences', ['categorie_id' => $categorie->id]);

        $rep ->assertSuccessful ();

        $this->assertDatabaseHas ('cats_prefs', ['user_id' => $user->id, 'categorie_id' => $categorie->id, 'nb_visite' => 2]);
    }
}
