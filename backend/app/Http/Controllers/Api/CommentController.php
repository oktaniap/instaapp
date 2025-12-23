<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($postId);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        return response()->json($comment);
    }

    public function index($postId)
    {
        $post = Post::with('comments.user')->findOrFail($postId);

        return response()->json([
            'comments_count' => $post->comments->count(),
            'comments' => $post->comments,
        ]);
    }
}
