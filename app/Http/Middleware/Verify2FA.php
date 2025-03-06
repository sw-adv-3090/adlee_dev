<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Verify2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment() == 'production') {
            $user = auth()->user();
            $is_admin = $user->role_id == UserRole::Admin->value;

            if (auth()->check() && $user->two_factor_code) {
                if (!$is_admin) {
                    if ($user->two_factor_expires_at->lt(now())) {
                        $user->resetTwoFactorCode();
                        auth()->logout();

                        return redirect()->route('login')
                            ->withMessage('The two factor code has expired. Please login again.');
                    }

                    if (!$request->is('verify*')) {
                        return redirect()->route('verify.index');
                    }
                }
            }
        }

        return $next($request);
    }
}
