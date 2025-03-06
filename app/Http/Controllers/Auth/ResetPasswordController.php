<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendTwoFactorCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $password_reset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$password_reset) {
            return back()->with('error', __('No password reset request found against your email address.'));
        }

        // check token is valid
        if (!Hash::check($request->token, $password_reset->token)) {
            return back()->with('error', __('Token does not match.'));
        }

        // token is 1 hours older, mean token expired
        if (Carbon::parse($password_reset->created_at)->addHour()->lt(now())) {
            return back()->with('error', __('Token expired.'));
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', __('User not found.'));
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        Auth::login(($user));

        // if ($user->role_id != UserRole::Admin->value) {
        //     $user->generateTwoFactorCode();
        //     $user->notify(new SendTwoFactorCode());
        // }


        return redirect()->intended(route(route_name($user->role_id) . '.dashboard'));

    }
}
