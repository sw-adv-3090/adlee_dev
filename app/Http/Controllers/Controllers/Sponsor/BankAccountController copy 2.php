<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Models\BankAccount;
use Illuminate\Support\Str;
class BankAccountController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));
    }

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
        try {
            // Create a bank account token
            $bankAccount = $this->stripe->tokens->create([
                'bank_account' => [
                    'country' => 'US',
                    'currency' => 'usd',
                    'account_holder_name' => $request->account_holder_name,
                    'account_holder_type' => $request->account_holder_type,
                    'routing_number' => $request->routing_number,
                    'account_number' => $request->account_number,
                ],
            ]);


            // Store bank account details in your database
            $account = BankAccount::create([
                'user_id' => auth()->id(),
                'sponsor_id' => sponsorId(),
                'stripe_token_id' => $bankAccount->id,
                'last4' => substr($request->account_number, -4),
                'bank_name' => $bankAccount->bank_account->bank_name,
            ]);

            $stripeCustomerId = $request->user()->stripe_id;
            // $customer = $this->stripe->customers->retrieve($stripeCustomerId);

            $source = $this->stripe->customers->createSource($stripeCustomerId, [
                'source' => $bankAccount->id
            ]);

            // update source id
            $account->update(['stripe_bank_id' => $source->id]);

            // Create a PaymentMethod for the bank account
            $paymentMethod = $this->stripe->paymentMethods->create([
                'type' => 'us_bank_account',
                'billing_details' => [
                    'name' => $request->account_holder_name,
                ],
                'us_bank_account' => [
                    'routing_number' => $request->routing_number,
                    'account_number' => $request->account_number,
                    'account_type' => $request->account_type,
                    'account_holder_type' => $request->account_holder_type,
                ],
            ]);

            // update payment method id
            $account->update(['payment_method_id' => $paymentMethod->id]);

            return redirect()->route('sponsors.banks.verification.index', $account)->with('success', 'Bank account added successfully.');

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
    public function destroy(BankAccount $bankAccount)
    {
        //
    }
}
