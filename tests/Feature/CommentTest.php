<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testCreateComment()
    {
        $post = Post::factory()->create();

        $commentData = [
            'content' => 'This is a test comment.',
        ];

        $response = $this->postJson('/api/posts/' . $post->id . '/comments', $commentData);

        $response->assertStatus(201)
            ->assertJson([
                'content' => $commentData['content'],
            ]);

        $this->assertDatabaseHas('comments', $commentData);
    }

    public function testUpdateComment()
    {
        $comment = Comment::factory()->create();

        $updatedData = [
            'content' => 'Updated comment content',
        ];

        $response = $this->putJson('/api/posts/' . $comment->post_id . '/comments/' . $comment->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'content' => $updatedData['content'],
            ]);

        $this->assertDatabaseHas('comments', $updatedData);
    }

    public function testGetComment()
    {
        $comment = Comment::factory()->create();

        $response = $this->getJson('/api/posts/' . $comment->post_id . '/comments/' . $comment->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $comment->id,
                'content' => $comment->content,
            ]);
    }
}
