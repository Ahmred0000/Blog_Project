<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Post::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6, true),
            'body' => $this->faker->paragraphs(5, true),
            'image' => null, // or you can add image path if you want
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
        ];
    }
}
