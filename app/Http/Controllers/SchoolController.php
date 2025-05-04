<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemUser;
use App\Models\School;

class SchoolController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.schools');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_id' => 'required|integer|unique:schools,school_id',
            'region' => 'required|string',
            'district' => 'required|string',
            'school_type' => 'required|string',
            'school_fee'=> 'integer',
            'number_of_students' => 'integer',
            'number_of_teachers' => 'integer',
            
        ]);

          // Chukua grades kutoka kwenye request na zihifadhi kama JSON
    $grades = json_encode([
        "A" => ["from" => $request->grade_A_from, "to" => $request->grade_A_to],
        "B" => ["from" => $request->grade_B_from, "to" => $request->grade_B_to],
        "C" => ["from" => $request->grade_C_from, "to" => $request->grade_C_to],
        "D" => ["from" => $request->grade_D_from, "to" => $request->grade_D_to],
        "F" => ["from" => $request->grade_F_from, "to" => $request->grade_F_to],
    ]);

    if ($request->school_type === 'advance') {
        $grades = json_encode([
            "A" => ["from" => $request->grade_A_from, "to" => $request->grade_A_to],
            "B" => ["from" => $request->grade_B_from, "to" => $request->grade_B_to],
            "C" => ["from" => $request->grade_C_from, "to" => $request->grade_C_to],
            "D" => ["from" => $request->grade_D_from, "to" => $request->grade_D_to],
            "E" => ["from" => $request->grade_E_from, "to" => $request->grade_E_to],
            "S" => ["from" => $request->grade_S_from, "to" => $request->grade_S_to],
            "F" => ["from" => $request->grade_F_from, "to" => $request->grade_F_to],
        ]);
    }

        // Create the School
        School::create([
            'school_name' => $validated['school_name'],
            'school_id' => $validated['school_id'],
            'region' => $validated['region'],
            'district' => $validated['district'],
            'school_type' => $validated['school_type'],
            'grades' => $grades,
            'school_fee' => $validated['school_fee'],
            'number_of_students' => $validated['number_of_students'] ?? 0,
            'number_of_teachers' => $validated['number_of_teachers'] ?? 0,
        ]);
        



        // Redirect back with success message
        return redirect()->route('schools.create')->with('success', 'School registered successfully!');
    }
}
