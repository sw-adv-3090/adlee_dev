<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateShortenUrlForAdSpaceOwner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-shorten-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update all old shortening url for ad space owner of redeem coupons';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $baseUrl = "https://adlee.dev.com";
        $baseUrl = "https://adlee.io";

        $urls = DB::table("short_urls")->where('destination_url', 'LIKE', "%$baseUrl/coupons/%")->get();
        foreach ($urls as $item) {
            $url = "$baseUrl/ad-space-owner/coupons" . explode("$baseUrl/coupons", $item->destination_url)[1];
            DB::table("short_urls")->where('id', $item->id)->update(['destination_url' => $url]);
        }

        $this->info("Done");
    }
}
