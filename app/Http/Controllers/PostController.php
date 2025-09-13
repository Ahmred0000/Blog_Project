<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category');
        $categories = Category::all();

        $postsQuery = Post::with('category')->whereNotNull('published_at')->orderBy('published_at', 'desc');
        if ($categoryId) {
            $postsQuery->where('category_id', $categoryId);
        }
        $posts = $postsQuery->paginate(10);

        return view('posts.index', compact('posts', 'categories', 'categoryId'));
    }

    public function show(Post $post)
    {
        abort_if(!$post->published_at, 404);
        $post->load('category', 'comments');
        return view('posts.show', compact('post'));
    }
}
