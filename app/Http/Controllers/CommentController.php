<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'body' => 'required|string|max:2000',
        ]);

        $post->comments()->create($request->only('author_name', 'body'));

        return redirect()->route('posts.show', $post)->with('success', __('Comment added successfully.'));
    }
}
