<?php

namespace App\Notifications;

use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PaymentFailedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $name, public string $number, public User $user, public Sponsor $sponsor)
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
        $name = $this->user->name;
        $email = $this->user->email;
        $companyName = $this->sponsor->company_name;
        $companyPhone = $this->sponsor->company_phone;

        return (new MailMessage)
            ->subject("Payment Failed")
            ->greeting("Hello $this->name")
            ->line("Please note, our system has tried 3 times to clear the funds from your Sponsor to pay you for your redeemed coupon of $this->number but has failed to process. Please reach out directly to your Sponsor to get more information.")
            ->line("Sponsor's detials are given below:")
            ->line(new HtmlString("<b>Sponsor Name: </b> $name"))
            ->line(new HtmlString("<b>Sponsor Email Address: </b> $email"))
            ->line(new HtmlString("<b>Sponsor Company: </b> $companyName"))
            ->line(new HtmlString("<b>Sponsor Company Phone: </b> $companyPhone"))
            ->line('Thank you for using our application!')
            ->salutation(new HtmlString("Regards, <br /> Adlee Support"));
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
