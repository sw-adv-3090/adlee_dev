<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // if sponsor has not enter address details
        if (!$request->user()->sponsor || (is_null($request->user()->sponsor?->address) || is_null($request->user()->sponsor?->shipping_address))) {
            return to_route('sponsors.basic-settings.address');
        }

        return view('sponsor.flow.template');
    }
}
