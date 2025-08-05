<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check() && !Auth::guard('web')->user()->is_admin) {
            return $next($request);
        }

        return response('Forbidden', 403);
    }
}