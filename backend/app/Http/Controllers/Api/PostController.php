<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->withCount('comments')->latest()->paginate(10);
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
        ]);

        $post = $request->user()->posts()->create($request->only('title', 'content'));

        return response()->json($post->load('user'), 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load(['user', 'comments.user']));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title'   => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
        ]);

        $post->update($request->only('title', 'content'));

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}