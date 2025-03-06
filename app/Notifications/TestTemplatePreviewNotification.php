<?php

namespace App\Notifications;

use App\Enums\TemplateType;
use App\Models\Template;
use App\Services\TestDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestTemplatePreviewNotification extends Notification
{
    use Queueable;

    public $template;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->template = Template::first();
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
        $service = new TestDataService();

        return (new MailMessage)->view($this->template->view, $service->template());
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
