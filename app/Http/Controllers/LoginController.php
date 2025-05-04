<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemUser;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Hakikisha view hii ipo: resources/views/login.blade.php
    }

    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Jaribu kuingia na ku-authenticate user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Pata user aliyelogin
            $user = Auth::user();

            if ($user->school_id) {
                session(['school_id' => $user->school_id]); // Tumia helper function ya session
                logger('School ID set in session successfully: ' . session('school_id'));
            } else {
                logger('Failed to set School ID: User has no school_id');
            }

            // Redirect user kulingana na role
            return $this->redirectBasedOnRole($user->role);
        }

        // Ikiwa authentication itashindwa
        return back()
            ->withErrors(['name' => 'Invalid credentials'])
            ->withInput()
            ->with('alert', 'Username or Password is incorrect!');
    }

    protected function redirectBasedOnRole($role)
    {
        // Redirect users based on their role
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'headmaster' => redirect()->route('headmaster.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            default => redirect()->route('dashboard')->with('error', 'Invalid role'),
        };
    }

    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect()->route('login');
    }
}