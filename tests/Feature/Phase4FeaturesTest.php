<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Lead;
use App\Models\Listing;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase4FeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_landing_page_shows_only_that_areas_active_listings(): void
    {
        $areaA = Area::factory()->create(['name' => 'BSD City']);
        $areaB = Area::factory()->create(['name' => 'Bintaro']);

        $inArea = Listing::factory()->create(['area_id' => $areaA->id, 'status' => 'active', 'published_at' => now(), 'title' => 'Rumah BSD Satu']);
        $otherArea = Listing::factory()->create(['area_id' => $areaB->id, 'status' => 'active', 'published_at' => now(), 'title' => 'Rumah Bintaro Satu']);

        $response = $this->get(route('area-landing.show', $areaA));

        $response->assertOk();
        $response->assertSee('Rumah BSD Satu');
        $response->assertDontSee('Rumah Bintaro Satu');
    }

    public function test_lead_csv_export_requires_admin(): void
    {
        $this->get(route('admin.leads.export'))->assertRedirect(route('login'));

        $agent = User::factory()->create(['role' => 'agent']);
        $this->actingAs($agent)->get(route('admin.leads.export'))->assertForbidden();
    }

    public function test_lead_csv_export_contains_lead_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Lead::factory()->create(['name' => 'Contoh Penitip', 'phone' => '081234567890']);

        $response = $this->actingAs($admin)->get(route('admin.leads.export'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Contoh Penitip', $response->streamedContent());
    }

    public function test_admin_can_restore_a_soft_deleted_listing(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $listing = Listing::factory()->create();
        $listing->delete();

        $this->assertSoftDeleted('listings', ['id' => $listing->id]);

        $this->actingAs($admin)->patch(route('admin.listings.restore', $listing->id))
            ->assertRedirect(route('admin.listings.trashed'));

        $this->assertDatabaseHas('listings', ['id' => $listing->id, 'deleted_at' => null]);
    }

    public function test_force_delete_permanently_removes_listing_and_cannot_be_restored(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $listing = Listing::factory()->create();
        $listing->delete();

        $this->actingAs($admin)->delete(route('admin.listings.force-delete', $listing->id));

        $this->assertDatabaseMissing('listings', ['id' => $listing->id]);
    }

    public function test_agent_cannot_access_trashed_listings_or_audit_log(): void
    {
        $agent = User::factory()->create(['role' => 'agent']);

        $this->actingAs($agent)->get(route('admin.listings.trashed'))->assertForbidden();
        $this->actingAs($agent)->get(route('admin.audit-logs.index'))->assertForbidden();
    }

    public function test_updating_a_listing_creates_an_audit_log_entry(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $listing = Listing::factory()->create(['price' => 1_000_000_000]);

        $listing->update(['price' => 1_500_000_000]);

        $this->assertDatabaseHas('audit_logs', [
            'auditable_type' => Listing::class,
            'auditable_id' => $listing->id,
            'action' => 'updated',
        ]);
    }
}
