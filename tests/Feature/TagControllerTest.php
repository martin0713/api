<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Tag;

class TagControllerTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    public function testStore()
    {
        $name = 'tag_test';
        $this->post('api/tags', [
            'name' => $name,
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => $name,
        ]);
    }

    public function testUpdate()
    {
        $tag = new Tag();
        $tag->name = '';
        $tag->save();

        $this->put("api/tags/{$tag->id}", [
            'name' => 'tag_test_updated',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'tag_test_updated',
        ]);
    }

    public function testDestroy()
    {
        $tag = new Tag();
        $tag->name = 'tag_test_deleted';
        $tag->save();

        $this->delete("api/tags/{$tag->id}");
        $this->assertDatabaseMissing('tags', [
            'name' => 'tag_test_deleted',
        ]);
    }
}
