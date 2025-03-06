<?php

namespace App\Console\Commands;

use App\Mail\SendInvoice;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Notifications\CouponRedeemed;
use App\Notifications\PaymentFailedNotification;
use Illuminate\Console\Command;
use Notification;
use Illuminate\Support\Facades\Mail;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-command';

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
        // $coupon = Coupon::with(['user:id,email', 'sponsor:id,company_name,company_phone', 'adSpaceOwner', 'redeem.sponsor'])->where('number', '975-MS-0005')->first();
        // Notification::send($coupon->user, new CouponRedeemed($coupon));
        // Notification::send($coupon->redeem, new PaymentFailedNotification($coupon->redeem->name, $coupon->number, $coupon->redeem, $coupon->sponsor));

        $transaction = Transaction::with(['sender', 'receiver', 'sponsor', 'company'])->first();
        // Mail::to($transaction->sender)->send(new SendInvoice($transaction));
        Mail::to("developer3066@gmail.com")->send(new SendInvoice($transaction, 'sponsor'));

        $this->info('Test command executed successfully.');
    }
}
