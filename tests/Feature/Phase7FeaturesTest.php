<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase7FeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_audit_log_detail_page_shows_the_change(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $listing = Listing::factory()->create(['price' => 1_000_000_000]);
        $listing->update(['price' => 1_800_000_000]);

        $log = \App\Models\AuditLog::where('auditable_id', $listing->id)->where('action', 'updated')->firstOrFail();

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.show', $log));

        $response->assertOk();
        $response->assertSee('Rp 1.000.000.000', false);
        $response->assertSee('Rp 1.800.000.000', false);
    }

    public function test_audit_log_export_requires_admin(): void
    {
        $agent = User::factory()->create(['role' => 'agent']);
        $this->actingAs($agent)->get(route('admin.audit-logs.export'))->assertForbidden();
    }

    public function test_audit_log_export_contains_csv_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $listing = Listing::factory()->create(['title' => 'Rumah Contoh Audit']);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.export'));

        $response->assertOk();
        $this->assertStringContainsString('Rumah Contoh Audit', $response->streamedContent());
    }

    public function test_dashboard_includes_analytics_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Lead::factory()->count(3)->create();
        Listing::factory()->count(2)->create(['status' => 'active', 'published_at' => now()]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Tren Lead Masuk');
        $response->assertSee('Listing Aktif per Area');
    }

    public function test_export_route_does_not_get_swallowed_by_show_route_wildcard(): void
    {
        // Regression guard: /audit-logs/export must resolve to the export
        // action, not be interpreted as {auditLog}=export by the show route.
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.audit-logs.export'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
