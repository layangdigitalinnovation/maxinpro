<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AreaFactory extends Factory
{
    protected $model = \App\Models\Area::class;

    public function definition(): array
    {
        $name = $this->faker->city();

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
            'city' => $name,
            'property_count' => $this->faker->numberBetween(100, 5000),
            'is_popular' => $this->faker->boolean(),
        ];
    }
}
