<?php

namespace App\Notifications;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShipmentStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Shipment $shipment, public string $from)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Shipment Status Changed")
            ->greeting("Dear " . $this->shipment->bookletPrint?->user?->name)
            ->line('Please note, the status for your print booklet job number "' . $this->shipment->shipment_id . '" with tracking number "' . $this->shipment->tracking_number . '" has been changed from "' . ucwords(str_replace("_", " ", $this->from)) . '" to "' . ucwords(str_replace("_", " ", $this->shipment->tracking_status)) . '" on ' . $this->shipment->updated_at->format('F j, Y h:i:A') . '.')
            ->line('Thank you for using our application!');
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
}
