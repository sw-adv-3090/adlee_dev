<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Notifications\SendTwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (app()->environment() == 'production' && $request->user()->role_id !== UserRole::Admin->value) {
                $request->user()->generateTwoFactorCode();
                $request->user()->notify(new SendTwoFactorCode());
            }

            return redirect()->intended(route(route_name() . '.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
