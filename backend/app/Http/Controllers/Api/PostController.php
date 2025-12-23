<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::with('user')
            ->withCount(['likes', 'comments']) // 🔥 JUMLAH
            ->withExists([
                'likes as is_liked' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ])
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
        } else {
            $path = null;
        }

        $post = auth()->user()->posts()->create([
            'content' => $request->content,
            'image' => $path,
        ]);

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::with('user')
            ->withCount('likes')
            ->findOrFail($id);
        $post->liked_by_me = $post->likes()
            ->where('user_id', auth()->id())
            ->exists();

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = auth()->user()->posts()->findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}

