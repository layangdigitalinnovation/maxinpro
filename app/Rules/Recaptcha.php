<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Verifies a Google reCAPTCHA v2 ("I'm not a robot") response server-side.
 * If RECAPTCHA_SECRET_KEY is not configured, this rule is skipped entirely
 * (useful for local development) rather than blocking form submission.
 */
class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.recaptcha.secret_key');

        if (empty($secret)) {
            return; // reCAPTCHA not configured — skip rather than break the form.
        }

        if (empty($value)) {
            $fail('Verifikasi captcha wajib diisi.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $value,
            ]);

            if (! $response->successful() || ! ($response->json('success') === true)) {
                $fail('Verifikasi captcha gagal, silakan coba lagi.');
            }
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA verification request failed: ' . $e->getMessage());
            $fail('Tidak dapat memverifikasi captcha saat ini, silakan coba lagi.');
        }
    }
}
