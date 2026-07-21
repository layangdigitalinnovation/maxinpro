<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OptimizeLegacyImagesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_dry_run_reports_without_modifying_anything(): void
    {
        Storage::fake('public');

        $legacyPath = UploadedFile::fake()->image('lama.jpg', 2000, 1200)
            ->storeAs('listings', 'lama.jpg', 'public');

        $listing = Listing::factory()->create(['cover_image' => $legacyPath]);

        $this->artisan('images:optimize-legacy', ['--dry-run' => true])->assertSuccessful();

        $this->assertSame($legacyPath, $listing->fresh()->cover_image);
        Storage::disk('public')->assertExists($legacyPath);
    }

    public function test_converts_legacy_jpg_to_webp_and_updates_the_record(): void
    {
        Storage::fake('public');

        $legacyPath = UploadedFile::fake()->image('lama.jpg', 2000, 1200)
            ->storeAs('listings', 'lama.jpg', 'public');

        $listing = Listing::factory()->create(['cover_image' => $legacyPath]);

        $this->artisan('images:optimize-legacy')->assertSuccessful();

        $fresh = $listing->fresh();
        $this->assertStringEndsWith('.webp', $fresh->cover_image);
        Storage::disk('public')->assertExists($fresh->cover_image);
        Storage::disk('public')->assertMissing($legacyPath);
    }

    public function test_already_webp_files_are_skipped(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('testimonials/sudah.webp', 'fake-webp-bytes');

        $testimonial = Testimonial::factory()->create(['photo_path' => 'testimonials/sudah.webp']);

        $this->artisan('images:optimize-legacy')->assertSuccessful();

        // Path must be untouched — re-processing an already-optimized file wastes work.
        $this->assertSame('testimonials/sudah.webp', $testimonial->fresh()->photo_path);
    }
}
