<?php

namespace App\Console\Commands;

use App\Models\Sponsor;
use Illuminate\Console\Command;

class SponsorCodeNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sponsor-code-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sponsors = Sponsor::with(['user:id,name'])->select(['code', 'id', 'user_id'])->whereNull('code')->get();

        foreach ($sponsors as $sponsor) {
            $sponsor->update(['code' => code_number(), 'name_code' => name_alphabetic($sponsor->user->name)]);
        }

        $this->info('Done.');
    }
}
