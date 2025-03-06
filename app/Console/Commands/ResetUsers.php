<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-users';

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
        $users = User::whereLike(['email', 'name'], 'dannys')->get();

        foreach ($users as $user) {
            $user->templates()->delete();
            $user->sponsor()->delete();
            $subscriptions = $user->subscriptions()->get();
            foreach ($subscriptions as $subscription) {
                foreach ($subscription->items as $item) {
                    $item->delete();
                }
                $subscription->delete();
            }

            $user->coupons()->delete();

            DB::table('sessions')->where('user_id', $user->id)->delete();

            $user->delete();
        }

        $this->info('Done');
    }
}
