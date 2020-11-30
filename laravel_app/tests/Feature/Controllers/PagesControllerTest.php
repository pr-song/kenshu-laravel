<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PagesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex() {
        $response = $this->get(route('home'));

        $response->assertViewIs('home');
        $response->assertViewHas('articles');
        $response->assertStatus(200);
    }
}
