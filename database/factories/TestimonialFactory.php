<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = \App\Models\Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'city' => $this->faker->city(),
            'rating' => $this->faker->numberBetween(4, 5),
            'quote' => $this->faker->sentence(15),
            'is_active' => true,
        ];
    }
}
