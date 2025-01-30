<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemUser;

class AdminRegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.registration');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'role' => 'required|in:admin,headmaster,teacher,student',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create the system user
        SystemUser::create([
            'school_name' => $validated['school_name'],
            'role' => $validated['role'],
            'name' => $validated['name'],
            'password' => bcrypt($validated['password']), // Encrypt password
        ]);

        // Redirect back with success message
        return redirect()->route('admin.create')->with('success', 'System User registered successfully!');
    }
}
