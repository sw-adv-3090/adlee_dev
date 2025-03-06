<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Stripe\Stripe;
class BankAccountController extends Controller
{
    // private $stripe;

    // public function __construct()
    // {
    //     $this->stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sponsor.banks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stripeCustomerId = auth()->user()->stripe_id;
        // $customer = $this->stripe->customers->retrieve($stripeCustomerId);
        // dd($customer);
        // Get all payment sources (bank accounts, cards, etc.)
        // $sources = $customer->sources;
        // ba_1QBALVI4xwo1dS3RiA9DBUQB
        // $this->stripe->customers->deleteSource(
        //     $stripeCustomerId,
        //     'ba_1QBDX4I4xwo1dS3RhlZgMlzj',
        //     []
        // );
        // dd($this->stripe->sources->retrieve('ba_1QBALVI4xwo1dS3RiA9DBUQB', []));

        return view('sponsor.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankAccountRequest $request)
    {
        Stripe::setApiKey(config('services.stripe.client_secret'));

        try {
            // Create a PaymentMethod for the bank account
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'us_bank_account',
                'billing_details' => [
                    'name' => $request->account_holder_name,
                ],
                'us_bank_account' => [
                    'account_holder_type' => $request->account_holder_type,
                    'routing_number' => $request->routing_number,
                    'account_number' => $request->account_number,
                ],
            ]);

            $stripeCustomerId = $request->user()->stripe_id;

            // Create a Source for ACH verification (micro-deposits)
            $setupIntent = \Stripe\SetupIntent::create([
                'payment_method_types' => ['us_bank_account'], // Add 'us_bank_account' as a valid type
                'customer' => $stripeCustomerId,  // Replace with your Stripe customer ID
                'payment_method' => $paymentMethod->id, // Attach the unverified payment method
                'confirm' => true,
                'mandate_data' => [
                    'customer_acceptance' => [
                        'type' => 'online',  // Assuming you are accepting mandates online
                        'online' => [
                            'ip_address' => request()->ip(),  // IP address of the customer
                            'user_agent' => request()->header('User-Agent'),  // Browser's User Agent
                        ],
                    ],
                ],
            ]);


            // Store bank account details in your database
            $account = BankAccount::create([
                'user_id' => auth()->id(),
                'sponsor_id' => sponsorId(),
                'setup_intent_id' => $setupIntent->id,
                'payment_method_id' => $paymentMethod->id,
                // 'last4' => substr($request->account_number, -4),
                'last4' => $paymentMethod->us_bank_account->last4,
                'bank_name' => $paymentMethod->us_bank_account->bank_name,
            ]);


            return redirect()->route('sponsors.banks.index')->with('success', 'Bank account added successfully. Stripe has initiated two test micro deposits in your account. Please enter that amounts for verification. Usually it takes 1-2 business days to deposit in your account. The amounts must be entered in cents.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankAccount $bank)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));

            // detach payment method
            $stripe->paymentMethods->detach($bank->payment_method_id, []);

            // cancel payment intent
            // $stripe->setupIntents->cancel('seti_1QBGf2I4xwo1dS3RILENhRK1', []);

            // delete bank account
            $bank->delete();

            return back()->with('success', 'Bank account deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
