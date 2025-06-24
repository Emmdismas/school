<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\ExamResult;
use App\Models\SubjectMark;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use App\Helpers\UserHelper;
use App\Services\WhatsAppNotificationService;

class MarksController extends Controller
{
    // Hapa ni helper function ya kupata masomo dynamic kutoka kwa school data
    private function getSchoolSubjects($school, $class)
    {
        if (!$school || !is_object($school)) {
            throw new \Exception('School haijapatikana au sio object sahihi.');
        }

        $subjectsData = json_decode($school->subjects, true);

        if (!$subjectsData || !is_array($subjectsData)) {
            throw new \Exception('Hakuna subjects zilizopangwa kwa shule hii.');
        }

        $class = str_replace('_', ' ', $class);

        if (isset($subjectsData['combinations'])) {
            return collect($subjectsData['combinations'])
                ->flatMap(fn($group) => collect($group)->pluck('name'))
                ->toArray();
        }

        if (isset($subjectsData[$class])) {
            return array_keys(array_filter($subjectsData[$class]));
        }

        return [];
    }


    private function getTeacherSubjects($teacher, $class)
    {
        $subjectsData = json_decode($teacher->subjects, true);
        if (!$subjectsData || !is_array($subjectsData))
            return [];

        $class = str_replace('_', ' ', $class);

        if (!isset($subjectsData[$class]))
            return [];

        return array_keys(array_filter($subjectsData[$class]));
    }



    private function getGradeFromSchool($school, $mark)
    {
        if ($mark === null)
            return null;

        $grades = json_decode($school->grades, true); // JSON to array

        foreach ($grades as $grade => $range) {
            $from = (int) $range['from'];
            $to = (int) $range['to'];

            if ($mark >= $from && $mark <= $to) {
                return $grade;
            }
        }

        return null;
    }

    // Kuonyesha fomu ya kuupload marks
    public function create(Request $request)
    {
        $class = $request->route('class');
        $examType = $request->input('examType');

        // Pata shule kwa kutumia school_id
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $school_id = $user->school_id;

        // Mwezi na mwaka
        $selectedMonth = $request->query('month', session('selectedMonth', date('F')));
        $validYears = ['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'];
        $selectedYear = $request->query('academic_year', session('selectedYear', '2024/25'));

        if (!in_array($selectedYear, $validYears)) {
            $selectedYear = '2024/25';
        }

        session(['selectedYear' => $selectedYear]);

        $subjects = $this->getTeacherSubjects($user, $class);

        $students = Students::where('class', $class)
            ->where('school_id', $school_id)
            ->get();

        $studentsWithMarks = $students->map(function ($student) use ($selectedMonth, $selectedYear, $examType, $class, $school_id, $subjects) {
            $existingMarks = ExamResult::where('student_id', $student->id)
                ->where('month', $selectedMonth)
                ->where('academic_year', $selectedYear)
                ->where('exam_type', $examType)
                ->where('class', $class)
                ->where('school_id', $school_id)
                ->first();

            $marksData = [
                'student_id' => $student->id,
                'student_name' => $student->student_name,
            ];

            foreach ($subjects as $subjectName) {
                $key = str_replace(' ', '_', strtolower($subjectName));
                $marksData[$key] = $existingMarks ? ($existingMarks->{$key} ?? null) : null;
            }

            return $marksData;  // Return marksData here, NOT the view
        });

        // Sasa render view nje ya map function
        return view('marks.upload', [
            'examType' => $examType,
            'class' => $class,
            'studentsWithMarks' => $studentsWithMarks,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'subjects' => $subjects
        ]);
    }



    // Hifadhi marks kwa dynamic subjects
    public function store(Request $request)
    {
        $class = $request->route('class');
        $examType = $request->input('examType');

        if (!$class || !$examType) {
            return back()->with('error', 'Class or Exam Type is missing.');
        }

        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;
        $school = DB::table('schools')->where('school_id', $schoolId)->first();
        if (!$school) {
            return back()->with('error', 'School haikupatikana.');
        }

        $teacher = UserHelper::getLoggedInUser();
        $subjects = $this->getTeacherSubjects($teacher, $class);

        // Validate basic fields
        $validatedData = $request->validate([
            'month' => 'required|string|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'academic_year' => 'required|string|in:2024/25,2025/26,2026/27,2027/28,2028/29,2029/30',
            'students' => 'required|array',
            'students.*.student_id' => 'required|string',
            'students.*.student_name' => 'required|string',
        ]);


        foreach ($request->input('students') as $studentData) {
            $totalMarks = 0;
            $subjectMarks = [];

            foreach ($subjects as $subjectName) {

                $mark = $studentData['subjects'][$subjectName] ?? null;


                if ($mark !== null && (!is_numeric($mark) || $mark < 0 || $mark > 100)) {
                    return back()->withErrors(['students' => "Invalid marks for {$subjectName} for student {$studentData['student_name']}"]);
                }

                $subjectMarks[] = [
                    'subject' => $subjectName,
                    'mark' => $mark ?? 0,
                ];

                $totalMarks += $mark ?? 0;
            }

            $average = count($subjects) > 0 ? round($totalMarks / count($subjects), 2) : 0;

            // Save exam_results first
            $examResult = ExamResult::create([
                'student_id' => $studentData['student_id'],
                'student_name' => $studentData['student_name'],
                'school_id' => $schoolId,
                'class' => $class,
                'exam_type' => $examType,
                'month' => $request->input('month'),
                'academic_year' => $request->input('academic_year'),
                'total_marks' => $totalMarks,
                'average_marks' => $average,
            ]);

            // Save all subject marks linked to this result
            foreach ($subjectMarks as $markData) {
                SubjectMark::create([
                    'exam_result_id' => $examResult->id,
                    'subject_name' => $markData['subject'],
                    'mark' => $markData['mark'],
                ]);
            }
        }

        // Recalculate student positions based on average
        $students = ExamResult::where('school_id', $schoolId)
            ->where('class', $class)
            ->where('exam_type', $examType)
            ->where('month', $request->input('month'))
            ->where('academic_year', $request->input('academic_year'))
            ->orderByDesc('average_marks')
            ->get();

        foreach ($students as $index => $student) {
            $student->student_position = $index + 1;
            $student->save();
        }

        return redirect()->route('marks.show', [
            'class' => $class,
            'examType' => $examType,
        ])->with('success', 'Marks uploaded and updated successfully.');
    }

