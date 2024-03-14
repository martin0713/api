<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('articles.store'), [
            'title' => 'Test Article Title',
            'body' => 'Test Article Body',
            'records' => ['time' => 1],
            'user_id' => $user->id,
            'image' => 'Test Article Image',
        ]);
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article Title',
            'body' => 'Test Article Body',
            'user_id' => $user->id,
            'image' => 'Test Article Image',
        ]);
    }
    public function testUpdate()
    {
        $user = User::factory()->create();
        $article = new Article;
        $article->title = '';
        $article->body = '';
        $article->records = ['time' => 1];
        $article->user_id = $user->id;
        $article->image = '';
        $article->save();
        $this->actingAs($user)->put(route('articles.update', [$article]), [
            'title' => 'Test Article Title Updated',
            'body' => 'Test Article Body Updated',
            'image' => 'Test Article Image Updated',
            'tags' => [0]
        ]);
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article Title Updated',
            'body' => 'Test Article Body Updated',
            'image' => 'Test Article Image Updated',
        ]);
        $this->assertDatabaseHas('article_tag', [
            'article_id' => $article->id,
            'tag_id' => 0,
        ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $article = new Article;
        $article->title = 'Test Article Title Deleted';
        $article->body = 'Test Article Body Deleted';
        $article->records = ['time' => 1];
        $article->user_id = $user->id;
        $article->image = 'Test Article Image Deleted';
        $article->save();
        $article->tags()->attach(1);

        $this->actingAs($user)->delete(route('articles.destroy', $article));
        $this->assertSoftDeleted('articles', [
            'title' => 'Test Article Title Deleted',
            'body' => 'Test Article Body Deleted',
            'image' => 'Test Article Image Deleted',
        ]);
        $this->assertDatabaseMissing('article_tag', [
            'article_id' => $article->id,
            'tag_id' => 1,
        ]);
    }
}
