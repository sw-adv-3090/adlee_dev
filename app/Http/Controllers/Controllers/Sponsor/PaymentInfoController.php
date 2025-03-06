<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentInfoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));
        $paymentMethods = $stripe->customers->allPaymentMethods($request->user()->stripe_id)->data;

        if (count($paymentMethods) > 0) {
            $paymentMethod = $paymentMethods[0];
            $request->user()->update([
                'stripe_payment_method_id' => $paymentMethod['id'],
                'pm_type' => $paymentMethod['type'],
                'pm_last_four' => isset($paymentMethod['card']) ? $paymentMethod['card']['last4'] : null,
            ]);

            return to_route('sponsors.dashboard');
        } else {
            return view('sponsor.flow.payment-info');
        }


    }
}
