<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SocialTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->assertSee('Cassrollton');
        });
    }

    public function testUserCanFollowOtherUser() {}
    public function testUserCanSeeRecommandationRecetteAtHome() {}
    public function testUserCanUnsubscribeToOtherUser() {}
}
