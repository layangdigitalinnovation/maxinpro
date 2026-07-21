<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Testimonial;
use App\Services\ImageUploadService;
use Illuminate\Console\Command;

/**
 * One-off / re-runnable command to convert images uploaded BEFORE the
 * resize+WebP pipeline existed (see ImageUploadService). Safe to run
 * repeatedly — already-.webp files are skipped automatically.
 *
 * Usage: php artisan images:optimize-legacy [--dry-run]
 */
class OptimizeLegacyImages extends Command
{
    protected $signature = 'images:optimize-legacy {--dry-run : List what would change without modifying anything}';

    protected $description = 'Resize and convert to WebP any listing/project/article/testimonial photos uploaded before the optimization pipeline existed';

    public function handle(ImageUploadService $images): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $converted = 0;

        $this->info($dryRun ? 'DRY RUN — tidak ada yang akan diubah.' : 'Memulai konversi...');

        // Listings — cover image + soft-deleted ones too (their photos still matter for restore).
        foreach (Listing::withTrashed()->whereNotNull('cover_image')->get() as $listing) {
            if (str_ends_with(strtolower($listing->cover_image), '.webp')) {
                continue;
            }
            $this->line("Listing #{$listing->id} ({$listing->title}): cover_image");
            $converted++;
            if (! $dryRun) {
                $listing->update(['cover_image' => $images->optimizeExisting($listing->cover_image, maxWidth: 1600)]);
            }
        }

        foreach (ListingImage::query()->get() as $image) {
            if (str_ends_with(strtolower($image->path), '.webp')) {
                continue;
            }
            $this->line("ListingImage #{$image->id} (listing #{$image->listing_id})");
            $converted++;
            if (! $dryRun) {
                $image->update(['path' => $images->optimizeExisting($image->path, maxWidth: 1400)]);
            }
        }

        // Projects — same pattern.
        foreach (Project::withTrashed()->whereNotNull('cover_image')->get() as $project) {
            if (str_ends_with(strtolower($project->cover_image), '.webp')) {
                continue;
            }
            $this->line("Project #{$project->id} ({$project->name}): cover_image");
            $converted++;
            if (! $dryRun) {
                $project->update(['cover_image' => $images->optimizeExisting($project->cover_image, maxWidth: 1600)]);
            }
        }

        foreach (ProjectImage::query()->get() as $image) {
            if (str_ends_with(strtolower($image->path), '.webp')) {
                continue;
            }
            $this->line("ProjectImage #{$image->id} (project #{$image->project_id})");
            $converted++;
            if (! $dryRun) {
                $image->update(['path' => $images->optimizeExisting($image->path, maxWidth: 1400)]);
            }
        }

        // Articles.
        foreach (Article::query()->whereNotNull('cover_image')->get() as $article) {
            if (str_ends_with(strtolower($article->cover_image), '.webp')) {
                continue;
            }
            $this->line("Article #{$article->id} ({$article->title}): cover_image");
            $converted++;
            if (! $dryRun) {
                $article->update(['cover_image' => $images->optimizeExisting($article->cover_image, maxWidth: 1600)]);
            }
        }

        // Testimonials.
        foreach (Testimonial::query()->whereNotNull('photo_path')->get() as $testimonial) {
            if (str_ends_with(strtolower($testimonial->photo_path), '.webp')) {
                continue;
            }
            $this->line("Testimonial #{$testimonial->id} ({$testimonial->name}): photo_path");
            $converted++;
            if (! $dryRun) {
                $testimonial->update(['photo_path' => $images->optimizeExisting($testimonial->photo_path, maxWidth: 400)]);
            }
        }

        $this->newLine();
        $this->info($dryRun
            ? "Selesai (dry run) — {$converted} foto AKAN dikonversi kalau dijalankan tanpa --dry-run."
            : "Selesai — {$converted} foto berhasil dikonversi ke WebP.");

        return self::SUCCESS;
    }
}
