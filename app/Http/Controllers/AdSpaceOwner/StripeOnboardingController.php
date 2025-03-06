<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdSpaceOwner\OnboardingRequest;
use Illuminate\Http\Request;

class StripeOnboardingController extends Controller
{
    private $user, $adSpaceOwner, $stripe;

    /**
     * Initializes the controller constructor
     */
    public function __construct()
    {
        $this->user = request()->user();
        $this->adSpaceOwner = request()->user()->adSpaceOwner;
        $this->stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ad-space-owner.basic-settings.onboarding', [
            'adSpaceOwner' => $this->adSpaceOwner,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OnboardingRequest $request)
    {
        $accountId = $this->user->stripe_account_id;

        try {
            // creating a new stripe customer
            if (is_null($this->user->stripe_id)) {
                $customer = $this->stripe->customers->create([
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'phone' => $this->adSpaceOwner->company_phone,
                ]);

                $this->user->update(['stripe_id' => $customer->id]);

            }

            // creating stripe account
            if (is_null($this->user->stripe_account_id)) {
                $account = $this->stripe->accounts->create([
                    'type' => 'express',
                    'email' => $this->user->email,
                    'business_type' => $request->business_type,
                    'country' => $request->country,
                    'default_currency' => "USD",
                    // 'controller' => [
                    //     'fees' => ['payer' => 'application'],
                    //     'losses' => ['payments' => 'application'],
                    //     'stripe_dashboard' => ['type' => 'express'],
                    // ],
                ]);

                $this->user->update(['stripe_account_id' => $account->id, 'country' => $request->country, 'business_type' => $request->business_type,]);
                $accountId = $account->id;
            }

            // redirect user to stripe onboarding page if not connected with stripe
            if (!$this->user->completed_onboarding) {
                // creating stripe onboarding link and redirect
                $onboardLink = $this->stripe->accountLinks->create([
                    'account' => $accountId,
                    'refresh_url' => route('ad-space-owner.basic-settings.onboarding.refresh'),
                    'return_url' => route('ad-space-owner.basic-settings.onboarding.success', ['account_id' => $accountId]),
                    'type' => 'account_onboarding',
                ]);

                return redirect()->away($onboardLink->url);
            }

            // $loginLink = $this->stripe->accounts->createLoginLink($accountId);
            // return redirect()->away($loginLink->url);

            return redirect()->route('ad-space-owner.basic-settings.plans.index')->with('success', 'Onboarding successful');

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    /**
     * Handle stripe onboarding success response.
     */
    public function success(Request $request)
    {
        try {
            if (isset($request->account_id)) {
                // abort if account id does not belong to user
                abort_if($request->account_id != $this->user->stripe_account_id, 403);

                $account = $this->stripe->accounts->retrieve(
                    $request->account_id,
                    []
                );

                // abort if account not found from stripe
                abort_if(is_null($account), 404);

                if ($account->charges_enabled && $account->details_submitted) {
                    $this->user->update([
                        'completed_onboarding' => true,
                    ]);

                    return redirect()->route('ad-space-owner.dashboard')->with('success', 'Onboarding successfully completed!');
                } else {
                    return to_route("ad-space-owner.basic-settings.onboarding.index")->with('error', "Account details not submitted yet!");
                }

            } else {
                return to_route("ad-space-owner.basic-settings.onboarding.index")->with('error', "Something went wrong!");
            }
        } catch (\Exception $ex) {
            return to_route("ad-space-owner.basic-settings.onboarding.index")->with('error', $ex->getMessage());
        }
    }

    /**
     * Handle stripe onboarding refresh response.
     */
    public function refresh(Request $request)
    {
        $accountId = $this->user->stripe_account_id;

        // creating stripe onboarding link and redirect
        $onboardLink = $this->stripe->accountLinks->create([
            'account' => $accountId,
            'refresh_url' => route('ad-space-owner.basic-settings.onboarding.refresh'),
            'return_url' => route('ad-space-owner.basic-settings.onboarding.success', ['account_id' => $accountId]),
            'type' => 'account_onboarding',
        ]);

        return redirect()->away($onboardLink->url);
    }
}
