<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/posts/' . $post->id . '/comments', [
                             'comment' => 'This is a test comment.',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['comment' => 'This is a test comment.']);
    }

    public function test_guest_can_add_comment(): void
    {
        $post = Post::factory()->create();

        $response = $this->postJson('/api/posts/' . $post->id . '/comments', [
            'comment'    => 'Guest comment here.',
            'guest_name' => 'Guest User',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['guest_name' => 'Guest User']);
    }

    public function test_comment_owner_can_delete_comment(): void
    {
        $user    = User::factory()->create();
        $post    = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($user)
                         ->deleteJson('/api/comments/' . $comment->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_post_owner_can_delete_any_comment(): void
    {
        $postOwner    = User::factory()->create();
        $commenter    = User::factory()->create();
        $post         = Post::factory()->create(['user_id' => $postOwner->id]);
        $comment      = Comment::factory()->create([
            'user_id' => $commenter->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($postOwner)
                         ->deleteJson('/api/comments/' . $comment->id);

        $response->assertStatus(200);
    }

    public function test_non_owner_cannot_delete_comment(): void
    {
        $user    = User::factory()->create();
        $other   = User::factory()->create();
        $post    = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($other)
                         ->deleteJson('/api/comments/' . $comment->id);

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $admin   = User::factory()->create(['role' => 'admin']);
        $user    = User::factory()->create();
        $post    = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $response = $this->actingAs($admin)
                         ->deleteJson('/api/comments/' . $comment->id);

        $response->assertStatus(200);
    }
}