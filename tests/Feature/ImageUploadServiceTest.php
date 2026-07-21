<?php

namespace Tests\Feature;

use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Requires GD built with WebP support (see Dockerfile: --with-webp).
 * If these fail locally with a GD/driver error, rebuild the Docker image —
 * a stock PHP install without libwebp-dev won't have this enabled.
 */
class ImageUploadServiceTest extends TestCase
{
    public function test_uploaded_image_is_converted_to_webp(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('rumah.jpg', 2000, 1200);
        $path = (new ImageUploadService())->store($file, 'listings');

        $this->assertStringEndsWith('.webp', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_large_image_is_scaled_down_to_max_width(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('besar.jpg', 3000, 2000);
        $path = (new ImageUploadService())->store($file, 'listings', maxWidth: 1200);

        $contents = Storage::disk('public')->get($path);
        $info = getimagesizefromstring($contents);

        $this->assertLessThanOrEqual(1200, $info[0]);
    }

    public function test_small_image_is_not_upscaled(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('kecil.jpg', 400, 300);
        $path = (new ImageUploadService())->store($file, 'listings', maxWidth: 1600);

        $contents = Storage::disk('public')->get($path);
        $info = getimagesizefromstring($contents);

        $this->assertSame(400, $info[0]);
    }

    public function test_delete_is_a_safe_no_op_for_null_path(): void
    {
        Storage::fake('public');

        // Must not throw when a model has no cover image yet.
        (new ImageUploadService())->delete(null);
        $this->assertTrue(true);
    }
}
