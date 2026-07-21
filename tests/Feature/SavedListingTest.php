<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\SavedListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SavedListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_toggle_save(): void
    {
        $listing = Listing::factory()->create();

        $this->post(route('listings.toggle-save', $listing))->assertRedirect(route('login'));
    }

    public function test_customer_can_save_and_unsave_a_listing(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $listing = Listing::factory()->create();

        $this->actingAs($customer)->post(route('listings.toggle-save', $listing));
        $this->assertDatabaseHas('saved_listings', ['user_id' => $customer->id, 'listing_id' => $listing->id]);

        // Toggling again should remove it.
        $this->actingAs($customer)->post(route('listings.toggle-save', $listing));
        $this->assertDatabaseMissing('saved_listings', ['user_id' => $customer->id, 'listing_id' => $listing->id]);
    }

    public function test_customer_only_sees_their_own_saved_listings(): void
    {
        $customerA = User::factory()->create(['role' => 'customer']);
        $customerB = User::factory()->create(['role' => 'customer']);

        $listingA = Listing::factory()->create(['title' => 'Rumah Milik Favorit A']);
        $listingB = Listing::factory()->create(['title' => 'Rumah Milik Favorit B']);

        SavedListing::create(['user_id' => $customerA->id, 'listing_id' => $listingA->id]);
        SavedListing::create(['user_id' => $customerB->id, 'listing_id' => $listingB->id]);

        $response = $this->actingAs($customerA)->get(route('account.saved-listings.index'));

        $response->assertSee('Rumah Milik Favorit A');
        $response->assertDontSee('Rumah Milik Favorit B');
    }
}
