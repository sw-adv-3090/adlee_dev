<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Mail\SendInvoice;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PaymentNotification;
use App\Services\PayoutService;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class CouponPayoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Coupon $coupon)
    {
        $coupon->loadSum('transactions', 'amount');

        return view('sponsor.coupons.payout', compact('coupon'));
    }

    /**
     * Sending payment to BBO.
     */
    public function payout(Request $request, Coupon $coupon)
    {
        $coupon->load(['user:id,stripe_payment_method_id,stripe_id,tapfiliate_id', 'redeem:id,name,email,stripe_account_id,tapfiliate_id', 'sponsor:id,paying_commission,company_name,ein_number,company_name', 'transactions:id,coupon_id,amount,created_at', 'task:id,coupon_id,printed_at,signed_at,template_id'])->loadSum('transactions', 'amount');
        $stripe = new StripeService();
        $payout = new PayoutService();

        if ($coupon->task?->signed_at && $coupon->task?->printed_at) {
            $status = $payout->sendPayment($coupon, $request->amount, $stripe);
            if (!$status) {
                return back()->with('error', 'Something went wroung while sending payment!');
            }
            return to_route('sponsors.coupons.index')->with('status', 'Successfully sent payment to Ad Space Owner!');
        }

        return back()->with('error', 'Sending payment failed! Ad Space Owner still has not finished signing and printing the template.');
    }

    /**
     * Handle the incoming request of bulk payout.
     */
    public function bulk(Request $request)
    {
        // check if request has not contain coupons ids and if it is not array then return back with error message
        if (!isset($request->coupons) || !is_array($request->coupons)) {
            return back()->with('error', 'Please select at least one coupon.');
        }

        $data = [];
        $data['total'] = count($request->coupons);
        $data['paidOut'] = 0;
        $data['notRedemed'] = 0;
        $data['notSigned'] = 0;
        $data['notPrinted'] = 0;
        $data['coupons'] = [];
        foreach ($request->coupons as $couponId) {
            $coupon = Coupon::with(['task:id,coupon_id,printed_at,signed_at,template_id'])->withSum('transactions', 'amount')->where('uuid', $couponId)->first();
            if (!$coupon) {
                abort(404);
            }

            if (is_null($coupon->redeemed_by)) {
                $data['notRedemed'] += 1;
            } else if (is_null($coupon->task?->signed_at)) {
                $data['notSigned'] += 1;
            } else if (is_null($coupon->task?->printed_at)) {
                $data['notPrinted'] += 1;
            } else if ($coupon->transactions_sum_amount == $coupon->amount) {
                $data['paidOut'] += 1;
            } else {
                $item['uuid'] = $coupon->uuid;
                $item['number'] = $coupon->number;
                $item['amount'] = $coupon->amount;
                $item['paid'] = $coupon->transactions_sum_amount ?? 0;
                $item['remaining'] = $item['amount'] - $item['paid'];
                $data['coupons'][] = $item;
            }

        }
        
// dd($request->coupons);
        $data['isBookletCoupons'] = Coupon::whereIn('uuid', $request->coupons)->whereNotNull('booklet_id')->exists() ? true : false;
        $coupon_bid = Coupon::whereIn('uuid', $request->coupons)->whereNotNull('booklet_id')->first();
        $data['bookletId'] = isset($coupon_bid->booklet_id) ? $coupon->booklet_id : null;

        return view('sponsor.coupons.bulk-payout', compact('data'));
    }

    /**
     * Sending bulk payment to BBO.
     */
    public function bulkPayout(Request $request)
    {
        $coupons = $request->get('coupons');
        if (count($coupons) == 0) {
            return back()->with('error', 'Something went wroung while sending payment!');
        }

        $stripe = new StripeService();
        $payout = new PayoutService();

        foreach ($coupons as $item) {
            $coupon = Coupon::with(['user:id,stripe_payment_method_id,stripe_id,tapfiliate_id', 'redeem:id,name,email,stripe_account_id,tapfiliate_id', 'sponsor:id,paying_commission,company_name,ein_number,company_phone', 'transactions:id,coupon_id,amount,created_at', 'task:id,coupon_id,printed_at,signed_at,template_id'])->withSum('transactions', 'amount')->where('uuid', $item['uuid'])->first();

            if ($coupon && $coupon->task?->signed_at && $coupon->task?->printed_at) {
                $payout->sendPayment($coupon, $item['amount'], $stripe);
            }
        }

        return to_route('sponsors.coupons.index')->with('status', 'Successfully sent payments to Ad Space Owners!');
    }

    private function sendPayment($coupon, $amount, $stripe)
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
                    'number' => Str::random(15),
                    'transaction_fee_percentage' => $plan->credit_card_transaction_fee / 100,
                    'service_fee_percentage' => $plan->transaction_service_fee / 100,
                    'commission_paid' => $payingCommission,
                ]);

                // change coupon status to paid
                if ($remainingAmount == 0) {
                    $coupon->update(['payout_at' => now()]);
                }

                // sending invoice to Sponsor
                $transaction->load(['sender', 'receiver', 'sponsor', 'company']);
                Mail::to($transaction->sender)->send(new SendInvoice($transaction, 'sponsor'));

                // sending email notification to BBO about payment
                Notification::send($coupon->redeem, new PaymentNotification($coupon->redeem->name, $coupon->number, $remainingAmount, $remainingAmount == 0));

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
