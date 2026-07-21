<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Listing;
use App\Models\PropertyType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_only_shows_active_listings(): void
    {
        $active = Listing::factory()->create(['status' => 'active', 'published_at' => now()]);
        $hidden = Listing::factory()->create(['status' => 'hidden']);

        $response = $this->get(route('listings.index'));

        $response->assertOk();
        $response->assertSee($active->title);
        $response->assertDontSee($hidden->title);
    }

    public function test_filter_by_property_type(): void
    {
        $typeA = PropertyType::factory()->create(['name' => 'Rumah']);
        $typeB = PropertyType::factory()->create(['name' => 'Tanah']);

        $rumah = Listing::factory()->create(['property_type_id' => $typeA->id, 'status' => 'active', 'published_at' => now()]);
        $tanah = Listing::factory()->create(['property_type_id' => $typeB->id, 'status' => 'active', 'published_at' => now()]);

        $response = $this->get(route('listings.index', ['type' => [$typeA->id]]));

        $response->assertSee($rumah->title);
        $response->assertDontSee($tanah->title);
    }

    public function test_show_page_returns_404_for_non_active_listing(): void
    {
        $listing = Listing::factory()->create(['status' => 'sold']);

        $this->get(route('listings.show', $listing))->assertNotFound();
    }
}
