<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_anyone_can_list_posts(): void
    {
        Post::factory(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'current_page', 'total']);
    }

    public function test_anyone_can_view_single_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->getJson('/api/posts/' . $post->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $post->id]);
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/posts', [
                             'title'   => 'Test Post Title',
                             'content' => 'This is test content for the post.',
                         ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Test Post Title']);
    }

    public function test_guest_cannot_create_post(): void
    {
        $response = $this->postJson('/api/posts', [
            'title'   => 'Test Post Title',
            'content' => 'This is test content for the post.',
        ]);

        $response->assertStatus(401);
    }

    public function test_owner_can_update_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->putJson('/api/posts/' . $post->id, [
                             'title'   => 'Updated Title',
                             'content' => 'Updated content for this post.',
                         ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Title']);
    }

    public function test_non_owner_cannot_update_post(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post  = Post::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)
                         ->putJson('/api/posts/' . $post->id, [
                             'title'   => 'Hacked Title',
                             'content' => 'Hacked content for this post.',
                         ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->deleteJson('/api/posts/' . $post->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_admin_can_delete_any_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user  = User::factory()->create();
        $post  = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($admin)
                         ->deleteJson('/api/posts/' . $post->id);

        $response->assertStatus(200);
    }

    public function test_post_requires_title_and_content(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->postJson('/api/posts', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'content']);
    }
}