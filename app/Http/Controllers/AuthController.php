<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('loginn'); // Hakikisha una hii file resources/views/loginn.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return match ($user->role) {
                'admin' => redirect()->route('admin'),
                'headmaster' => redirect()->route('headmaster'),
                'teacher' => redirect()->route('teacher'),
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