    public function edit(Request $request)
{
    $class = $request->route('class');
    $examType = $request->query('examType');
    $month = $request->query('month');
    $academicYear = $request->query('academic_year', '2024/25');

    if (!$examType || !$month || !$academicYear) {
    return redirect()->back()->with('error', 'Please select exam type, month and academic year to edit marks.');
}

    $user = UserHelper::getLoggedInUser();

    if (!$user || !$user->school_id) {
        abort(403, 'Unauthorized');
    }

    $schoolId = $user->school_id;

    $subjects = $this->getTeacherSubjects($user, $class);

    $students = Students::where('class', $class)
        ->where('school_id', $schoolId)
        ->get();

    $studentsWithMarks = $students->map(function ($student) use ($subjects, $class, $examType, $month, $academicYear, $schoolId) {
        $examResult = ExamResult::where([
            'student_id' => $student->id,
            'class' => $class,
            'exam_type' => $examType,
            'month' => $month,
            'academic_year' => $academicYear,
            'school_id' => $schoolId,
        ])->first();

        $marks = [];

        if ($examResult) {
            $subjectMarks = SubjectMark::where('exam_result_id', $examResult->id)->pluck('mark', 'subject_name');
            foreach ($subjects as $subject) {
                $marks[$subject] = $subjectMarks[$subject] ?? '';
            }
        } else {
            foreach ($subjects as $subject) {
                $marks[$subject] = '';
            }
        }

        return [
            'student_id' => $student->id,
            'student_name' => $student->student_name,
            'marks' => $marks,
        ];
    });

    return view('marks.edit', compact(
        'class',
        'examType',
        'month',
        'academicYear',
        'subjects',
        'studentsWithMarks'
    ));
}


