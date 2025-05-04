<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Hash;

class TeachersLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string'
        ]);

        // Tafuta user kwa kutumia name
        $user = Teachers::where('name', $credentials['name'])->first();

        // Hakikisha user anapatikana na password ni sahihi
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Log in the user
            Auth::login($user);

            // Regenerate session
            $request->session()->regenerate();

            // Store school_id in session
            session(['school_id' => $user->school_id]);

            // Redirect to dashboard
            return redirect()->intended('/dashboard')->with('success', 'Login successful!');
        }

        // Ikiwa username au password ni mbaya
        return back()->withErrors(['name' => 'Invalid credentials'])->withInput()->with('alert', 'Username or Password is incorrect!');
    }
}