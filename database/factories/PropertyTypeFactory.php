<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyTypeFactory extends Factory
{
    protected $model = \App\Models\PropertyType::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement(['Rumah', 'Apartemen', 'Ruko / Rukan', 'Tanah']);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(4),
        ];
    }
}
