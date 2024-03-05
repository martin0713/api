<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class ArticleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user_id = rand(1,3);
        $this->post(route('articles.store'), [
            'title' => 'Test Article Title',
            'body' => 'Test Article Body',
            'user_id' => $user_id,
            'image' => 'Test Article Image',
        ]);
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article Title',
            'body' => 'Test Article Body',
            'user_id' => $user_id,
            'image' => 'Test Article Image',
        ]);
    }
    public function testUpdate()
    {
        $article = new Article;
        $article->title = '';
        $article->body = '';
        $article->records = array('time' => 1);
        $article->user_id = rand(1,3);
        $article->image = '';
        $article->save();

        $this->put(route('articles.update', $article), [
            'title' => 'Test Article Title Updated',
            'body' => 'Test Article Body Updated',
            'image' => 'Test Article Image Updated',
        ]);
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article Title Updated',
            'body' => 'Test Article Body Updated',
            'image' => 'Test Article Image Updated',
        ]);
    }
    public function testDestroy()
    {
        $article = new Article;
        $article->title = 'Test Article Title Deleted';
        $article->body = 'Test Article Body Deleted';
        $article->records = array('time' => 1);
        $article->user_id = rand(1,3);
        $article->image = 'Test Article Image Deleted';
        $article->save();

        $this->delete(route('articles.destroy', $article));
        $this->assertSoftDeleted('articles', [
            'title' => 'Test Article Title Deleted',
            'body' => 'Test Article Body Deleted',
            'image' => 'Test Article Image Deleted',
        ]);
    }
}
