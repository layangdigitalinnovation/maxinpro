<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\SavedListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Regression tests for a QA finding: Listing uses SoftDeletes, but the
 * saved_listings foreign key cascade only fires on a HARD delete. A soft-deleted
 * listing therefore left an orphaned saved_listings row whose ->listing was null,
 * which crashed the customer's favourites page.
 */
class SoftDeleteRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_favourites_page_survives_a_soft_deleted_listing(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $listing = Listing::factory()->create(['status' => 'active', 'published_at' => now()]);

        SavedListing::create(['user_id' => $customer->id, 'listing_id' => $listing->id]);

        $listing->delete(); // soft delete

        $this->actingAs($customer)
            ->get(route('account.saved-listings.index'))
            ->assertOk();
    }

    public function test_hidden_listings_are_excluded_from_favourites(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $hidden = Listing::factory()->create(['status' => 'hidden', 'title' => 'Properti Disembunyikan']);

        SavedListing::create(['user_id' => $customer->id, 'listing_id' => $hidden->id]);

        $this->actingAs($customer)
            ->get(route('account.saved-listings.index'))
            ->assertOk()
            ->assertDontSee('Properti Disembunyikan');
    }

    public function test_soft_deleting_a_listing_keeps_its_cover_image_for_restore(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $listing = Listing::factory()->create(['cover_image' => 'listings/contoh.jpg']);

        $this->actingAs($admin)->delete(route('admin.listings.destroy', $listing));

        // Record is soft-deleted but the image reference must survive intact.
        $this->assertSoftDeleted('listings', ['id' => $listing->id]);
        $this->assertSame('listings/contoh.jpg', $listing->fresh()->cover_image);
    }
}
