<?php

namespace App\Support;

/**
 * Normalizes Indonesian phone numbers into the format wa.me links require
 * (country code, no leading zero, digits only) — since numbers are typically
 * entered as "0812..." or "+62 812..." by whoever filled the form.
 */
class IndonesianPhone
{
    public static function toWhatsappFormat(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone) ?? '';

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (! str_starts_with($digits, '62')) {
            // Already missing the country code and doesn't start with 0 either
            // (rare, but happens with copy-pasted numbers) — assume Indonesian.
            $digits = '62' . $digits;
        }

        return $digits;
    }

    public static function waLink(string $phone, string $message = ''): string
    {
        $number = self::toWhatsappFormat($phone);

        return $message !== ''
            ? "https://wa.me/{$number}?text=" . urlencode($message)
            : "https://wa.me/{$number}";
    }
}
