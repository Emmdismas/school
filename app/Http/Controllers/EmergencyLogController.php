<?php

// app/Http/Controllers/EmergencyLogController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyLog;

class EmergencyLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string',
            'narrative' => 'required|string',
            'timestamp' => 'required|date',
        ]);

        EmergencyLog::create([
            'student_name' => $request->student_name,
            'narrative' => $request->narrative,
            'timestamp' => $request->timestamp,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Log saved']);
    }
}
