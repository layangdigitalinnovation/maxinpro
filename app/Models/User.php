<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailMethods;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    // MustVerifyEmailMethods provides the concrete implementations
    // (hasVerifiedEmail, markEmailAsVerified, getEmailForVerification, etc.)
    // required by the MustVerifyEmail interface above — the interface alone
    // has no method bodies, so this trait is NOT optional.
    use HasFactory, Notifiable, MustVerifyEmailMethods, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            // Encrypted transparently at rest — even a raw DB dump doesn't
            // expose usable TOTP secrets or recovery codes.
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted:array',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    public function hasTwoFactorEnabled(): bool
    {
        return ! is_null($this->two_factor_confirmed_at) && ! is_null($this->two_factor_secret);
    }

    /**
     * Generates a fresh, unconfirmed TOTP secret. Not yet "enabled" until the
     * user proves possession by submitting a valid code (see confirmTwoFactor()).
     */
    public function generateTwoFactorSecret(): string
    {
        $secret = (new Google2FA())->generateSecretKey();

        $this->forceFill(['two_factor_secret' => $secret, 'two_factor_confirmed_at' => null])->save();

        return $secret;
    }

    public function twoFactorQrCodeUrl(): string
    {
        $otpauth = (new Google2FA())->getQRCodeUrl(
            config('app.name'),
            $this->email,
            $this->two_factor_secret
        );

        // Rendered via a public QR image service rather than pulling in a
        // local QR-rendering library — keeps the dependency footprint small.
        return 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($otpauth);
    }

    public function verifyTwoFactorCode(string $code): bool
    {
        if (! $this->two_factor_secret) {
            return false;
        }

        return (bool) (new Google2FA())->verifyKey($this->two_factor_secret, $code);
    }

    public function confirmTwoFactor(string $code): bool
    {
        if (! $this->verifyTwoFactorCode($code)) {
            return false;
        }

        $this->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => $this->generateRecoveryCodes(),
        ])->save();

        return true;
    }

    public function disableTwoFactor(): void
    {
        $this->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();
    }

    /**
     * Consumes (single-use) a recovery code if valid. Used as a fallback login
     * path when the user has lost access to their authenticator app.
     */
    public function useRecoveryCode(string $code): bool
    {
        $codes = $this->two_factor_recovery_codes ?? [];
        $match = collect($codes)->first(fn ($c) => hash_equals($c, strtoupper(trim($code))));

        if (! $match) {
            return false;
        }

        $this->forceFill([
            'two_factor_recovery_codes' => collect($codes)->reject(fn ($c) => $c === $match)->values()->all(),
        ])->save();

        return true;
    }

    protected function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))
            ->map(fn () => Str::upper(Str::random(4) . '-' . Str::random(4)))
            ->all();
    }

    public function agentProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Agent::class);
    }

    public function savedListings(): HasMany
    {
        return $this->hasMany(SavedListing::class);
    }
}
