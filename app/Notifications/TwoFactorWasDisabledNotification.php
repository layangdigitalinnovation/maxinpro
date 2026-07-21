<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Confirmation sent AFTER a 2FA emergency reset actually completes — a
 * safety net so the real account owner finds out immediately if someone
 * else (who gained access to their inbox) disabled 2FA without them knowing.
 */
class TwoFactorWasDisabledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Verifikasi Dua Langkah Telah Dinonaktifkan — MaxinPro')
            ->greeting('Konfirmasi: 2FA baru saja dinonaktifkan')
            ->line('Verifikasi dua langkah pada akun Anda baru saja dinonaktifkan lewat proses reset darurat.')
            ->line('Jika ini BUKAN Anda, segera ganti kata sandi akun Anda dan hubungi tim MaxinPro.')
            ->action('Ganti Kata Sandi Sekarang', route('login'));
    }
}
