<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'category_id'  => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $categoryId = $request->category_id;
        if ($request->filled('new_category')) {
            $category = Category::create(['name' => $request->new_category]);
            $categoryId = $category->id;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title'        => $request->title,
            'body'         => $request->body,
            'category_id'  => $categoryId,
            'image'        => $imagePath,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'category_id'  => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $categoryId = $request->category_id;
        if ($request->filled('new_category')) {
            $category = Category::create(['name' => $request->new_category]);
            $categoryId = $category->id;
        }

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title'        => $request->title,
            'body'         => $request->body,
            'category_id'  => $categoryId,
            'published_at' => $request->published_at,
            'image'        => $post->image,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}
