<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionCheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $plan = Plan::select(['stripe_price_id'])->find($request->planId);

        return $request->user()
            ->newSubscription('default', $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('sponsors.checkout-success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('sponsors.checkout-cancel'),
                // 'return_url' => route('sponsors.checkout-cancel'),
            ]);
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));
        $paymentMethod = $stripe->customers->allPaymentMethods($request->user()->stripe_id)->data[0];
        $request->user()->update([
            'stripe_payment_method_id' => $paymentMethod['id'],
            'pm_type' => $paymentMethod['type'],
            'pm_last_four' => isset($paymentMethod['card']) ? $paymentMethod['card']['last4'] : null,
        ]);

        // update user payment method information
        $request->user()->updateDefaultPaymentMethod($paymentMethod['id']);
        $request->user()->updateDefaultPaymentMethodFromStripe();

        return to_route(route_name() . '.dashboard')->with('success', 'Successfully subscribes to subscription.');
    }

    public function cancel()
    {
        return to_route('sponsors.subscription-checkout')->with('error', 'Subscription Checkout Cancelled.');
    }
}
