<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
    protected $model = \App\Models\Listing::class;

    public function definition(): array
    {
        $title = 'Rumah ' . $this->faker->streetName();

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'description' => $this->faker->paragraph(),
            'property_type_id' => PropertyType::factory(),
            'area_id' => Area::factory(),
            'address' => $this->faker->address(),
            'price' => $this->faker->numberBetween(500_000_000, 6_000_000_000),
            'land_area' => $this->faker->numberBetween(60, 300),
            'building_area' => $this->faker->numberBetween(50, 280),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'car_ports' => $this->faker->numberBetween(0, 5),
            'badge' => $this->faker->randomElement(['Terpopuler', 'Baru', 'Premium', null]),
            'status' => 'active',
            'is_featured' => $this->faker->boolean(),
            'published_at' => now(),
        ];
    }
}
