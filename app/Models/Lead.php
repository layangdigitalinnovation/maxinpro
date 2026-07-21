<?php

namespace App\Models;

use App\Support\IndonesianPhone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'name', 'phone', 'email', 'city', 'address', 'property_type_id',
        'expected_price', 'specification', 'message', 'status', 'source_ip',
    ];

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * wa.me link, pre-filled with a friendly opener referencing what they
     * submitted — so whoever clicks it doesn't have to type the number or
     * the greeting by hand. Recipient's phone, not MaxinPro's own number.
     */
    public function waLink(): string
    {
        $greeting = "Halo {$this->name}, terima kasih sudah mengajukan Titip Properti di MaxinPro"
            . ($this->propertyType ? " untuk {$this->propertyType->name}" : '')
            . " di {$this->city}. Kami ingin menindaklanjuti pengajuan Anda.";

        return IndonesianPhone::waLink($this->phone, $greeting);
    }
}
