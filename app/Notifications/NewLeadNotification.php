<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Lead $lead)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Lead Baru: Titip Properti — ' . $this->lead->name)
            ->greeting('Ada permintaan Titip Properti baru masuk.')
            ->line('Nama: ' . $this->lead->name)
            ->line('WhatsApp: ' . $this->lead->phone)
            ->line('Kota: ' . $this->lead->city)
            ->line('Alamat: ' . $this->lead->address)
            ->when($this->lead->expected_price, fn ($mail) => $mail->line('Harga diharapkan: Rp ' . number_format($this->lead->expected_price, 0, ',', '.')))
            ->action('Lihat di Panel Admin', route('admin.leads.index'))
            ->line('Atau langsung hubungi lewat WhatsApp pribadi Anda: [💬 Chat via WhatsApp](' . $this->lead->waLink() . ')')
            ->line('Segera hubungi calon klien ini secepatnya untuk hasil terbaik.');
    }
}
