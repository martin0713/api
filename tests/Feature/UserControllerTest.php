<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $response = $this->post('api/auth/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '<PASSWORD>',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@example.com',
        ]);
        $response->assertCreated();
        $this->assertAuthenticated();
    }

    public function testLogin()
    {
        $user = new User();
        $user->name = 'test';
        $user->email = 'test@example.com';
        $user->password = password_hash('<PASSWORD>', PASSWORD_BCRYPT);
        $user->save();

        $response = $this->post('api/auth/login', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '<PASSWORD>',
        ]);
        $response->assertOk();
        $this->assertAuthenticated();
    }

    public function testLogout()
    {
        $this->post('api/auth/login', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '<PASSWORD>',
        ]);
        $response = $this->post('api/auth/logout');
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->put(route('users.update', $user), [
            'name' => 'testUpdate',
            'email' => 'test.update@example.com'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'testUpdate',
            'email' => 'test.update@example.com'
        ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $article = new Article();
        $article->title = 'Test Article Title Deleted';
        $article->body = 'Test Article Body Deleted';
        $article->records = ['time' => 1];
        $article->user_id = $user->id;
        $article->image = 'Test Article Image Deleted';
        $article->save();
        $article->tags()->attach(1);

        $this->actingAs($user)->delete(route('users.destroy', $user));
        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
        $this->assertDatabaseMissing('article_tag', [
            'article_id' => $article->id,
            'tag_id' => 1,
        ]);
        $this->assertSoftDeleted('articles', [
            'title' => 'Test Article Title Deleted',
            'body' => 'Test Article Body Deleted',
            'image' => 'Test Article Image Deleted',
        ]);
    }
}
