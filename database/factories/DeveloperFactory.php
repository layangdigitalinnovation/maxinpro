<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    protected $model = \App\Models\Developer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}
