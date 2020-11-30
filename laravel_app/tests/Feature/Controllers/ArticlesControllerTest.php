<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp():void {
        parent::setUp();
        $this->tag1 = factory(Tag::class)->create(['name' => 'qwert']);
        $this->tag2 = factory(Tag::class)->create(['name' => 'prtimes']);
        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create([
            'user_id' => $this->user->id
        ]);
        $this->anotherUser = factory(User::class)->create();
        $this->anotherArticle = factory(Article::class)->create([
            'user_id' => $this->anotherUser->id
        ]);
    }

    public  function tearDown():void {
        parent::tearDown();
    }

    /**
     * indexアクションのテスト
     */
    public function testIndex() {
        $response = $this->get(route('articles.index'));

        $response->assertViewIs('home');
        $response->assertViewHas('articles');
        $response->assertStatus(200);
    }

    /**
     * showアクションのテスト
     */
    public function testShow() {
        $response = $this->get(route('articles.show', ['slug' => $this->article->slug]));
        $data = $response->getOriginalContent()->getData();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $data['article']->images);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $data['article']->tags);
        $response->assertViewIs('articles.show');
        $response->assertViewHas('article');
        $response->assertStatus(200);
    }

    public function testShowError() {
        $response = $this->get(route('articles.show', ['slug' => 'fail']));

        $response->assertRedirect(route('home'));
        $response->assertStatus(302);
        $response->assertSessionHas('message', '記事見つかれません！');
    }

    /**
     * createアクションのテスト
     */
    public function testCreate() {
        $response = $this->actingAs($this->user)->get(route('articles.create'));

        $response->assertViewIs('articles.create');
        $response->assertViewHas('tags');
        $response->assertStatus(200);
    }

    public function testCreateWithoutLogin() {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    /**
     * storeアクションのテスト
     */
    public function testStoreWithoutImage() {
        $title = 'Lorem Ipsum is simply dummy text';
        $content = 'It is a long established fact that a reader will be distracted';
        $response = $this->actingAs($this->user)->from(route('articles.create'))->post(route('articles.store'), [
            'title' => $title,
            'content' => $content,
            'tags' => [$this->tag1->id, $this->tag2->id]
        ]);
        $article = Article::where('title', $title)->first();

        $this->assertNotNull($article);
        $response->assertRedirect(route('articles.myarticles'));
        $response->assertSessionHas('status', '記事作成しました！');
        $this->assertEquals($title, $article->title);
        $response->assertStatus(302);
    }

    public function testStoreWithImages() {
        $title = 'Lorem Ipsum is simply dummy text';
        $content = 'It is a long established fact that a reader will be distracted';
        $response = $this->actingAs($this->user)->from(route('articles.create'))->post(route('articles.store'), [
            'title' => $title,
            'content' => $content,
            'images' => [UploadedFile::fake()->image('image1.jpg'),UploadedFile::fake()->image('image2.jpg'),UploadedFile::fake()->image('image3.jpg')],
            'tags' => [$this->tag1->id, $this->tag2->id],
        ]);
        $article = Article::where('title', $title)->first();

        $this->assertNotNull($article->images);
        $response->assertRedirect(route('articles.myarticles'));
        $response->assertSessionHas('status', '記事作成しました！');
        $this->assertEquals($title, $article->title);
        $response->assertStatus(302);
    }

    public function testStoreWithThumbnailImage() {
        $title = 'Lorem Ipsum is simply dummy text';
        $content = 'It is a long established fact that a reader will be distracted';
        $response = $this->actingAs($this->user)->from(route('articles.create'))->post(route('articles.store'), [
            'title' => $title,
            'content' => $content,
            'images' => [UploadedFile::fake()->image('image1.jpg'),UploadedFile::fake()->image('image2.jpg'),UploadedFile::fake()->image('image3.jpg')],
            'thumbnail_image' => 'image1.jpg',
            'tags' => [$this->tag1->id, $this->tag2->id],
        ]);
        $article = Article::where('title', $title)->first();

        $this->assertNotNull($article->images);
        $this->assertNotNull($article->thumbnail);
        $this->assertEquals($title, $article->title);
        $response->assertRedirect(route('articles.myarticles'));
        $response->assertSessionHas('status', '記事作成しました！');
        $response->assertStatus(302);
    }

    public function testStoreFail() {
        $response = $this->actingAs($this->user)->from(route('articles.create'))->post(route('articles.store'),[
            'title' => 'fail',
            'content' => 'fail',
            'tags' => [],
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
        $response->assertRedirect(route('articles.create'));
    }
    /**
     * myarticlesアクションのテスト
     */
    public function testMyArticles() {
        $response = $this->actingAs($this->user)->get(route('articles.myarticles'));

        $response->assertViewIs('articles.myarticles');
        $response->assertViewHas('articles');
        $response->assertStatus(200);
    }

    public function testMyArticlesWithoutLogin() {
        $response = $this->get(route('articles.myarticles'));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    /**
     * editアクションのテスト
     */
    public function testEdit() {
        $response = $this->actingAs($this->user)->get(route('articles.edit', ['slug' => $this->article->slug]));

        $response->assertViewIs('articles.edit');
        $response->assertViewHas('article');
        $response->assertViewHas('tags');
        $response->assertViewHas('selected_tags');
        $response->assertStatus(200);
    }

    public function testEditWithoutLogin() {
        $response = $this->get(route('articles.edit', ['slug' => $this->article->slug]));

        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testEditWithoutOwner() {
        $response = $this->actingAs($this->user)->get(route('articles.edit', ['slug' => $this->anotherArticle->slug]));

        $response->assertRedirect(route('home'));
        $response->assertStatus(302);
        $response->assertSessionHas('message', '編集権利ありません！');
    }

    public function testEditWithInvalidSlug() {
        $response = $this->actingAs($this->user)->get(route('articles.edit', ['slug' => 'invalid']));

        $response->assertRedirect(route('home'));
        $response->assertStatus(302);
        $response->assertSessionHas('message', '記事見つかれません！');
    }

    /**
     * updateアクションのテスト
     */
    public function testUpdate() {
        $slug = $this->article->slug;
        $title = 'Lorem Ipsum is simply dummy text';
        $content = 'It is a long established fact that a reader will be distracted';
        $response = $this->actingAs($this->user)->from(route('articles.edit', ['slug' => $slug]))->put(route('articles.update', ['slug' => $slug]),[
            'title' => $title,
            'content' => $content,
            'images' => [UploadedFile::fake()->image('image1.jpg'),UploadedFile::fake()->image('image2.jpg'),UploadedFile::fake()->image('image3.jpg')],
            'thumbnail_image' => 'image1.jpg',
            'tags' => [$this->tag1->id, $this->tag2->id],
        ]);
        $article = Article::whereSlug($slug)->first();

        $response->assertSessionHas('status', '記事編集しました！');
        $response->assertRedirect(route('articles.edit', ['slug' => $slug]));
        $this->assertEquals($title, $article->title);
        $response->assertStatus(302);
    }

    public function testUpdateFail() {
        $slug = $this->article->slug;
        $response = $this->actingAs($this->user)->from(route('articles.edit', ['slug' => $slug]))->put(route('articles.update', ['slug' => $slug]),[
            'title' => 'fail',
            'content' => 'fail',
            'tags' => [],
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
        $response->assertRedirect(route('articles.edit', ['slug' => $slug]));
        $response->assertStatus(302);
    }

    /**
     * destroyアクションのテスト
     */
    public function testDestroy() {
        $slug = $this->article->slug;
        $id = $this->article->id;
        $response = $this->actingAs($this->user)->from(route('articles.myarticles'))->delete(route('articles.destroy', ['slug' => $slug]));

        $this->assertDeleted('articles', ['slug' => $slug]);
        $this->assertDeleted('images', ['article_id' => $id]);
        $response->assertSessionHas('status', '記事削除されました！');
        $response->assertRedirect(route('articles.myarticles'));
    }

    public function testDestroyWithInvaliSlug() {
        $response = $this->actingAs($this->user)->from(route('articles.myarticles'))->delete(route('articles.destroy', ['slug' => 'fail']));

        $response->assertSessionHas('message', '記事見つかれません！');
        $response->assertRedirect(route('home'));
    }
}
