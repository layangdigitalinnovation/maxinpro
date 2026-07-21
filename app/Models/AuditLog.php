<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'auditable_type', 'auditable_id',
        'auditable_label', 'changes', 'ip_address',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * auditable_type stores the model's FQCN (e.g. App\Models\Listing).
     * This helper returns just the short class name for display in the UI.
     */
    public function shortType(): string
    {
        return class_basename($this->auditable_type);
    }

    /**
     * Human-readable Indonesian labels for the most commonly audited fields,
     * so the log reads like "Harga: Rp 1.000.000.000 → Rp 1.500.000.000"
     * instead of a raw column name. Falls back to the raw field name for
     * anything not explicitly mapped, so nothing is ever hidden.
     */
    public static function fieldLabel(string $field): string
    {
        return [
            'title' => 'Judul', 'name' => 'Nama', 'description' => 'Deskripsi',
            'price' => 'Harga', 'price_from' => 'Harga Mulai', 'status' => 'Status',
            'address' => 'Alamat', 'bedrooms' => 'Kamar Tidur', 'bathrooms' => 'Kamar Mandi',
            'car_ports' => 'Carport', 'land_area' => 'Luas Tanah', 'building_area' => 'Luas Bangunan',
            'badge' => 'Badge', 'is_featured' => 'Unggulan', 'cover_image' => 'Foto Cover',
            'area_id' => 'Area', 'property_type_id' => 'Tipe Properti', 'agent_id' => 'Agen',
            'developer_id' => 'Developer', 'units_available' => 'Unit Tersedia',
            'published_at' => 'Tanggal Terbit', 'slug' => 'Slug URL',
        ][$field] ?? ucfirst(str_replace('_', ' ', $field));
    }

    /**
     * Formats a raw stored value for display — Rupiah for price fields,
     * Ya/Tidak for booleans, em-dash for empty values, truncated otherwise.
     */
    public static function formatValue(string $field, mixed $value): string
    {
        if ($value === null || $value === '') {
            return '—';
        }

        if (in_array($field, ['price', 'price_from'], true) && is_numeric($value)) {
            return 'Rp ' . number_format((float) $value, 0, ',', '.');
        }

        if (is_bool($value) || $value === '0' || $value === '1') {
            return ((bool) $value) ? 'Ya' : 'Tidak';
        }

        return \Illuminate\Support\Str::limit((string) $value, 60);
    }
}
