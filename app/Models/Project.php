<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'name', 'slug', 'developer_id', 'area_id', 'property_type_id', 'description', 'status',
        'price_from', 'units_available', 'cover_image', 'is_featured', 'published_at', 'priority_order', 'sort_order', 'is_published',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'price_from' => 'integer',
        'priority_order' => 'integer',
    ];

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Admin-controlled display order (see Admin\ProjectController::order/updateOrder).
     * Lower priority_order shows first; published_at is only a tiebreaker for
     * projects an admin has never manually reordered (both default to 0).
     */
    public function scopeOrderByPriority(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('priority_order')->orderByDesc('published_at');
    }

    public function getFormattedPriceFromAttribute(): string
    {
        return 'Rp ' . number_format($this->price_from, 0, ',', '.');
    }
}
