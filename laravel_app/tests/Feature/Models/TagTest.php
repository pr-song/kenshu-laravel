<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\Tag;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUsersTableHasExpectedColumns() {
        $this->assertTrue(
            Schema::hasColumns('tags', [
                'name'
            ]), 1);
    }

    public function testOneTagBelongsToManyArticles() {
        $tag = factory(Tag::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $tag->articles);
    }
}
