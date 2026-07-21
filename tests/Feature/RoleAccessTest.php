<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_agent_cannot_access_admin_dashboard(): void
    {
        $agentUser = User::factory()->create(['role' => 'agent']);

        $this->actingAs($agentUser)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);

        $this->actingAs($adminUser)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_agent_cannot_edit_another_agents_listing(): void
    {
        $agentUserA = User::factory()->create(['role' => 'agent']);
        $agentA = Agent::factory()->create(['user_id' => $agentUserA->id]);

        $agentUserB = User::factory()->create(['role' => 'agent']);
        $agentB = Agent::factory()->create(['user_id' => $agentUserB->id]);

        $listingOfB = Listing::factory()->create(['agent_id' => $agentB->id]);

        $this->actingAs($agentUserA)
            ->get(route('agent.listings.edit', $listingOfB))
            ->assertForbidden();
    }

    public function test_agent_can_only_see_own_listings_in_index(): void
    {
        $agentUserA = User::factory()->create(['role' => 'agent']);
        $agentA = Agent::factory()->create(['user_id' => $agentUserA->id]);
        $agentB = Agent::factory()->create();

        $ownListing = Listing::factory()->create(['agent_id' => $agentA->id, 'title' => 'Listing Milik A']);
        $otherListing = Listing::factory()->create(['agent_id' => $agentB->id, 'title' => 'Listing Milik B']);

        $response = $this->actingAs($agentUserA)->get(route('agent.listings.index'));

        $response->assertSee('Listing Milik A');
        $response->assertDontSee('Listing Milik B');
    }
}
