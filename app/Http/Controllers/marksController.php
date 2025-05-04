<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\ExamResult;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class MarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $examType = $request->route('examType');
    $class = $request->route('class');

    if (empty($class) || empty($examType)) {
        abort(404, 'Class and Exam Type must be defined.');
    }

    $school_id = auth()->user()->school_id;

    // Fetch students from Students model
    $students = Students::where('class', $class)
        ->where('school_id', $school_id)
        ->get();

    // Fetch student marks from the new ExamResult model
    $marks = $students->map(function ($student) use ($examType, $class, $school_id) {
        $existingMarks = ExamResult::where('student_id', $student->student_id)
            ->where('exam_type', $examType)
            ->where('class', $class)
            ->where('school_id', $school_id)
            ->first();

        return [
            'student_id' => $student->student_id,
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

    return view('marks.view', compact('examType', 'class', 'marks'));
}



public function create(Request $request)
{
    $class = $request->route('class');  // Inapatikana kwenye URL
    $examType = $request->input('examType');  // Inatarajiwa kutoka kwenye form input
    

    $school_id = auth()->user()->school_id;

    // Chagua mwezi na academic year kutoka request au session
    $selectedMonth = $request->query('month', session('selectedMonth', date('F')));
  
    $validYears = ['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'];
    $selectedYear = $request->query('academic_year', session('selectedYear', '2024/25'));

    if (!in_array($selectedYear, $validYears)) {
        $selectedYear = '2024/25'; // Default ikiwa mwaka si sahihi
    }
    session(['selectedYear' => $selectedYear]);

    // Fetch students from class table
    $students = Students::where('class', $class)
        ->where('school_id', $school_id)
        ->get();

    // Fetch student marks
    $studentsWithMarks = $students->map(function ($student) use ($selectedMonth, $selectedYear, $examType, $class, $school_id) {
        $existingMarks = ExamResult::where('student_id', $student->student_id)
            ->where('month', $selectedMonth)
            ->where('academic_year', $selectedYear)
            ->where('exam_type', $examType)
            ->where('class', $class)
            ->where('school_id', $school_id)
            ->first();
    
        // Pata marks za masomo yote
        $subject1 = $existingMarks->subject_1 ?? 0;
        $subject2 = $existingMarks->subject_2 ?? 0;
        $subject3 = $existingMarks->subject_3 ?? 0;
        $subject4 = $existingMarks->subject_4 ?? 0;
        $subject5 = $existingMarks->subject_5 ?? 0;
    
        // Jumlisha marks kupata TotalMarks
        $totalMarks = $subject1 + $subject2 + $subject3 + $subject4 + $subject5;
    
        return [
            'student_id' => $student->student_id,
            'student_name' => $student->student_name,
            'subject1' => $subject1,
            'subject2' => $subject2,
            'subject3' => $subject3,
            'subject4' => $subject4,
            'subject5' => $subject5,
            'TotalMarks' => $totalMarks, // Ongeza TotalMarks hapa
        ];
    });

    return view('marks.upload', compact('examType', 'class', 'studentsWithMarks', 'selectedMonth', 'selectedYear'));
}


    public function store(Request $request)
    {
        // Pata class na examType kutoka kwenye route
        $class = $request->route('class');
        $examType = $request->input('examType');
    
        // Hakikisha class na examType zipo
        if (!$class || !$examType) {
            return back()->with('error', 'Class or Exam Type is missing.');
        }
    
        // Pata school_id kutoka kwa mtumiaji aliyelogin
        $schoolId = auth()->user()->school_id;
    
        // Validate input data
        $validatedData = $request->validate([
            'month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'academic_year' => 'required|string|in:2024/25,2025/26,2026/27,2027/28,2028/29,2029/30',
            'students' => 'required|array',
            'students.*.student_id' => 'required|string',
            'students.*.student_name' => 'required|string',
            'students.*.subject1' => 'nullable|integer|min:0|max:100',
            'students.*.subject2' => 'nullable|integer|min:0|max:100',
            'students.*.subject3' => 'nullable|integer|min:0|max:100',
            'students.*.subject4' => 'nullable|integer|min:0|max:100',
            'students.*.subject5' => 'nullable|integer|min:0|max:100',
        ]);
    
        // Hifadhi alama za wanafunzi
        foreach ($request->input('students') as $studentData) {
            // Jumla ya alama na wastani
            $totalMarks = array_sum([
                $studentData['subject1'] ?? 0,
                $studentData['subject2'] ?? 0,
                $studentData['subject3'] ?? 0,
                $studentData['subject4'] ?? 0,
                $studentData['subject5'] ?? 0,
            ]);
            $average = round($totalMarks / 5, 2); // Round average to 2 decimal places
    
            // Hifadhi data kwenye table mpya
            ExamResult::updateOrCreate(
                [
                    'student_id' => $studentData['student_id'],
                    'school_id' => $schoolId,
                    'month' => $request->input('month'),
                    'academic_year' => $request->input('academic_year'),
                    'exam_type' => $examType, // Tumeongeza exam type
                    'class' => $class, // Hifadhi class kwa sasa
                ],
                [
                    'student_name' => $studentData['student_name'],
                    'subject_1' => $studentData['subject1'],
                    'subject_2' => $studentData['subject2'],
                    'subject_3' => $studentData['subject3'],
                    'subject_4' => $studentData['subject4'],
                    'subject_5' => $studentData['subject5'],
                    'total_marks' => $totalMarks,
                    'average_marks' => $average,
                ]
            );
        }
    
        // Panga nafasi za wanafunzi kulingana na school_id, class, examType, month, na academic_year
        $students = ExamResult::where('school_id', $schoolId)
            ->where('class', $class)
            ->where('exam_type', $examType)
            ->where('month', $request->input('month'))
            ->where('academic_year', $request->input('academic_year'))
            ->orderBy('average_marks', 'desc')
            ->pluck('id');
    
        // Pangilia nafasi kwa kutumia IDs zilizopangwa
        foreach ($students as $index => $studentId) {
            ExamResult::where('id', $studentId)->update(['student_position' => $index + 1]);
        }
    
        // Redirect na ujumbe wa mafanikio
        return redirect()->route('marks.show', [
            'class' => $class,
            'examType' => $examType,
        ])->with('success', 'Marks uploaded and updated successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
{
    $examType = $request->input('examType', 'Midterm'); // Default kuwa Midterm
    $class = $request->route('class'); // Class kutoka kwenye route
    $month = $request->input('month'); // Pata mwezi kutoka kwenye form
    $schoolId = auth()->user()->school_id; // Pata school_id ya mtumiaji aliyelogin

    // Validate class
    $validClasses = [
        'Standard_1', 'Standard_2', 'Standard_3', 'Standard_4', 
        'Standard_5', 'Standard_6', 'Standard_7',
        'Form_1', 'Form_2', 'Form_3', 'Form_4', 'Form_5', 'Form_6'
    ];

    // Angalia kama darasa lililotumwa ni sahihi
    if (!in_array($class, $validClasses)) {
        abort(400, 'Invalid class selection.');
    }

    // Validate exam type
    if (!in_array($examType, ['Mock', 'Terminal', 'Midterm', 'Test'])) {
        abort(404, 'Invalid Exam Type');
    }

    // Chagua mwaka wa masomo kutoka request au session
    $validYears = ['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'];
    $selectedYear = $request->query('academic_year', session('selectedYear', '2024/25'));

    if (!in_array($selectedYear, $validYears)) {
        $selectedYear = '2024/25'; // Default ikiwa mwaka si halali
    }

    session(['selectedYear' => $selectedYear]);

    // Query kwa kuchuja school_id, class, exam_type, mwezi na academic_year
    $query = ExamResult::where('school_id', $schoolId)
        ->where('class', $class)
        ->where('exam_type', $examType)
        ->where('academic_year', $selectedYear);

    if ($month) {
        $query->where('month', $month);
    }

    // Fetch student marks
    $marks = $query->select(
        'student_id',
        'student_name',
        'subject_1',
        'subject_2',
        'subject_3',
        'subject_4',
        'subject_5',
        'total_marks',
        'average_marks',
        'student_position'
    )->get();

    // Return view na marks zilizochujwa
    return view('marks.view', [
        'examType' => $examType,
        'class' => $class,
        'marks' => $marks,
        'selectedMonth' => $month,
        'selectedYear' => $selectedYear
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

    /**
     * Get student marks by class and student ID.
     */
    public function getStudentMarks($class, $student_id)
    {
        // Validate class
        if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
            return response()->json(['error' => 'Invalid Class'], 404);
        }

        // Determine the correct model based on class
        $model = match ($class) {
            'Class_A' => MidtermTestResultsClassA::class,
            'Class_B' => MidtermTestResultsClassB::class,
            'Class_C' => MidtermTestResultsClassC::class,
            default => null,
        };

        if (!$model) {
            return response()->json(['error' => 'Invalid Class'], 404);
        }

        // Fetch student marks
        $marks = $model::where('student_id', $student_id)->first();

        if (!$marks) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        return response()->json([
            'student_id' => $marks->student_id,
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