<?php

namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp():void {
        parent::setUp();
    }

    public  function tearDown():void {
        parent::tearDown();
    }

    public function testGetsRegisterPage() {
        $response = $this->get('/register');

        $this->assertGuest();
        $response->assertViewIs('auth.register');
        $response->assertStatus(200);
    }

    public function testRedirectsToHomePageIfLoggedIn() {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/');
    }

    public function testRegistersWithValidData() {
        $name = $this->faker->name;
        $email = $this->faker->safeEmail;
        $address = 'user address';
        $password = $this->faker->password();

        $response = $this->post('/register', [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertRedirect('/');
        $user = User::where('email', $email)->where('name', $name)->first();
        $this->assertNotNull($user);
        $this->assertAuthenticatedAs($user);
    }

    public function testRegistersWithInValidData() {
        $response = $this->post('/register', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }
}
