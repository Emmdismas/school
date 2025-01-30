<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Rudisha user kwa login au ukurasa wa error
        return redirect('/login')->withErrors(['unauthorized' => 'You do not have permission to access this page.']);
    }
}
