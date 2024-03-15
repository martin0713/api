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
        // Arrange
        $user = User::factory()->create();
        // Act
        $this->actingAs($user)->post(route('articles.store'), [
            'title' => 'Test Article Title',
            'body' => 'Test Article Body',
            'records' => ['time' => 1],
            'user_id' => $user->id,
            'image' => 'Test Article Image',
        ]);
        // Assert
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article Title',
            'body' => 'Test Article Body',
            'user_id' => $user->id,
            'image' => 'Test Article Image',
        ]);
    }
    public function testUpdate()
    {
        // Arrange
        $user = User::factory()->create();
        $article = new Article;
        $article->title = '';
        $article->body = '';
        $article->records = ['time' => 1];
        $article->user_id = $user->id;
        $article->image = '';
        $article->save();
        // Act
        $this->actingAs($user)->put(route('articles.update', [$article]), [
            'title' => 'Test Article Title Updated',
            'body' => 'Test Article Body Updated',
            'image' => 'Test Article Image Updated',
            'tags' => [0]
        ]);
        // Assert
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
        // Arrange
        $user = User::factory()->create();
        $article = new Article;
        $article->title = 'Test Article Title Deleted';
        $article->body = 'Test Article Body Deleted';
        $article->records = ['time' => 1];
        $article->user_id = $user->id;
        $article->image = 'Test Article Image Deleted';
        $article->save();
        $article->tags()->attach(1);
        // Act
        $this->actingAs($user)->delete(route('articles.destroy', $article));
        // Assert
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
