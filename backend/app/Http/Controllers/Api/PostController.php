<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->withCount('likes')
            ->latest()
            ->get();
        return response()->json($posts);
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
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = auth()->user()->posts()->findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}

