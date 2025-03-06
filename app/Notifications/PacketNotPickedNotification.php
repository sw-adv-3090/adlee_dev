<?php

namespace App\Notifications;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PacketNotPickedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Shipment $shipment)
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
            ->subject("Packet Not Picked Up")
            ->line('Please note, job number "' . $this->shipment->shipment_id . '" with tracking number "' . $this->shipment->tracking_number . '" with label id "' . $this->shipment->label_id . '" for "' . $this->shipment->bookletPrint?->user?->sponsor?->company_name . '" has not been picked up yet by the carrier. Please confirm the job was completed and is ready for pickup. Thank you');
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
