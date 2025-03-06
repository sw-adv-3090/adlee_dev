<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendBookletForPrint extends Notification
{
    use Queueable;

    public $userName;
    public $filePath;
    public $fileName;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $userName, string $filePath, string $fileName)
    {
        $this->userName = $userName;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
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
            ->subject('Print Booklet Request')
            ->greeting('Hello,')
            ->line('A new request has been made for printing the booklet from ' . $this->userName . '.')
            ->line('Please see the attachments for more information')
            ->attach($this->filePath, [
                'as' => $this->fileName,
                'mime' => 'application/zip',
            ]);
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
