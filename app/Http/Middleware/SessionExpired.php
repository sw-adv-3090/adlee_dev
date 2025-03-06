<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()) {
            Log::info('Session expired for user: ' . Auth::id());

            Auth::logout();
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }

        return $next($request);
    }
}

