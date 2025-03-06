<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\SendTwoFactorCode;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function redirectToGoogle(Request $request)
    {
        $type = 'sponsor';
        if (request()->has('type') && request()->type === 'ad-space-owner') {
            $type = 'ad-space-owner';
        }
        $request->session()->put('type', $type);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                return redirect()->intended(route(route_name($finduser->role_id) . '.dashboard'));

            } else {
                $type = $request->session()->get('type');
                $role_id = \App\Enums\UserRole::Sponsor->value;
                if ($type && $type === 'ad-space-owner') {
                    $role_id = \App\Enums\UserRole::AdSpaceOwner->value;
                }

                $clickId = $request->session()->get('clickId');
                $request->session()->forget('clickId');

                $newUser = User::updateOrCreate(['email' => $user->getEmail()], [
                    'role_id' => $role_id,
                    'name' => $user->getName(),
                    'google_id' => $user->getId(),
                    'password' => encrypt('password'),
                    'profile_photo_url' => $user->getAvatar(),
                    'tapfiliate_id' => $clickId
                ]);

                $newUser->markEmailAsVerified();

                Auth::login($newUser);

                $newUser->generateTwoFactorCode();
                $newUser->notify(new SendTwoFactorCode());

                return redirect()->intended(route(route_name($role_id) . '.dashboard'));
            }

        } catch (Exception $e) {
            return to_route('login')->with('error', $e->getMessage());
        }
    }
}
