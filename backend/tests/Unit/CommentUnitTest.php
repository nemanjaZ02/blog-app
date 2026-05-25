<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class CommentUnitTest extends TestCase
{
    public function test_fillable_fields(): void
    {
        $this->assertEquals(
            ['post_id', 'user_id', 'comment', 'guest_name'],
            (new Comment())->getFillable()
        );
    }

    public function test_post_relationship_is_belongs_to(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Comment())->post());
    }

    public function test_user_relationship_is_belongs_to(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Comment())->user());
    }

    public function test_author_name_returns_user_name(): void
    {
        $user       = new User();
        $user->name = 'Nemanja';

        $comment = new Comment();
        $comment->setRelation('user', $user);

        $this->assertEquals('Nemanja', $comment->authorName());
    }

    public function test_author_name_returns_guest_name(): void
    {
        $comment             = new Comment();
        $comment->guest_name = 'Guest User';
        $comment->setRelation('user', null);

        $this->assertEquals('Guest User', $comment->authorName());
    }

    public function test_author_name_returns_anonymous_when_no_name(): void
    {
        $comment             = new Comment();
        $comment->guest_name = null;
        $comment->setRelation('user', null);

        $this->assertEquals('Anonymous', $comment->authorName());
    }
}