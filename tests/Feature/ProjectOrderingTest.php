<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectOrderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_projects_in_admin_set_priority_order(): void
    {
        $first = Project::factory()->create(['name' => 'Project Prioritas Utama', 'priority_order' => 0, 'published_at' => now()]);
        $second = Project::factory()->create(['name' => 'Project Kedua', 'priority_order' => 1, 'published_at' => now()]);
        $third = Project::factory()->create(['name' => 'Project Ketiga', 'priority_order' => 2, 'published_at' => now()->addDay()]); // even newer, must still come last

        $response = $this->get(route('home'));
        $content = $response->getContent();

        $posFirst = strpos($content, 'Project Prioritas Utama');
        $posSecond = strpos($content, 'Project Kedua');
        $posThird = strpos($content, 'Project Ketiga');

        $this->assertNotFalse($posFirst);
        $this->assertTrue($posFirst < $posSecond, 'Project dengan priority_order lebih rendah harus muncul lebih dulu');
        $this->assertTrue($posSecond < $posThird, 'Urutan prioritas harus dihormati meski project lain lebih baru');
    }

    public function test_project_index_page_respects_priority_order(): void
    {
        Project::factory()->create(['name' => 'Zebra Terakhir', 'priority_order' => 5, 'published_at' => now()]);
        Project::factory()->create(['name' => 'Alpha Pertama', 'priority_order' => 0, 'published_at' => now()->subDays(10)]);

        $response = $this->get(route('projects.index'));
        $content = $response->getContent();

        $this->assertTrue(strpos($content, 'Alpha Pertama') < strpos($content, 'Zebra Terakhir'));
    }

    public function test_admin_can_reorder_projects_via_drag_drop_endpoint(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $projectA = Project::factory()->create(['priority_order' => 0]);
        $projectB = Project::factory()->create(['priority_order' => 1]);

        $response = $this->actingAs($admin)->postJson(route('admin.projects.update-order'), [
            'order' => [$projectB->id, $projectA->id], // B now first
        ]);

        $response->assertOk();
        $this->assertSame(0, $projectB->fresh()->priority_order);
        $this->assertSame(1, $projectA->fresh()->priority_order);
    }

    public function test_agent_cannot_reorder_projects(): void
    {
        $agent = User::factory()->create(['role' => 'agent']);
        $project = Project::factory()->create();

        $this->actingAs($agent)
            ->postJson(route('admin.projects.update-order'), ['order' => [$project->id]])
            ->assertForbidden();
    }

    public function test_reorder_rejects_ids_that_do_not_exist(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->postJson(route('admin.projects.update-order'), [
            'order' => [999999],
        ]);

        $response->assertStatus(422);
    }

    public function test_new_project_created_via_admin_lands_at_end_of_priority_queue(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Project::factory()->create(['priority_order' => 3]);

        $developer = \App\Models\Developer::factory()->create();
        $area = \App\Models\Area::factory()->create();

        $this->actingAs($admin)->post(route('admin.projects.store'), [
            'name' => 'Project Baru Dari Admin',
            'developer_id' => $developer->id,
            'area_id' => $area->id,
            'status' => 'Launching',
            'price_from' => 1000000000,
        ]);

        $newProject = Project::where('name', 'Project Baru Dari Admin')->firstOrFail();
        $this->assertSame(4, $newProject->priority_order);
    }

    public function test_project_card_shows_property_type_badge(): void
    {
        $type = PropertyType::factory()->create(['name' => 'Ruko / Rukan']);
        Project::factory()->create(['property_type_id' => $type->id, 'published_at' => now()]);

        $this->get(route('home'))->assertSee('Ruko / Rukan');
    }

    public function test_navigation_and_page_no_longer_say_kerjasama(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertSee('Proyek Baru');
        $response->assertDontSee('Kerjasama');
    }
}
