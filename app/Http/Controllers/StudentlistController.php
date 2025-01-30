<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentlistController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_number' => 'required|integer',
            'student_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required|string',
            'parent_name' => 'required|string|max:255',
            'parent_number' => 'required|integer',
            'parent_email' => 'required|email',
            'relationship' => 'required|string|max:100',
            'class' => 'required|string|in:A,B,C',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 2MB limit
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students', 'public');
        }

        // Dynamic table selection
        $table = 'student_list_class_' . strtolower($request->class);

        // Validation logic here

    // Handle storing the student in the correct class table
    if ($request->class == 'A') {
        // Save to Student_list_class_A table
    } elseif ($request->class == 'B') {
        // Save to Student_list_class_B table
    } elseif ($request->class == 'C') {
        // Save to Student_list_class_C table
    }

        // Insert into the selected table
        $insert = DB::table($table)->insert([
            'student_number' => $request->student_number,
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'parent_name' => $request->parent_name,
            'parent_number' => $request->parent_number,
            'parent_email' => $request->parent_email,
            'relationship' => $request->relationship,
            'photo_path' => $photoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($insert) {
            return redirect()->back()->with('success', 'Student Registered Successfully!');
        } else {
            return redirect()->back()->with('error', 'Registration Failed! Try Again.');
        }
        
}
public function create (){
    return view('student_registration.register');
}
}