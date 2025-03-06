<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;



class ImagePreviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $newImagePath;
    private $newPreviewPath;
    private $type;

    public function __construct($newImagePath, $newPreviewPath, $type)
    {
        $this->newImagePath = $newImagePath;
        $this->newPreviewPath = $newPreviewPath;
        $this->$type = $type;
    }

    public function via($notifiable)
    {
        return ['mail']; // Specify mail channel
    }

    public function toMail($notifiable)
    {
        if (!File::exists($this->newPreviewPath) || !is_readable($this->newPreviewPath)) {
            // Handle file absence or permission issue
            \Log::error('Attachment file not found or unreadable.');
            return; // or throw exception
        }

        $linetext = 'There is a new Sponsorship template that needs to be reviewed. <b><u><a href="https://www.adlee.io/admin/designer-templates">Click here</a></u></b> to review.';
        if ($this->type == 'coupon') {
            $linetext = 'There is a new Coupon template that needs to be reviewed. <b><u><a href="https://www.adlee.io/admin/designer-templates">Click here</a></u></b> to review.';
        }

        $mail = (new MailMessage)
            ->subject('New template added for review')
            ->greeting('Hello!')
            ->line(new HtmlString($linetext));

        $mail->attach($this->newPreviewPath);

        return $mail;
    }

    public function toArray($notifiable)
    {
        return [];
    }
}