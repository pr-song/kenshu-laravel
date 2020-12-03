<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Article;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUsersTableHasExpectedColumns() {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'name', 'email', 'address', 'email_verified_at', 'password', 'remember_token'
            ]), 1);
    }

    public function testOneUserHasManyArticles() {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);

        $this->assertTrue($user->articles->contains($article));
        $this->assertEquals(1, $user->articles->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->articles);
    }
}
