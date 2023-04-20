<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_screen_can_be_rendered(){
        $response = $this -> get('/login');
        $response -> assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(){
        $user = User::factory() -> create();
        $response = $this -> get('/login', [
            'email' => $user -> email,
            'password' => $user -> password
        ]);

        $response -> assertAuthenticated();
        $response -> assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(){
        $user = User::factory() -> create();

        $response = $this -> get('/login', [
            'email' => $user -> email,
            'password' => 'helloworld'
        ]);        

        $this -> assertGuest();
    }
}
