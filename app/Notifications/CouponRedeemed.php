<?php

namespace App\Notifications;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CouponRedeemed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Coupon $coupon)
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
            ->subject('Coupon Redeemed')
            ->greeting("Dear " . $this->coupon->sponsor->company_name)
            ->line("Your coupon " . $this->coupon->number . " has been redeemed by " . $this->coupon->adSpaceOwner->company_name . " at " . $this->coupon->redeemed_at?->format('m-d-Y h:i:A'))
            ->line('Please click the below button for more information.')
            ->action('Click Me', route('sponsors.coupons.show', $this->coupon->uuid))
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
