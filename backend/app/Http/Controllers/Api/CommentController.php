<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
        $request->validate([
            'comment'    => ['required', 'string', 'min:1', 'max:1000'],
            'guest_name' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            auth('sanctum')->setRequest($request)->authenticate();
        } catch (\Exception $e) {
            // guest, ignore
        }
        
        $comment = $post->comments()->create([
            'comment'    => $request->comment,
            'user_id'    => auth('sanctum')->id(),
            'guest_name' => auth('sanctum')->check() ? null : ($request->guest_name ?? 'Anonymous'),
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}