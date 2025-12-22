<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $post = Post::findOrFail($postId);

        $like = Like::where('user_id', auth()->id())
                    ->where('post_id', $post->id)
                    ->first();

        if ($like) {
            $like->delete();
            return response()->json(['liked' => false]);
        }

        Like::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);

        return response()->json(['liked' => true]);
    }
}
