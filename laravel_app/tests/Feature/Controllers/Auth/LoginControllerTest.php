<?php

namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp():void {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public  function tearDown():void {
        parent::tearDown();
    }

    public function testGetsLoginPage() {
        $response = $this->get('/login');

        $this->assertGuest();
        $response->assertViewIs('auth.login');
        $response->assertStatus(200);
    }

    public function testRedirectsToHomePageIfLoggedIn() {
        $response = $this->actingAs($this->user)->get('/login');

        $response->assertRedirect('/');
    }

    public function testLoginsSuccess() {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($this->user);
    }

    public function testLoginsFail() {
        $response = $this->post('/login', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function testRemmembersLogin(){

        $response = $this->post('/login', [
            'email'     => $this->user->email,
            'password'  => 'password',
            'remember'  => 'checked',
        ]);

        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $this->user->id,
            $this->user->getRememberToken(),
            $this->user->password,
        ]));
        $this->assertAuthenticatedAs($this->user);
    }

    public function testLogoutSuccess() {
        $response = $this->actingAs($this->user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
