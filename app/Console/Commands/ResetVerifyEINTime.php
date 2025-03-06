<?php

namespace App\Console\Commands;

use App\Models\Sponsor;
use Illuminate\Console\Command;

class ResetVerifyEINTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-ein-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command wil reset the EIN time for sposnsor to verify again';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sponsors = Sponsor::where('ein_number_verify_tries', 3)->get();
        foreach ($sponsors as $sponsor) {
            if ($sponsor->ein_number_verify_last_try->addHours(24)->lt(now())) {
                $sponsor->ein_number_verify_tries = 0;
                $sponsor->ein_number_verify_last_try = now();
                $sponsor->save();
            }
        }

        $this->info("Success! ");

    }
}
