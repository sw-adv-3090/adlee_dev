<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Schedule::command('app:send-inspiring-quote')->everyMinute();
Schedule::command('app:delete-temp-uploaded-files')->hourly();
Schedule::command('app:reset-ein-time')->everyMinute();
Schedule::command('app:packet-not-picked')->weekdays()->skip(function () {
    return now()->isHoliday();
});
Schedule::command('app:track-shipment')->hourly();
Schedule::command('queue:work --tries=3 --stop-when-empty')->everyMinute()->withoutOverlapping();
