<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdSpaceOwnerOnboardingFlow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $adSpaceOwner = $request->user()->adSpaceOwner;

        if (!$adSpaceOwner) {
            // if ad space owner is not added basic settings then redirect to basic settings page
            return to_route('ad-space-owner.basic-settings.index');
        } elseif ($adSpaceOwner && is_null($adSpaceOwner->ein_number_verified_at)) {
            // if ad space owner EIN number is not verified then redirect to verify
            return to_route('ad-space-owner.basic-settings.ein.index');
        } elseif (is_null($user->stripe_id) || is_null($user->stripe_account_id) || !$user->completed_onboarding) {
            // if ad space owner has not connected with stripe using express connect account
            return to_route('ad-space-owner.basic-settings.onboarding.index');
        } elseif (!$request->user()->subscribed()) {
            // if ad space owner is not subscribed then redirect to choose plan page
            return to_route('ad-space-owner.basic-settings.plans.index');
        }

        return $next($request);
    }
}
