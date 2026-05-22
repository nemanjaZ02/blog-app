<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    public function test_post_has_many_comments(): void
    {
        $post = Post::factory()->create();
        Comment::factory(3)->create(['post_id' => $post->id]);

        $this->assertCount(3, $post->comments);
    }

    public function test_post_fillable_fields(): void
    {
        $post = new Post();
        $this->assertEquals(['user_id', 'title', 'content'], $post->getFillable());
    }
}