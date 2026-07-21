<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = \App\Models\Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'category' => $this->faker->randomElement(['Tips', 'KPR', 'Investasi']),
            'excerpt' => $this->faker->sentence(12),
            'body' => $this->faker->paragraphs(3, true),
            'published_at' => now(),
        ];
    }
}
