<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_canonical_and_open_graph(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('rel="canonical"', false);
        $response->assertSee('property="og:title"', false);
        $response->assertSee('name="twitter:card"', false);
        $response->assertSee('application/ld+json', false);
    }

    public function test_admin_panel_is_marked_noindex(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee('content="noindex, nofollow"', false);
    }

    public function test_login_page_is_noindex(): void
    {
        $this->get(route('login'))->assertSee('content="noindex, nofollow"', false);
    }

    public function test_listing_detail_emits_structured_data(): void
    {
        $listing = Listing::factory()->create(['status' => 'active', 'published_at' => now()]);

        $response = $this->get(route('listings.show', $listing));

        $response->assertOk();
        $response->assertSee('BreadcrumbList', false);
        $response->assertSee('Accommodation', false);
    }

    public function test_sitemap_returns_xml_and_includes_active_listings(): void
    {
        $active = Listing::factory()->create(['status' => 'active', 'published_at' => now()]);
        $hidden = Listing::factory()->create(['status' => 'hidden']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee($active->slug, false);
        $response->assertDontSee($hidden->slug, false);
    }

    public function test_paginated_listing_pages_are_noindex_but_followed(): void
    {
        Listing::factory()->count(12)->create(['status' => 'active', 'published_at' => now()]);

        $this->get(route('listings.index', ['page' => 2]))
            ->assertSee('content="noindex, follow"', false);
    }

    public function test_published_article_appears_in_sitemap_but_draft_does_not(): void
    {
        $published = Article::factory()->create(['published_at' => now(), 'slug' => 'artikel-terbit']);
        $draft = Article::factory()->create(['published_at' => null, 'slug' => 'artikel-draft']);

        $response = $this->get('/sitemap.xml');

        $response->assertSee('artikel-terbit', false);
        $response->assertDontSee('artikel-draft', false);
    }
}
