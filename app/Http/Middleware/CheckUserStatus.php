<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is deactivated.');
        }

        return $next($request);
    }
}
