<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $alice = User::where('email', 'alice@example.com')->first();
        $bob   = User::where('email', 'bob@example.com')->first();
        $posts = Post::all();

        $comments = [
            'Great post, really enjoyed reading this!',
            'Thanks for sharing, very helpful.',
            'I completely agree with everything you said.',
            'This is exactly what I needed to read today.',
            'Wow, never thought about it this way before.',
            'Amazing content, keep it up!',
            'I had a similar experience, totally relate.',
            'Very well written, looking forward to more.',
        ];

        foreach ($posts->take(10) as $post) {
            Comment::create(['post_id' => $post->id, 'user_id' => $admin->id, 'comment' => $comments[array_rand($comments)], 'guest_name' => null]);
            Comment::create(['post_id' => $post->id, 'user_id' => $alice->id, 'comment' => $comments[array_rand($comments)], 'guest_name' => null]);
            Comment::create(['post_id' => $post->id, 'user_id' => null, 'comment' => $comments[array_rand($comments)], 'guest_name' => 'Guest User']);
            Comment::create(['post_id' => $post->id, 'user_id' => $bob->id, 'comment' => $comments[array_rand($comments)], 'guest_name' => null]);
        }
    }
}