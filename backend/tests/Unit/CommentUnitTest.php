<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_belongs_to_post(): void
    {
        $post    = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $this->assertInstanceOf(Post::class, $comment->post);
        $this->assertEquals($post->id, $comment->post->id);
    }

    public function test_comment_belongs_to_user(): void
    {
        $user    = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertEquals($user->id, $comment->user->id);
    }

    public function test_author_name_returns_user_name_when_logged_in(): void
    {
        $user    = User::factory()->create(['name' => 'Nemanja']);
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertEquals('Nemanja', $comment->authorName());
    }

    public function test_author_name_returns_guest_name_when_guest(): void
    {
        $comment = Comment::factory()->create([
            'user_id'    => null,
            'guest_name' => 'Guest User',
        ]);

        $this->assertEquals('Guest User', $comment->authorName());
    }

    public function test_author_name_returns_anonymous_when_no_name(): void
    {
        $comment = Comment::factory()->create([
            'user_id'    => null,
            'guest_name' => null,
        ]);

        $this->assertEquals('Anonymous', $comment->authorName());
    }
}