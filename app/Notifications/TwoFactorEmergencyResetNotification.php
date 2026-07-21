<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

/**
 * Sent when someone requests to disable 2FA because they lost both their
 * authenticator device AND their recovery codes. The signed link is the
 * "second factor" here — possession of the registered email inbox stands
 * in for the lost authenticator app. Short-lived (30 min) and single-purpose.
 */
class TwoFactorEmergencyResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::temporarySignedRoute(
            'two-factor.emergency-reset.confirm',
            Carbon::now()->addMinutes(30),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        return (new MailMessage())
            ->subject('Permintaan Nonaktifkan Verifikasi Dua Langkah — MaxinPro')
            ->greeting('Permintaan reset 2FA diterima')
            ->line('Seseorang (semoga Anda) meminta untuk menonaktifkan verifikasi dua langkah pada akun ini karena kehilangan akses ke aplikasi authenticator dan kode pemulihan.')
            ->action('Nonaktifkan Verifikasi Dua Langkah', $url)
            ->line('Tautan ini berlaku 30 menit dan hanya bisa dipakai satu kali.')
            ->line('Jika Anda TIDAK meminta ini, abaikan email ini — 2FA Anda akan tetap aktif dan aman.');
    }
}
