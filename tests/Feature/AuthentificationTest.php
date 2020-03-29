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

// TODO : rework

//    public function testUserCanLoginWithCorrectCredentials() {
//        $user = factory (User::class)->create([
//            'password' => bcrypt ($password = 'i-love-everything-but-laravel')
//        ]);
//
//        $response = $this->post ('/login', [
//            'email' => $user->email,
//            'password' => $password
//        ]);
//
//        $response->assertRedirect ('/home');
//        $response->assertAuthenticateAs($user);
//    }

// TODO : rework too

//    public function testUserCanNotLoginWithIncorrectPassword()
//    {
//        $user = factory (User::class) -> create ([
//            'password' => bcrypt('i-love-everything-but-laravel')
//        ]);
//
//        $response = $this->from('/login')->post('/login', [
//            'email' => $user->email,
//            'password' => 'invalid-password',
//        ]);
//
//        $response->assertRedirect('/login');
//        $response->assertSessionHasErrors('email');
//        $this->assertTrue(session()->hasOldInput('email'));
//        $this->assertFalse(session()->hasOldInput('password'));
//        $this->assertGuest();
//    }

}