   // In Controller


public function update(Request $request)
{
    $class = $request->route('class');
    $examType = $request->input('examType');
    $month = $request->input('month');
    $academicYear = $request->input('academic_year');

    if (!$examType || !$month || !$academicYear) {
        return redirect()->back()->with('error', 'Please select exam type, month and academic year to edit marks.');
    }

    $user = UserHelper::getLoggedInUser();
    if (!$user || !$user->school_id) {
        abort(403, 'Unauthorized');
    }

    $school = $user->school;
    if (!$school) {
        return redirect()->back()->with('error', 'School haijapatikana.');
    }

    // ✅ Pata masomo kutoka kwa shule kulingana na darasa
    try {
        $subjects = $this->getSchoolSubjects($school, $class);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }

    foreach ($request->input('students') as $studentData) {
        $total = 0;
        $marks = [];

        foreach ($subjects as $subject) {
            $mark = $studentData['subjects'][$subject] ?? 0;

            if (!is_numeric($mark) || $mark < 0 || $mark > 100) {
                return back()->withErrors(['error' => "Invalid mark for $subject in student {$studentData['student_name']}"]);
            }

            $marks[$subject] = $mark;
            $total += $mark;
        }

        $average = count($subjects) ? round($total / count($subjects), 2) : 0;

        $examResult = ExamResult::updateOrCreate(
            [
                'student_id' => $studentData['student_id'],
                'class' => $class,
                'exam_type' => $examType,
                'month' => $month,
                'academic_year' => $academicYear,
                'school_id' => $school->id,
            ],
            [
                'student_name' => $studentData['student_name'],
                'total_marks' => $total,
                'average_marks' => $average,
            ]
        );

        // Delete old marks and insert new
        SubjectMark::where('exam_result_id', $examResult->id)->delete();

        foreach ($marks as $subject => $mark) {
            SubjectMark::create([
                'exam_result_id' => $examResult->id,
                'subject_name' => $subject,
                'mark' => $mark,
            ]);
        }
    }

    // Recalculate positions
    $all = ExamResult::where([
        'class' => $class,
        'exam_type' => $examType,
        'month' => $month,
        'academic_year' => $academicYear,
        'school_id' => $school->id,
    ])->orderByDesc('average_marks')->get();

    foreach ($all as $i => $record) {
        $record->student_position = $i + 1;
        $record->save();
    }

    // Send WhatsApp notifications
    $notificationService = new WhatsAppNotificationService();
    foreach ($request->input('students') as $studentData) {
        $notificationService->sendNotification(
            $studentData['student_id'],
            $examType,
            $month,
            $academicYear,
            $class
        );
    }

    return redirect()->route('marks.show', ['class' => $class, 'examType' => $examType])
        ->with('success', 'Marks updated successfully.');
}

private function saveStudentMarks($studentData, $subjects, $class, $examType, $month, $academicYear, $schoolId)
{
    $total = 0;
    $marks = [];

    foreach ($subjects as $subject) {
        $mark = $studentData['subjects'][$subject] ?? 0;

        if (!is_numeric($mark) || $mark < 0 || $mark > 100) {
            throw new \Exception("Invalid mark for $subject in student {$studentData['student_name']}");
        }

        $marks[$subject] = $mark;
        $total += $mark;
    }

    $average = count($subjects) ? round($total / count($subjects), 2) : 0;

    $examResult = ExamResult::updateOrCreate(
        [
            'student_id' => $studentData['student_id'],
            'class' => $class,
            'exam_type' => $examType,
            'month' => $month,
            'academic_year' => $academicYear,
            'school_id' => $schoolId,
        ],
        [
            'student_name' => $studentData['student_name'],
            'total_marks' => $total,
            'average_marks' => $average,
        ]
    );

    SubjectMark::where('exam_result_id', $examResult->id)->delete();

    foreach ($marks as $subject => $mark) {
        SubjectMark::create([
            'exam_result_id' => $examResult->id,
            'subject_name' => $subject,
            'mark' => $mark,
        ]);
    }
}

private function recalculatePositions($class, $examType, $month, $academicYear, $schoolId)
{
    $all = ExamResult::where([
        'class' => $class,
        'exam_type' => $examType,
        'month' => $month,
        'academic_year' => $academicYear,
        'school_id' => $schoolId,
    ])->orderByDesc('average_marks')->get();

    foreach ($all as $i => $record) {
        $record->student_position = $i + 1;
        $record->save();
    }
}


    // Tazama marks za wanafunzi
    public function show(Request $request)
    {
        $examType = $request->input('examType', 'Midterm'); // Default kuwa Midterm
        $class = $request->route('class'); // Class kutoka kwenye route
        $month = $request->input('month'); // Pata mwezi kutoka kwenye form
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;


        $school = DB::table('schools')->where('school_id', $schoolId)->first();

        if (!$school) {
            throw new \Exception('School haikupatikana kwa ID: ' . $schoolId);
        }

        // Validate class
        $validClasses = [
            'Standard_1',
            'Standard_2',
            'Standard_3',
            'Standard_4',
            'Standard_5',
            'Standard_6',
            'Standard_7',
            'Form_1',
            'Form_2',
            'Form_3',
            'Form_4',
            'Form_5',
            'Form_6'
        ];

        if (!in_array($class, $validClasses)) {
            abort(400, 'Invalid class selection.');
        }

        // Validate exam type
        if (!in_array($examType, ['Mock', 'Terminal', 'Midterm', 'Test'])) {
            abort(404, 'Invalid Exam Type');
        }

        // Academic Year
        $validYears = ['2024/25', '2025/26', '2026/27', '2027/28', '2028/29', '2029/30'];
        $selectedYear = $request->query('academic_year', session('selectedYear', '2024/25'));
        if (!in_array($selectedYear, $validYears)) {
            $selectedYear = '2024/25';
        }
        session(['selectedYear' => $selectedYear]);

        // Month
        $month = $request->input('month');

        // Get subjects dynamically
        try {
            $subjects = $this->getSchoolSubjects($school, $class);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $subjectColumns = array_map(function ($subject) {
            return str_replace(' ', '_', strtolower($subject));
        }, $subjects);

        $columns = array_merge([
            'student_id',
            'student_name',
            'total_marks',
            'average_marks',
            'student_position'
        ], $subjectColumns);

        // Fetch marks
        $query = ExamResult::where('school_id', $schoolId)
            ->where('class', $class)
            ->where('exam_type', $examType)
            ->where('academic_year', $selectedYear);

        if ($month) {
            $query->where('month', $month);
        }

        $marks = $query->with('subjectMarks')->get();


        return view('marks.view', [
            'examType' => $examType,
            'class' => $class,
            'marks' => $marks,
            'subjects' => $subjects,
            'selectedMonth' => $month,
            'selectedYear' => $selectedYear,
            'school' => $school,
        ]);
    }

    

}