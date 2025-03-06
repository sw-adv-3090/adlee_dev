<?php

namespace App\Http\Controllers;

use App\Notifications\TestNotification;
use App\Notifications\TestTemplatePreviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SendTestEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Notification::route('mail', 'developer3066@gmail.com')
            ->notify(new TestNotification());

        // Notification::route('mail', 'developer3066@gmail.com')
        //     ->notify(new TestTemplatePreviewNotification());

        return "email send successfully.";
    }
}
