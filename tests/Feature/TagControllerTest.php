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
        // Arrange
        $name = 'tag_test';
        // Act
        $this->post('api/tags', [
            'name' => $name,
        ]);
        // Assert
        $this->assertDatabaseHas('tags', [
            'name' => $name,
        ]);
    }

    public function testUpdate()
    {
        // Arrange
        $tag = new Tag();
        $tag->name = '';
        $tag->save();
        // Act
        $this->put("api/tags/{$tag->id}", [
            'name' => 'tag_test_updated',
        ]);
        // Assert
        $this->assertDatabaseHas('tags', [
            'name' => 'tag_test_updated',
        ]);
    }

    public function testDestroy()
    {
        // Arrange
        $tag = new Tag();
        $tag->name = 'tag_test_deleted';
        $tag->save();
        // Act
        $this->delete("api/tags/{$tag->id}");
        // Assert
        $this->assertDatabaseMissing('tags', [
            'name' => 'tag_test_deleted',
        ]);
    }
}
