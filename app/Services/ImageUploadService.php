<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

/**
 * Central place for handling uploaded photos: resize down to a sane max
 * width (never upscale) and re-encode as WebP before storing. This keeps
 * listing/project/article/testimonial photos small and fast to load
 * regardless of what the admin/agent uploads (a 12MB phone photo becomes a
 * ~100-300KB WebP), which matters directly for Core Web Vitals and SEO.
 */
class ImageUploadService
{
    protected ImageManager $manager;

    public function __construct()
    {
        // GD driver — matches the gd extension already installed in the
        // Docker image (see Dockerfile). Requires GD built with WebP support.
        $this->manager = ImageManager::gd();
    }

    /**
     * Optimizes and stores an uploaded image, returning the relative path
     * (e.g. "listings/9f2a1c3e-....webp") to save on the model.
     */
    public function store(UploadedFile $file, string $directory, int $maxWidth = 1600, int $quality = 82): string
    {
        $image = $this->manager->read($file->getRealPath());

        // scaleDown (not scale) — shrinks large photos but never enlarges a
        // small one, which would just waste bytes on invented detail.
        $image->scaleDown(width: $maxWidth);

        $filename = trim($directory, '/') . '/' . (string) Str::uuid() . '.webp';
        $encoded = (string) $image->toWebp($quality);

        Storage::disk('public')->put($filename, $encoded);

        return $filename;
    }

    /**
     * Re-optimizes a file that's ALREADY on disk (uploaded before this WebP
     * pipeline existed). Skips anything already .webp — no point re-encoding
     * an already-optimized file. Returns the new path, or the original path
     * unchanged if nothing needed to happen.
     */
    public function optimizeExisting(string $path, int $maxWidth = 1600, int $quality = 82): string
    {
        if (str_ends_with(strtolower($path), '.webp')) {
            return $path;
        }

        if (! Storage::disk('public')->exists($path)) {
            return $path;
        }

        $contents = Storage::disk('public')->get($path);
        $image = $this->manager->read($contents);
        $image->scaleDown(width: $maxWidth);

        $newPath = pathinfo($path, PATHINFO_DIRNAME) . '/' . (string) Str::uuid() . '.webp';
        // pathinfo() returns "." for a path with no directory component.
        if (str_starts_with($newPath, './')) {
            $newPath = substr($newPath, 2);
        }

        Storage::disk('public')->put($newPath, (string) $image->toWebp($quality));
        Storage::disk('public')->delete($path);

        return $newPath;
    }

    /**
     * Deletes a previously stored image from the public disk. Safe to call
     * with null/empty paths (no-op) so callers don't need their own guard.
     */
    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
