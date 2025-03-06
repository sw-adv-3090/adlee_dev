<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Session\TokenMismatchException;


class HandleTokenMismatch extends ValidateCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        try {
            return parent::handle($request, $next);
        } catch (TokenMismatchException $exception) {
            return back()->withInput()->with('error', 'Your session has expired. Please try again.');
        }
    }
}
