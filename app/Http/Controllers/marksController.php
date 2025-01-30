<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentListClassA;
use App\Models\StudentListClassB;
use App\Models\StudentListClassC;
use App\Models\MidtermTestResultsClassA;
use App\Models\MidtermTestResultsClassB;
use App\Models\MidtermTestResultsClassC;
use App\Models\TerminalTestResultsClassA;
use App\Models\TerminalTestResultsClassB;
use App\Models\TerminalTestResultsClassC;


class marksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get class from request
        $examType = $request->route('examType');
        $class = $request->route('class');


        // Fetch students from the respective class table
        $students = match ($class) {
            'Class_A' => StudentListClassA::all(),
            'Class_B' => StudentListClassB::all(),
            'Class_C' => StudentListClassC::all(),
            default => collect(),
        };

        // Fetch marks from the respective results table  'Class A' => $examType === 'Midterm' ? 'midterm_test_results_class_a' : 'terminal_exam_results_class_a',
        $tableName = match ($class) {
            'Class_A' => $examType === 'Midterm' ? 'midterm_test_results_class_a' : 'terminal_exam_results_class_a',
            'Class_B' => $examType === 'Midterm' ? 'midterm_test_results_class_b' : 'terminal_exam_results_class_b',
            'Class_C' => $examType === 'Midterm' ? 'midterm_test_results_class_c' : 'terminal_exam_results_class_c',
            default => null,
        };

        //check if tablename exists
        if (!$tableName) {
            abort(404, 'Invalid Class or Exam Type');
        }

        //check if tablename exists
        if (!$tableName) {
            abort(404, 'Invalid Class or Exam Type');
        }

        // Map students and their marks if they exist
        $Marks = $students->map(function ($student) use ($tableName) {
            $existingMarks = \DB::table($tableName)
                ->where('student_number', $student->student_number)
                ->first();

            return [
                'student_number' => $student->student_number,
                'student_name' => $student->student_name,
                'subject1' => $existingMarks->subject_1 ?? null,
                'subject2' => $existingMarks->subject_2 ?? null,
                'subject3' => $existingMarks->subject_3 ?? null,
                'subject4' => $existingMarks->subject_4 ?? null,
                'subject5' => $existingMarks->subject_5 ?? null,
                'TotalMarks' => $existingMarks->total_marks ?? null,
                'averageMarks' => $existingMarks->average_marks ?? null,
                'position' => $existingMarks->student_position ?? null,

            ];
        });

        return view('marks.view', compact('examType', 'class', 'Marks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $examType = $request->route('examType');
        $class = $request->route('class');

        if (empty($class) || empty($examType)) {
            abort(404, 'Class and Exam Type must be defined.');
        }


        // Fetch students from the respective class table
        $students = match ($class) {
            'Class_A' => StudentListClassA::all(),
            'Class_B' => StudentListClassB::all(),
            'Class_C' => StudentListClassC::all(),
            default => collect(),
        };

        // Fetch marks from the respective results table
        $tableName = match ($class) {
            'Class_A' => $examType === 'Midterm' ? 'midterm_test_results_class_a' : 'terminal_exam_results_class_a',
            'Class_B' => $examType === 'Midterm' ? 'midterm_test_results_class_b' : 'terminal_exam_results_class_b',
            'Class_C' => $examType === 'Midterm' ? 'midterm_test_results_class_c' : 'terminal_exam_results_class_c',

            default => null,
        };
        //check table name
        if (!$tableName) {
            abort(404, 'Invalid Class or Exam Type');
        }

        // Map students and their marks if they exist
        $studentsWithMarks = $students->map(function ($student) use ($tableName) {
            $existingMarks = \DB::table($tableName)
                ->where('student_number', $student->student_number)
                ->first();

            return [
                'student_number' => $student->student_number,
                'student_name' => $student->student_name,
                'subject1' => $existingMarks->subject_1 ?? null,
                'subject2' => $existingMarks->subject_2 ?? null,
                'subject3' => $existingMarks->subject_3 ?? null,
                'subject4' => $existingMarks->subject_4 ?? null,
                'subject5' => $existingMarks->subject_5 ?? null,
                'TotalMarks' => $existingMarks->total_marks ?? null,
                'averageMarks' => $existingMarks->average_marks ?? null,
                'position' => $existingMarks->student_position ?? null,

            ];
        });

        return view('marks.upload', compact('examType', 'class', 'studentsWithMarks'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $class = $request->route('class');
    $examType = $request->route('examType');

    if (!$class || !$examType) {
        return back()->with('error', 'Class or Exam Type is missing.');
    }

    $request->validate([
        'students' => 'required|array',
        'students.*.student_number' => 'required|string',
        'students.*.student_name' => 'required|string',
        'students.*.subject1' => 'nullable|integer|min:0|max:100',
        'students.*.subject2' => 'nullable|integer|min:0|max:100',
        'students.*.subject3' => 'nullable|integer|min:0|max:100',
        'students.*.subject4' => 'nullable|integer|min:0|max:100',
        'students.*.subject5' => 'nullable|integer|min:0|max:100',
    ]);

    $examType = $request->route('examType'); // Get exam type from the route
    $class = $request->route('class'); // Get class name from the route


    $tableName = match ($class) {
        'Class_A' => $examType === 'Midterm' ? 'midterm_test_results_class_a' : 'terminal_exam_results_class_a',
        'Class_B' => $examType === 'Midterm' ? 'midterm_test_results_class_b' : 'terminal_exam_results_class_b',
        'Class_C' => $examType === 'Midterm' ? 'midterm_test_results_class_c' : 'terminal_exam_results_class_c',
        default => null,
    };

    // Ensure table name is valid
    if (!$tableName) {
        abort(404, 'Invalid Class or Exam Type');
    }


    $students = $request->input('students');

    foreach ($students as $studentData) {
        $totalMarks = $studentData['subject1'] + $studentData['subject2'] + $studentData['subject3'] + $studentData['subject4'] + $studentData['subject5'];
        $average = $totalMarks / 5;

        // Angalia kama mwanafunzi yupo kwenye database
        $existingStudent = \DB::table($tableName)
            ->where('student_number', $studentData['student_number'])
            ->first();

        if ($existingStudent) {
            // Kama yupo, update data zake
            \DB::table($tableName)->where('student_number', $studentData['student_number'])->update([
                'student_name' => $studentData['student_name'],
                'subject_1' => $studentData['subject1'],
                'subject_2' => $studentData['subject2'],
                'subject_3' => $studentData['subject3'],
                'subject_4' => $studentData['subject4'],
                'subject_5' => $studentData['subject5'],
                'total_marks' => $totalMarks,
                'average_marks' => $average,
                'updated_at' => now(),
            ]);
        } else {
            // Kama hayupo, weka rekodi mpya
            \DB::table($tableName)->insert([
                'student_number' => $studentData['student_number'],
                'student_name' => $studentData['student_name'],
                'subject_1' => $studentData['subject1'],
                'subject_2' => $studentData['subject2'],
                'subject_3' => $studentData['subject3'],
                'subject_4' => $studentData['subject4'],
                'subject_5' => $studentData['subject5'],
                'total_marks' => $totalMarks,
                'average_marks' => $average,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Sasisha nafasi (position) za wanafunzi kulingana na wastani wa alama (average_marks)
    $students = \DB::table($tableName)->orderBy('average_marks', 'desc')->get();
    $position = 1;

    foreach ($students as $student) {
        \DB::table($tableName)->where('id', $student->id)->update(['student_position' => $position++]);
    }
return redirect()->route('marks.create', [
    'class' => $class,
    'examType' => $examType,
])->with('success', 'Marks uploaded and updated successfully.');

    }





    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //

        $examType = $request->route('examType');
        $class = $request->route('class');


    // Validate class
    if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
        abort(404, 'Invalid Class');
    }

    // Validate exam type
    if (!in_array($examType, ['Midterm', 'Terminal'])) {
        abort(404, 'Invalid Exam Type');
    }

    // Determine the correct table name based on class and exam type
    $tableName = match ($class) {
        'Class_A' => $examType === 'Midterm' ? 'midterm_test_results_class_a' : 'terminal_exam_results_class_a',
        'Class_B' => $examType === 'Midterm' ? 'midterm_test_results_class_b' : 'terminal_exam_results_class_b',
        'Class_C' => $examType === 'Midterm' ? 'midterm_test_results_class_c' : 'terminal_exam_results_class_c',
        default => null,
    };

    if (!$tableName) {
        abort(404, 'Table not found');
    }

    // Fetch student marks for the selected class and exam type
    $marks = DB::table($tableName)
        ->select(
            'student_number',
            'student_name',
            'subject_1',
            'subject_2',
            'subject_3',
            'subject_4',
            'subject_5',
            DB::raw('(subject_1 + subject_2 + subject_3 + subject_4 + subject_5) as total'),
            DB::raw('ROUND((subject_1 + subject_2 + subject_3 + subject_4 + subject_5) / 5, 2) as average'),
            'student_position'
        )
        ->get();

    // Return the view with marks
    return view('marks.view', [
        'examType' => $examType,
        'class' => $class,
        'marks' => $marks,
    ]);
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

    // app/Http/Controllers/marksController.php
public function getStudentMarks($class, $student_number)
{
    // Validate class
    if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
        return response()->json(['error' => 'Invalid Class'], 404);
    }

    // Determine the correct table name based on class
    $tableName = match ($class) {
        'Class_A' => 'midterm_test_results_class_a',
        'Class_B' => 'midterm_test_results_class_b',
        'Class_C' => 'midterm_test_results_class_c',
        default => null,
    };

    if (!$tableName) {
        return response()->json(['error' => 'Invalid Class'], 404);
    }

    // Fetch student marks
    $marks = DB::table($tableName)
        ->where('student_number', $student_number)
        ->first();

    if (!$marks) {
        return response()->json(['error' => 'Student not found'], 404);
    }

    return response()->json([
        'student_number' => $marks->student_number,
        'student_name' => $marks->student_name,
        'subject_1' => $marks->subject_1,
        'subject_2' => $marks->subject_2,
        'subject_3' => $marks->subject_3,
        'subject_4' => $marks->subject_4,
        'subject_5' => $marks->subject_5,
        'total_marks' => $marks->total_marks,
        'average_marks' => $marks->average_marks,
        'position' => $marks->student_position,
    ]);
}
}
