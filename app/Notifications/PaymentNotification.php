<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $name, public string $number, public $balance, public bool $isFullyPaid)
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
            ->subject("Payment Received")
            ->greeting("Hello $this->name")
            ->lineIf($this->isFullyPaid, "Please note, your sponsor has done a full payment for your redeemed coupon of $this->number and it has been fully paid off.")
            ->lineIf(!$this->isFullyPaid, "Please note, your sponsor has done a partial payment for your redeemed coupon of $this->number with a remaining balance of $$this->balance.")
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
