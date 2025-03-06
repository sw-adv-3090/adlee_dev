<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyBankRequest;
use App\Models\BankAccount;
use Stripe\Stripe;

class BankAccountVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BankAccount $bank)
    {
        return view('sponsor.banks.verification', ['account' => $bank]);
    }

    public function verify(VerifyBankRequest $request, BankAccount $bank)
    {
        // statuses: 'requires_action', 'succeeded'
        abort_if(!is_null($bank->verified_at), 403);

        Stripe::setApiKey(config('services.stripe.client_secret'));

        $paymentMethod = \Stripe\PaymentMethod::retrieve($bank->payment_method_id);
        $setupIntent = \Stripe\SetupIntent::retrieve($bank->setup_intent_id);

        // Verify the bank account using micro-deposits
        $verification = $setupIntent->verifyMicrodeposits([
            'amounts' => [$request->amount1, $request->amount2],
        ]);

        // If the verification is successful, attach the payment method to the customer
        if ($verification->status === "succeeded") {
            // Attach payment methods to the customer
            $paymentMethod->attach([
                'customer' => $request->user()->stripe_id,
            ]);

            // update bank account details
            $bank->update(['verified_at' => now(), 'active' => true, 'status' => 'verified']);

            return to_route('sponsors.banks.index')->with('success', "Bank account ending with " . $bank->last4 . " has been successfully verified.");

        } else {
            // bank account is not verified
            return back()->with('error', 'Bank account verification failed. Please try again.');
        }
    }
}
