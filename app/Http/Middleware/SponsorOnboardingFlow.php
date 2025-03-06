<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SponsorOnboardingFlow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if sponsor is not subscribed then redirect to choose pplan page
        if (!$request->user()->subscribed()) {
            return to_route('sponsors.plans.index');
        } elseif (!$request->user()->sponsor) {
            // if sponsor is not added basic settings then redirect to basic settings page
            return to_route('sponsors.basic-settings');
        } elseif ($request->user()->sponsor && !$request->user()->sponsor->ein_number_verified) {
            // if sponsor EIN number is not verified then redirect to verify
            return to_route('sponsors.basic-settings.ein');
        } elseif ($request->user()->sponsor && (is_null($request->user()->sponsor->address) || is_null($request->user()->sponsor->shipping_address))) {
            // if sponsor has not enter address details
            return to_route('sponsors.basic-settings.address');
        } elseif ($request->user()->templates->count() == 0) {
            // if sponsor has not templates selected yet, redirect him
            return to_route('sponsors.basic-settings.templates');
        }

        return $next($request);
    }
}
