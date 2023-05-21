<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testCreatePost()
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201)
            ->assertJson([
                'title' => $postData['title'],
                'content' => $postData['content'],
            ]);

        $this->assertDatabaseHas('posts', $postData);
    }

    public function testUpdatePost()
    {
        $post = Post::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ];

        $response = $this->putJson('/api/posts/' . $post->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'title' => $updatedData['title'],
                'content' => $updatedData['content'],
            ]);

        $this->assertDatabaseHas('posts', $updatedData);
    }

    public function testGetPost()
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
            ]);
    }
}

