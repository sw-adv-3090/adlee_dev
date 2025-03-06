<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendInvoiceNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Transaction $transaction, public string $filePath, public string $fileName)
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
            ->subject('Invoice')
            ->greeting('Hello!')
            ->line(new HtmlString("Attached is an invoice for your payment to " . $this->transaction->company?->company_name . " on coupon " . $this->transaction->coupon?->number . ". You may also find this invoice in your Adlee portal <a href=" . route("sponsors.transactions.invoice", $this->transaction) . ">here</a>"))
            ->attach($this->filePath, [
                'as' => $this->fileName,
                'mime' => 'application/pdf',
            ]);
        ;
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
