<?php

namespace App\Notifications;

use App\Models\Coupon;
use App\Services\DataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendCoupon extends Notification
{
    use Queueable;

    public $coupon;
    private $newPreviewPath;
    /**
     * Create a new notification instance.
     */
    public function __construct($coupon, $newPreviewPath)
    {

        $this->coupon = $coupon;
        $this->newPreviewPath = $newPreviewPath;
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

        $base_url = 'https://www.adlee.io/';


        // $linetext = '<img src="data:image/png;base64,' . $this->newPreviewPath . '">';
        $clickableText = '<a href="' . $this->coupon->shorten_url_redeem . '" target="_blank">Click Here to Redeem</a>';

        $mail = (new MailMessage)
            ->subject('Coupon Notification')
            ->greeting('')
            ->line(new HtmlString($clickableText))
            ->line(new HtmlString('<img src="cid:image.png">'));

        $mail->attachData($this->newPreviewPath, 'image.png', [
            'mime' => 'image/png',
            'as' => 'image.png',
            'content-id' => 'image.png'
        ]);

        // $mail->attachData($this->newPreviewPath, 'image.png');


        return $mail;
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
