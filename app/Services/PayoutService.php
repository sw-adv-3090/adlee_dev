<?php

namespace App\Services;

use App\Models\Transaction;
use App\Notifications\SendInvoiceNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PaymentNotification;
use App\Mail\SendInvoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * Class PayoutService.
 */
class PayoutService
{
    public function sendPayment($coupon, $amount, $stripe)
    {
        $sponsor = $coupon->sponsor;
        $senderId = $coupon->user->id;
        $senderStripeId = $coupon->user->stripe_id;
        $paymentMethodId = $coupon->user->stripe_payment_method_id;
        $receiverId = $coupon->redeem->id;
        $receiverAccountId = $coupon->redeem->stripe_account_id;
        $payingCommission = $sponsor->paying_commission == 1;
        $plan = $coupon->user->plan();

        if ($plan) {
            $couponAmount = $coupon->amount;
            $paidAmount = ($coupon->transactions_sum_amount ?? 0) + $amount;
            $amountToPaid = $amount;
            $remainingAmount = $couponAmount - $paidAmount;

            $achTransactionFee = ($plan->ach_transaction_fee / 100) * $amountToPaid;
            $creditCardTransactionFee = ($plan->credit_card_transaction_fee / 100) * $amountToPaid;
            $serviceFee = ($plan->transaction_service_fee / 100) * $amountToPaid;

            $payingAmount = $amountToPaid + $creditCardTransactionFee;
            if ($payingCommission) {
                $payingAmount += $serviceFee;
                $bboAmount = $amountToPaid;
            } else {
                $bboAmount = $amountToPaid - $serviceFee;
            }
            // dd("paid amount: $paidAmount", "credit card fee: $creditCardTransactionFee($plan->credit_card_transaction_fee%)", "paying amount: $payingAmount", "service fee: $serviceFee($plan->transaction_service_fee%)", "bbo amount: $bboAmount");


            $description = "Paying from sponsor(" . $coupon->sponsor->company_name . ", " . $coupon->sponsor->ein_number . ") for coupon " . $coupon->number . " to pay to " . $coupon->redeem->email;

            // charging sponsor though payment method
            $payment = $stripe->payment_intent([
                'stripe_customer_id' => $senderStripeId,
                'amount' => $payingAmount,
                'payment_method_id' => $paymentMethodId,
                'return_url' => route('dashboard'),
                'description' => $description
            ]);

            //  sending funds to BBO
            if (isset($payment->latest_charge)) {
                $transfer = $stripe->transfer([
                    'amount' => $bboAmount,
                    'destination' => $receiverAccountId,
                    'chargeId' => $payment->latest_charge,
                ]);

                $lastInvoiceNumber = Transaction::latest()->first()?->number ?? "0000000";

                // creating transaction object
                $transaction = Transaction::create([
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'sponsor_id' => $sponsor->id,
                    'coupon_id' => $coupon->id,
                    'amount' => $amountToPaid,
                    'paid_amount' => $payingAmount,
                    'receiver_amount' => $bboAmount,
                    'transaction_fee' => $creditCardTransactionFee,
                    'service_fee' => $serviceFee,
                    'payment_intent_id' => $payment->id,
                    'transfer_id' => $transfer->id,
                    'description' => $description,
                    'status' => $payment->status,
                    'number' => next_number($lastInvoiceNumber, 7),
                    'transaction_fee_percentage' => $plan->credit_card_transaction_fee,
                    'service_fee_percentage' => $plan->transaction_service_fee,
                    'commission_paid' => $payingCommission,
                ]);

                // change coupon status to paid
                if ($remainingAmount == 0) {
                    $coupon->update(['payout_at' => now()]);
                }

                // sending invoice to Sponsor
                $transaction->load(['sender', 'receiver', 'sponsor', 'company', 'coupon']);
                // Mail::to($transaction->sender)->send(new SendInvoice($transaction, 'sponsor'));
                $pdf = Pdf::loadView("emails.invoice", ['transaction' => $transaction, 'type' => 'sponsor'])->setPaper('legal', 'landscape');
                $fileName = "$transaction->number.pdf";
                $filePath = public_path('storage/invoices') . '/' . $fileName;
                Storage::disk('public')->put("invoices/$fileName", $pdf->output());
                Notification::send($transaction->sender, new SendInvoiceNotification($transaction, $filePath, $fileName));
                // delete file from public folder
                File::delete($filePath);

                // sending email notification to BBO about payment
                Notification::send($coupon->redeem, new PaymentNotification($coupon->redeem->name, $coupon->number, $remainingAmount, $remainingAmount == 0));

                // sending commission to tapfiliate program
                $tapfliate = new TapfiliateService();
                // sending commission to tapfiliate sponsors program
                if (!is_null($coupon->user->tapfiliate_id)) {
                    $tapfliate->conversions([
                        'clickId' => $coupon->user->tapfiliate_id,
                        'externalId' => "sponsor-$transaction->uuid", // adding program name at start to have unique identifier
                        'amount' => $amount
                    ]);
                }
                // sending commission to tapfiliate ad space owner program
                if (!is_null($coupon->redeem->tapfiliate_id)) {
                    $tapfliate->conversions([
                        'clickId' => $coupon->redeem->tapfiliate_id,
                        'externalId' => "bbo-$transaction->uuid", // adding program name at start to have unique identifier
                        'amount' => $bboAmount
                    ]);
                }

                return true;
            } else {
                // payment failed, notify the BBO
                // payment failed, add payout date to 3 days for next retry
                $newPayoutDate = Carbon::parse($coupon->payout_on)->addDays(3);
                $failedTries = $coupon->failed_tries + 1;
                $coupon->update(['payout_on' => $newPayoutDate, 'failed_tries' => $failedTries]);

                // it has been tried 3 times, so send mail to BBO about sponsor details
                if ($failedTries == 3) {
                    Notification::send($coupon->redeem, new PaymentFailedNotification($coupon->redeem->name, $coupon->number, $coupon->redeem, $coupon->sponsor));
                }
            }
        }

        return false;
    }
}
