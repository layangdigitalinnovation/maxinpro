<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Developer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = \App\Models\Project::class;

    public function definition(): array
    {
        $name = 'Project ' . $this->faker->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'developer_id' => Developer::factory(),
            'area_id' => Area::factory(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['Launching', 'Premium', 'New Cluster', 'Sold Out']),
            'price_from' => $this->faker->numberBetween(500_000_000, 3_000_000_000),
            'units_available' => 'Sisa ' . $this->faker->numberBetween(5, 50) . ' unit',
            'is_featured' => false,
            'published_at' => now(),
            'priority_order' => 0,
        ];
    }
}
