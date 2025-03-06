<?php

namespace App\Console\Commands;

use App\Notifications\InspiringQuoteNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendInspiringQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-inspiring-quote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends inspiring quote.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Notification::route('mail', 'developer3066@gmail.com')
            ->notify(new InspiringQuoteNotification());

        $this->info('Inspiring Quote Sent');
    }
}
