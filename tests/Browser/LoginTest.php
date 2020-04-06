<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->assertSee('Cassrollton');
        });
    }

    public function testUserCanSeeLoginFormIfNotLogIn(){
        // TODO : Implement
    }
    public function testUserCanNotSeeLoginButtonIfLogIn(){
        $this->browse(function (Browser $browser) {
            $user = factory (User::class)->create ();
            $browser
                ->loginAs ($user)
                ->visit('/home')
                ->assertDontSee('Connexion');
        });
    }

    public function testUserCanSeeLoginButtonIfNotLogIn(){
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/home')
                ->assertSee('Connexion');
        });
    }
    public function testUserCanLoginWithLoginForm(){}
}
