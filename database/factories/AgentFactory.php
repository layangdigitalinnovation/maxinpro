<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    protected $model = \App\Models\Agent::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('08##########'),
            'whatsapp' => $this->faker->numerify('08##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'is_active' => true,
        ];
    }
}
