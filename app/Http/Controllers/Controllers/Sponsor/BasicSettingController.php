<?php

namespace App\Http\Controllers\Sponsor;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\BasicSettingRequest;
use App\Models\Sponsor;
use App\Services\ShipEngineService;
use App\Services\TinCorrectService;
use Illuminate\Http\Request;
use Squire\Models\Country;
use Illuminate\Support\Facades\Http;

class BasicSettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        // user has not subscribed to any plan, redirect him back to subscribe first
        if (!$request->user()->subscribed()) {
            return to_route('sponsors.plans.index');
        }
        return view('sponsor.flow.basic-settings');
    }

    /**
     * Store the basic settings.
     */
    public function store(BasicSettingRequest $request)
    {
        $sponsor = auth()->user()->sponsor;
        $type = $sponsor ? "updated" : 'created';

        $data = $request->validated();

        $data['company_logo'] = $data['company_logo'] ?? $data['old_company_logo'];
        $data['ein_number_verified'] = $sponsor?->ein_number_verified ?? false;
        $data['ein_number_verify_tries'] = 1;
        $data['ein_number_verify_last_try'] = now();
        $data['paying_commission'] = $data['paying_commission'] === UserType::SPONSOR->value;
        $data['is_commemoration'] = isset($data['is_commemoration']) ? true : false;
        $data['code'] = code_number();
        $data['name_code'] = name_alphabetic(auth()->user()->name);

        $sponsor = Sponsor::updateOrCreate(['user_id' => auth()->id()], $data);

        // verifies EIN number using tin api if not verified before
        if (!$data['ein_number_verified']) {
            $service = new TinCorrectService();
            $response = $service->validateTin($request->ein_number, $request->company_name);
            if (!$response['success']) {
                return to_route('sponsors.basic-settings.ein')->with('error', $response['message']);
            } else {
                $sponsor->update(['ein_number_verified' => true]);
            }
        }

        if ($type === "updated") {
            // user has updated his details so redirect user to back
            return back()->with('success', "Details has been updated successfully.");
        } else {
            // redirect user to next page
            return to_route('sponsors.basic-settings.address');
        }

    }

    /**
     * Show the form for verifying EIN number.
     */
    public function showVerifyEIN(Request $request)
    {
        if (!$request->user()->sponsor) {
            return to_route('sponsors.basic-settings');
        }

        $sponsor = $request->user()->sponsor;
        $nextTryAt = $sponsor->ein_number_verify_last_try->addHours(24);
        $canVerify = $sponsor->ein_number_verify_tries != 3;
        $companyName = $sponsor->company_name;
        $einNumber = $sponsor->ein_number;

        return view('sponsor.flow.verify-ein', compact('nextTryAt', 'canVerify', 'companyName', 'einNumber'));
    }

    /**
     * Verify the EIN number.
     */
    public function verifyEIN(Request $request, TinCorrectService $service)
    {
        $request->validate([
            'company_name' => 'required|string',
            'ein_number' => 'required|string',
        ]);

        $sponsor = $request->user()->sponsor;

        $response = $service->validateTin($request->ein_number, $request->company_name);

        // successfully varified
        if ($response['success']) {
            $sponsor->company_name = $request->company_name;
            $sponsor->ein_number = $request->ein_number;
            $sponsor->ein_number_verified = true;
            $sponsor->save();

            if (is_null($sponsor->address) || is_null($sponsor->shipping_address)) {
                return to_route('sponsors.basic-settings.address')->with('status', 'Successfully verified EIN number.');
            }

            return to_route('sponsors.dashboard')->with('status', 'Successfully verified EIN number.');
        } else {
            // unverfied
            $sponsor->ein_number_verify_tries += 1;
            $sponsor->ein_number_verify_last_try = now();
            $sponsor->save();

            return back()->with('error', $response['message']);
        }
    }

    /**
     * Show the form for address.
     */
    public function showAddress()
    {
        // if sponsor EIN number is not verified then redirect to verify
        if (!auth()->user()->sponsor || !auth()->user()->sponsor?->ein_number_verified) {
            return to_route('sponsors.basic-settings.ein');
        }

        return view('sponsor.flow.shipping', [
            'sponsor' => auth()->user()->sponsor,
            'countries' => Country::select(['name', 'code_2'])->get(),
        ]);
    }

    /**
     * Save the shipping information to database.
     */
    public function saveAddress(AddressRequest $request, ShipEngineService $service)
    {
        try {
            // update the shipping information of sponsor
            $data = $request->validated();
            $data['shipping_address'] = $data['shipping_address'] ?? $data['address'];
            $data['shipping_postal_code'] = $data['shipping_postal_code'] ?? $data['postal_code'];
            $data['shipping_city'] = $data['shipping_city'] ?? $data['city'];
            $data['shipping_state'] = $data['shipping_state'] ?? $data['state'];
            $data['shipping_country'] = $data['shipping_country'] ?? $data['country'];
            $countryCode = "US";

            // $country = Country::whereLike(['name', 'code_2', 'code_3'], $data['shipping_country'])->get();

            // if ($country) {
            //     $countryCode = strtoupper($country->code_2);
            // }

            // validate shipping address using shipengine
            $result = $service->validateAddress([
                'address_line1' => $data['shipping_address'],
                'postal_code' => $data['shipping_postal_code'],
                'city_locality' => $data['shipping_city'],
                'state_province' => $data['shipping_state'],
                'country_code' => $countryCode,
            ]);

            // if address is valid, update sponsor's address
            if ($result) {
                $request->user()->sponsor->update($data);

                // saving user billing information to stripe
                $stripe = new \Stripe\StripeClient(config('services.stripe.client_secret'));

                $stripe->customers->update($request->user()->stripe_id, [
                    'address' => [
                        'line1' => $data['shipping_address'],
                        'postal_code' => $data['shipping_postal_code'],
                        'city' => $data['shipping_city'],
                        'state' => $data['shipping_state'],
                        'country' => $countryCode
                    ]
                ]);

                return to_route('sponsors.basic-settings.templates');
            } else {
                // address is not varified by shipengine
                return back()->with('error', 'We are sorry we are unable to verify your address. Please check your address and try again.');
            }

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
