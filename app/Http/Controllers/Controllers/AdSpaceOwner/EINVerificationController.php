<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdSpaceOwner\EINRequest;
use App\Services\TinCorrectService;
use Illuminate\Http\Request;

class EINVerificationController extends Controller
{
    private $user, $adSpaceOwner;

    /**
     * Initializes the controller constructor
     */
    public function __construct()
    {
        $this->user = request()->user();
        $this->adSpaceOwner = request()->user()->adSpaceOwner;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ad-space-owner.basic-settings.ein', [
            'adSpaceOwner' => $this->adSpaceOwner,
            'nextTryAt' => $this->adSpaceOwner->ein_number_verify_last_try?->addHours(24),
            'canVerify' => $this->adSpaceOwner->ein_number_verify_tries != 3,
            'companyName' => $this->adSpaceOwner->company_name,
            'einNumber' => $this->adSpaceOwner->ein_number,
        ]);
    }

    /**
     * verify a newly created resource in storage.
     */
    public function verify(EINRequest $request, TinCorrectService $service)
    {
        $response = $service->validateTin($request->ein_number, $request->company_name);

        // successfully varified
        if ($response['success']) {
            $this->adSpaceOwner->company_name = $request->company_name;
            $this->adSpaceOwner->ein_number = $request->ein_number;
            $this->adSpaceOwner->ein_number_verified_at = now();
            $this->adSpaceOwner->save();

            return to_route('ad-space-owner.basic-settings.onboarding.index')->with('status', 'Successfully verified EIN number.');
        } else {
            // unverfied
            $this->adSpaceOwner->ein_number_verify_tries += 1;
            $this->adSpaceOwner->ein_number_verify_last_try = now();
            $this->adSpaceOwner->save();

            return back()->with('error', $response['message'])->withInput();
        }
    }


}
