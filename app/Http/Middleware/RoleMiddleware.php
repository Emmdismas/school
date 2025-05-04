<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Hakikisha kwamba $role ipo
        if (empty($role)) {
            return redirect('/login')->with('error', 'Role parameter is missing.');
        }

        // Hakikisha mtumiaji ame-login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in.');
        }

        // Pata role ya mtumiaji kutoka database
        $user = Auth::user();

        // Angalia kama role ya mtumiaji inalingana na role inayohitajika
        if ($user->role !== $role) {
            return redirect('/')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}