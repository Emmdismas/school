<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Hakikisha una hii file resources/views/login.blade.php
    }

   public function login(Request $request)
{
    $credentials = $request->only('name', 'password');

    // Jaribu system_users (default)
    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::guard('web')->user();
        return match ($user->role) {
            'admin' => redirect()->route('admin'),
            'headmaster' => redirect()->route('headmaster'),
            default => redirect()->route('login')->with('error', 'Invalid role'),
        };
    }
    if (Auth::guard('accountant')->attempt($credentials)) {
        $user = Auth::guard('accountant')->user();
       return match ($user->role) {
            'accountant' => view('accountant.dashboard'),
            default => redirect()->route('login')->with('error', 'Invalid role'),
        };
    }

   if (Auth::guard('teacher')->attempt($credentials)) {
    $user = Auth::guard('teacher')->user();
    return match ($user->role) {
        'teacher' => view('teacher.dashboard'), // moja kwa moja kwenye view
        default => redirect()->route('login')->with('error', 'Invalid role'),
    };

}

    return redirect()->route('login')->with('error', 'Invalid credentials');
}

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
