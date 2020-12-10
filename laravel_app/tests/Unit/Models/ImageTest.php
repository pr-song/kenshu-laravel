<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Article;
use App\Models\Image;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUsersTableHasExpectedColumns() {
        $this->assertTrue(
            Schema::hasColumns('images', [
                'path', 'article_id'
            ]), 1);
    }

    public function testOneImageBelongsToOneArticle() {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);
        $image = factory(Image::class)->create(['article_id' => $article->id]);



        
        $this->assertEquals(1, $image->article->count());
        $this->assertInstanceOf(Article::class, $image->article);
    }
}
