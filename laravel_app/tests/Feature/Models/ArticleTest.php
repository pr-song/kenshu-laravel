<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Article;
use App\Models\Image;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function testArticlesTableHasExpectedColumns() {
        $this->assertTrue(
            Schema::hasColumns('articles', [
                'slug', 'title', 'content', 'thumbnail', 'user_id'
            ]), 1);
    }

    public function testOneArticleBelongsToOneUser() {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);

        $this->assertEquals(1, $article->user->count());
        $this->assertInstanceOf(User::class, $article->user);
    }

    public function testOneArticleBelongsToManyTags() {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $article->tags);
    }

    public function testOneArticleHasManyImages() {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create(['user_id' => $user->id]);
        $image = factory(Image::class)->create(['article_id' => $article->id]);

        $this->assertTrue($article->images->contains($image));
        $this->assertEquals(1, $article->images->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $article->images);
    }
}
