<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue (true);
    }

    public function testPublicRoutes()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);

        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testProtectedByAuthRoutes()
    {

        // Note : 302 = redirection
        $response = $this->get('/recette/edition');
        $response->assertStatus (302); // redirection
    }
}
