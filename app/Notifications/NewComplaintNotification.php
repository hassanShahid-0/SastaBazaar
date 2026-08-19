<?php

namespace App\Notifications;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComplaintNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly Complaint $complaint)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Overcharging Complaint Filed — SastaBazaar')
            ->greeting('Dear District Officer,')
            ->line("A new complaint has been submitted on the SastaBazaar Portal.")
            ->line("**Complaint #" . $this->complaint->id . "**")
            ->line("- **Citizen:** {$this->complaint->citizen_name} ({$this->complaint->citizen_phone})")
            ->line("- **Shop:** {$this->complaint->shop_name}")
            ->line("- **Location:** {$this->complaint->location_address}")
            ->line("- **Description:** {$this->complaint->description}")
            ->action('View in Admin Panel', url('/admin/complaints/' . $this->complaint->id))
            ->line('Please review and take appropriate action promptly.')
            ->salutation('SastaBazaar District Administration Portal');
    }
}