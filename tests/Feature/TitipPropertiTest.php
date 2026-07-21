<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\PropertyType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TitipPropertiTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_page_loads(): void
    {
        $this->get(route('titip-properti.create'))->assertOk();
    }

    public function test_valid_submission_creates_a_lead(): void
    {
        $type = PropertyType::factory()->create();

        $payload = [
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'city' => 'Tangerang Selatan',
            'address' => 'Jl. Contoh No. 1',
            'property_type_id' => $type->id,
            'expected_price' => '2.500.000.000',
            'specification' => '2 lantai, 3 kamar tidur',
        ];

        $response = $this->post(route('titip-properti.store'), $payload);

        $response->assertRedirect(route('titip-properti.create'));
        $this->assertDatabaseHas('leads', [
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'type' => 'titip_properti',
            'expected_price' => 2500000000,
        ]);
    }

    public function test_missing_required_fields_are_rejected(): void
    {
        $response = $this->post(route('titip-properti.store'), []);

        $response->assertSessionHasErrors(['name', 'phone', 'city', 'address', 'property_type_id', 'expected_price']);
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_invalid_property_type_is_rejected(): void
    {
        $response = $this->post(route('titip-properti.store'), [
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'city' => 'Tangerang Selatan',
            'address' => 'Jl. Contoh No. 1',
            'property_type_id' => 9999, // does not exist
            'expected_price' => '1.000.000.000',
        ]);

        $response->assertSessionHasErrors(['property_type_id']);
    }
}
