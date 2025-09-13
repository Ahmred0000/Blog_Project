<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $categories = Category::factory(5)->create();

        $posts = Post::factory(20)
            ->make()
            ->each(function ($post) use ($categories) {
                $post->category_id = $categories->random()->id;
                $post->save();
            });

        $posts->each(function ($post) {
            Comment::factory(rand(1, 5))->create([
                'post_id' => $post->id,
            ]);
        });
    }
}
