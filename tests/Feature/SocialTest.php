<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SocialTest extends TestCase
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

    public function testUserCanFollowOtherUsers()
    {
        $user1 = factory (User::class)->create ();
        $user2 = factory (User::class)->create ();

        $response= $this->actingAs ($user2) ->post ('/social', ['id' => $user1->id]);

        $this->assertDatabaseHas ('abonner', ['abonne' => $user1->id, 'suivi' =>$user2->id]);
    }

    public function testUserCanUnFollowOtherUser()
    {

        $user1 = factory (User::class)->create ();
        $user2 = factory (User::class)->create ();

        $response= $this->actingAs ($user2) ->post ('/social', ['id' => $user1->id]);
        $response->assertSuccessful ();
        $response= $this->actingAs ($user2) ->delete ('/social/'.$user1->id);
        $response->assertSuccessful ();

        $this->assertDatabaseMissing ('abonner', ['abonne' => $user1->id, 'suivi' =>$user2->id]);
    }
}
