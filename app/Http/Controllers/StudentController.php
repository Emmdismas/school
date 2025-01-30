<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentListClassA;
use App\Models\StudentListClassB;
use App\Models\StudentListClassC;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
           // Method to display the list of students
    public function index()
    {
        $class = $request->route('class'); // Get class from request

        if (!in_array($class, ['Class A', 'Class B', 'Class C'])) {
            abort(404);
        }

        $students = match ($class) {
            'Class A' => StudentListClassA::all(),
            'Class B' => StudentListClassB::all(),
            'Class C' => StudentListClassC::all(),
            default => collect(),
        };

        $students = Student::all();

        return view('student.index', compact('class', 'students')); // Send students and class to the view

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $class = $request->route('class'); // Get class from request

        if (!in_array($class, ['Class A', 'Class B', 'Class C'])) {
            abort(404);
        }

        $students = match ($class) {
            'Class A' => StudentListClassA::all(),
            'Class B' => StudentListClassB::all(),
            'Class C' => StudentListClassC::all(),
            default => collect(),
        };

        return view('student.index', compact('class', 'students')); // Send students and class to the view
    }


    /**
     * Store a newly created resource in storage.
     */
         // Method to handle the form submission and add a new student
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // app/Http/Controllers/StudentController.php
public function getFullReport($class, $student_number)
{
    // Validate class
    if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
        return response()->json(['error' => 'Invalid Class'], 404);
    }

    // Fetch student details
    $student = match ($class) {
        'Class_A' => StudentListClassA::where('student_number', $student_number)->first(),
        'Class_B' => StudentListClassB::where('student_number', $student_number)->first(),
        'Class_C' => StudentListClassC::where('student_number', $student_number)->first(),
        default => null,
    };

    if (!$student) {
        return response()->json(['error' => 'Student not found'], 404);
    }

    // Fetch student marks
    $marksTable = match ($class) {
        'Class_A' => 'midterm_test_results_class_a',
        'Class_B' => 'midterm_test_results_class_b',
        'Class_C' => 'midterm_test_results_class_c',
        default => null,
    };

    $marks = DB::table($marksTable)
        ->where('student_number', $student_number)
        ->first();

    // Fetch student payments
    $paymentsTable = match ($class) {
        'Class_A' => 'payment_record_class_a',
        'Class_B' => 'payment_record_class_b',
        'Class_C' => 'payment_record_class_c',
        default => null,
    };

    $payments = DB::table($paymentsTable)
        ->where('student_number', $student_number)
        ->get();

    // Prepare full report
    $fullReport = [
        'student_details' => [
            'student_number' => $student->student_number,
            'student_name' => $student->student_name,
            'gender' => $student->gender,
            'date_of_birth' => $student->date_of_birth,
            'blood_group' => $student->blood_group,
            'parent_name' => $student->parent_name,
            'parent_number' => $student->parent_number,
            'parent_email' => $student->parent_email,
            'relationship' => $student->relationship,
            'photo_path' => $student->photo_path,
        ],
        'marks' => $marks ? [
            'subject_1' => $marks->subject_1,
            'subject_2' => $marks->subject_2,
            'subject_3' => $marks->subject_3,
            'subject_4' => $marks->subject_4,
            'subject_5' => $marks->subject_5,
            'total_marks' => $marks->total_marks,
            'average_marks' => $marks->average_marks,
            'position' => $marks->student_position,
        ] : null,
        'payments' => $payments->map(function ($payment) {
            return [
                'payment_type' => $payment->payment_type,
                'amount' => $payment->amount,
                'receipt_content' => $payment->receipt_content,
            ];
        }),
    ];

    return response()->json($fullReport);
}
}
