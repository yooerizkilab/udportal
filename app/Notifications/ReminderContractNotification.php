<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderContractNotification extends Notification
{
    use Queueable;

    protected $contract;

    /**
     * Create a new notification instance.
     */
    public function __construct($contract)
    {
        $this->contract = $contract;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'whatsapp'];
        // return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengingat Masa Kontrak')
            ->line("Masa kontrak {$this->contract->name} akan berakhir dalam beberapa hari.")
            ->action('Perbarui Kontrak', route('contract.index'))
            ->line('Harap segera mengambil tindakan.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * 
     * Get the WhatsApp representation of the notification.
     */

    // public function toWhatsApp(object $notifiable): WhatsAppMessage
    // {
    //     return (new WhatsAppMessage)
    //         ->content("Masa kontrak {$this->contract->name} akan berakhir dalam beberapa hari. Harap segera mengambil tindakan.");
    // }
}
