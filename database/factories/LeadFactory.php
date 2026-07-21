<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = \App\Models\Lead::class;

    public function definition(): array
    {
        return [
            'type' => 'titip_properti',
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('08##########'),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'expected_price' => $this->faker->numberBetween(500_000_000, 3_000_000_000),
            'status' => 'new',
        ];
    }
}
