<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecetteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this -> browse ( function ( Browser $browser ) {
            $browser -> visit ( '/home' )
                -> assertSee ( 'Cassrollton' );
        } );
    }

    public function testUserCanAccessRecetteCreationFormIfLogin()
    {
        $this -> browse ( function ( Browser $browser ) {
            $user = factory ( User::class ) -> create ();
            $browser
                -> loginAs ( $user )
                -> visit ( '/home' )
                -> screenshot ( "coucou" )
                -> assertSee ( 'Nouvelle Recette' )
                -> click ( '@nouvelle-recette' )
                -> screenshot ( "coucou" );
        } );
    }


    public function testUserCanCreateRecetteWithRecetteEditionForm()
    {
    }

    public function testUserCanUpdateRecetteWithRecetteEditionForm()
    {
    }

    public function testUserCanDeleteTheirOwnRecette()
    {
    }
}
