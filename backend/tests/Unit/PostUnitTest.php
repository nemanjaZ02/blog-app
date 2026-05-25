<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class PostUnitTest extends TestCase
{
    public function test_fillable_fields(): void
    {
        $this->assertEquals(['user_id', 'title', 'content'], (new Post())->getFillable());
    }

    public function test_user_relationship_is_belongs_to(): void
    {
        $this->assertInstanceOf(BelongsTo::class, (new Post())->user());
    }

    public function test_comments_relationship_is_has_many(): void
    {
        $this->assertInstanceOf(HasMany::class, (new Post())->comments());
    }
}