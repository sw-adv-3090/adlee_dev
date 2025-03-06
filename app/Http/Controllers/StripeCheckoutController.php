<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeCheckoutController extends Controller
{
    /**
     * Handle the stripe success return.
     */
    public function success(Request $request)
    {
        dd('stripe success');
    }

    /**
     * Handle the stripe cancel return.
     */
    public function cancel(Request $request)
    {
        dd('stripe cancel');
    }
}
