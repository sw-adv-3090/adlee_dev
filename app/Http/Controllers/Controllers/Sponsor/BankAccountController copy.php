<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountRequest;
use App\Models\BankAccount;
use Illuminate\Support\Str;
class BankAccountController extends Controller
{
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
        // dd(Str::studly(str_replace('.', '_', 'payment_intent.payment_failed')));
        return view('sponsor.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankAccountRequest $request)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));

        // Create bank account token
        $bankAccount = $stripe->tokens->create([
            'bank_account' => [
                'country' => 'US',
                'currency' => 'usd',
                'account_holder_name' => $request->account_holder_name,
                'account_holder_type' => 'individual',
                'routing_number' => $request->routing_number,
                'account_number' => $request->account_number,
            ],
        ]);

        $stripeCustomerId = $request->user()->stripe_id;
        $customer = $stripe->customers->retrieve($stripeCustomerId);
        // $customer->sources->create(['source' => $bankAccount->id]);
        // $customer->createSource($bankAccount->id);
        $stripe->customers->createSource($stripeCustomerId, [
            'source' => $bankAccount->id
        ]);

        // Create a $1 verification payment intent
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 100, // $1.00 in cents
            'currency' => 'usd',
            'customer' => $stripeCustomerId,
            'payment_method_types' => ['us_bank_account'],
            'payment_method_data' => [
                'type' => 'ach_debit',
                'ach_debit' => [
                    'token' => $bankAccount->id
                ],
            ],
            'confirm' => true,
        ]);

        // Store bank account details in your database
        $account = BankAccount::create([
            'user_id' => auth()->id(),
            'sponsor_id' => sponsorId(),
            'stripe_id' => $paymentIntent->payment_method,
            'last4' => substr($request->account_number, -4),
            'bank_name' => $bankAccount->bank_account->bank_name,
            'is_verified' => false
        ]);

        // Store payment verification instance for later use
        $account->verification()->create([
            'payment_intent_id' => $paymentIntent->id,
        ]);

        return redirect()->route('sponsor.banks.index')->with('success', 'Bank account added successfully. You will be notified once it is verified.');

        try {
            // Create bank account token
            $bankAccount = $stripe->tokens->create([
                'bank_account' => [
                    'country' => 'US',
                    'currency' => 'usd',
                    'account_holder_name' => $request->account_holder_name,
                    'account_holder_type' => 'individual',
                    'routing_number' => $request->routing_number,
                    'account_number' => $request->account_number,
                ],
            ]);

            $stripeCustomerId = $request->user()->stripe_id;
            $customer = $stripe->customers->retrieve($stripeCustomerId);
            $customer->sources->create(['source' => $bankAccount->id]);

            // Create a $1 verification payment intent
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => 100, // $1.00 in cents
                'currency' => 'usd',
                'customer' => $stripeCustomerId,
                'payment_method_types' => ['ach_debit'],
                'payment_method_data' => [
                    'type' => 'ach_debit',
                    'ach_debit' => [
                        'token' => $bankAccount->id
                    ],
                ],
                'confirm' => true,
            ]);

            // Store bank account details in your database
            $account = BankAccount::create([
                'user_id' => auth()->id(),
                'sponsor_id' => sponsorId(),
                'stripe_id' => $paymentIntent->payment_method,
                'last4' => substr($request->account_number, -4),
                'bank_name' => $bankAccount->bank_account->bank_name,
                'is_verified' => false
            ]);

            // Store payment verification instance for later use
            $account->verification()->create([
                'payment_intent_id' => $paymentIntent->id,
            ]);

            return redirect()->route('sponsor.banks.index')->with('success', 'Bank account added successfully. You will be notified once it is verified.');


        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
