<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Auth\LoginController;

class AuthentificationTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue (true);

//        $this->userCanAccessLoginForm ();
//        $this->userCanNotAccessL/oginFormIfLogin ();
//        $this->userCanLoginWithCorrectCredentials ();
    }

    public function testUserCanAccessLoginForm()
    {
        $response = $this->get('/login');
        $response->assertSuccessful ();
        $response->assertViewIs ('auth.login');
    }

    public function testUserCanNotAccessLoginFormIfLogin()
    {
        $user = factory (User::class)->make ();
        $response = $this->actingAs ($user) -> get('/login');

        $response->assertRedirect ('/home');
    }

}
