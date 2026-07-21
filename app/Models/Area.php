<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'city', 'image_path', 'property_count', 'is_popular'];

    protected $casts = [
        'is_popular' => 'boolean',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
