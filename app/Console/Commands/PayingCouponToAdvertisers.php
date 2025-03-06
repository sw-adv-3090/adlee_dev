<?php

namespace App\Console\Commands;

use App\Mail\SendInvoice;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Notifications\PaymentFailedNotification;
use App\Services\PayoutService;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Notifications\PaymentNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PayingCouponToAdvertisers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupons:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will pay coupons to advertisers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // getting all the coupons who are paying today and still not payed out
        $coupons = Coupon::query()
            ->with(['user:id,stripe_payment_method_id,stripe_id,tapfiliate_id', 'redeem:id,name,email,stripe_account_id,tapfiliate_id', 'sponsor:id,paying_commission,company_name,ein_number,company_phone', 'transactions:id,coupon_id,amount,created_at', 'task:id,coupon_id,printed_at,signed_at,template_id'])
            ->withSum('transactions', 'amount')
            ->whereNull('payout_at')
            ->whereDay('payout_on', now()->day)
            ->get();

        if ($coupons->count() > 0) {
            $stripe = new StripeService();
            $payout = new PayoutService();

            foreach ($coupons as $coupon) {
                // only send payments if BBO signed and printed the templated
                if ($coupon->task?->signed_at && $coupon->task?->printed_at) {
                    $payout->sendPayment($coupon, $coupon->amount, $stripe);

                    // $sponsor = $coupon->sponsor;
                    // $senderId = $coupon->user->id;
                    // $senderStripeId = $coupon->user->stripe_id;
                    // $paymentMethodId = $coupon->user->stripe_payment_method_id;
                    // $receiverId = $coupon->redeem->id;
                    // $receiverAccountId = $coupon->redeem->stripe_account_id;
                    // $payingCommission = $sponsor->paying_commission == 1;
                    // $plan = $coupon->user->plan();
                    // if ($plan) {
                    //     $couponAmount = $coupon->amount;
                    //     $paidAmount = $coupon->transactions_sum_amount ?? 0;
                    //     $amountToPaid = $couponAmount - $paidAmount;
                    //     $achTransactionFee = ($plan->ach_transaction_fee / 100) * $amountToPaid;
                    //     $creditCardTransactionFee = ($plan->credit_card_transaction_fee / 100) * $amountToPaid;
                    //     $serviceFee = ($plan->transaction_service_fee / 100) * $amountToPaid;

                    //     $payingAmount = $amountToPaid + $creditCardTransactionFee;
                    //     if ($payingCommission) {
                    //         $payingAmount += $serviceFee;
                    //         $bboAmount = $amountToPaid;
                    //     } else {
                    //         $bboAmount = $amountToPaid - $serviceFee;
                    //     }


                    //     $description = "Paying from sponsor(" . $coupon->sponsor->company_name . ", " . $coupon->sponsor->ein_number . ") for coupon " . $coupon->number . " to pay to " . $coupon->redeem->email;

                    //     // charging sponsor though payment method
                    //     $payment = $stripe->payment_intent([
                    //         'stripe_customer_id' => $senderStripeId,
                    //         'amount' => $payingAmount,
                    //         'payment_method_id' => $paymentMethodId,
                    //         'return_url' => route('dashboard'),
                    //         'description' => $description
                    //     ]);

                    //     //  sending funds to BBO
                    //     if (isset($payment->latest_charge)) {
                    //         $transfer = $stripe->transfer([
                    //             'amount' => $bboAmount,
                    //             'destination' => $receiverAccountId,
                    //             'chargeId' => $payment->latest_charge,
                    //         ]);

                    //         // creating transaction object
                    //         $transaction = Transaction::create([
                    //             'sender_id' => $senderId,
                    //             'receiver_id' => $receiverId,
                    //             'sponsor_id' => $sponsor->id,
                    //             'coupon_id' => $coupon->id,
                    //             'amount' => $amountToPaid,
                    //             'paid_amount' => $payingAmount,
                    //             'receiver_amount' => $bboAmount,
                    //             'transaction_fee' => $creditCardTransactionFee,
                    //             'service_fee' => $serviceFee,
                    //             'payment_intent_id' => $payment->id,
                    //             'transfer_id' => $transfer->id,
                    //             'description' => $description,
                    //             'status' => $payment->status,
                    //             'number' => Str::random(15),
                    //             'transaction_fee_percentage' => $plan->credit_card_transaction_fee / 100,
                    //             'service_fee_percentage' => $plan->transaction_service_fee / 100,
                    //             'commission_paid' => $payingCommission,
                    //         ]);

                    //         // change coupon status to paid
                    //         $coupon->update(['payout_at' => now()]);

                    //         // sending invoice to Sponsor
                    //         $transaction->load(['sender', 'receiver', 'sponsor', 'company']);
                            // Mail::to($transaction->sender)->send(new SendInvoice($transaction,'sponsor'));

                    //         // sending email notification to BBO about payment
                    //         Notification::send($coupon->redeem, new PaymentNotification($coupon->redeem->name, $coupon->number, 0));
                    //     } else {
                    //         // payment failed, add payout date to 3 days for next retry
                    //         $newPayoutDate = Carbon::parse($coupon->payout_on)->addDays(3);
                    //         $failedTries = $coupon->failed_tries + 1;
                    //         $coupon->update(['payout_on' => $newPayoutDate, 'failed_tries' => $failedTries]);

                    //         // it has been tried 3 times, so send mail to BBO about sponsor details
                    //         if ($failedTries == 3) {
                    //             Notification::send($coupon->redeem, new PaymentFailedNotification($coupon->redeem->name, $coupon->number, $coupon->redeem, $coupon->sponsor));
                    //         }

                    //     }
                    // }
                }

            }
        }

        $this->info("Transaction Success!");

    }
}
