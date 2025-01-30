<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentListClassA;
use App\Models\StudentListClassB;
use App\Models\StudentListClassC;
use App\Models\AttendanceTableClassA;
use App\Models\AttendanceTableClassB;
use App\Models\AttendanceTableClassC;

class AttendanceController extends Controller
{
    private function getModel($class)
    {
        $models = [
            'Class_A' => [
                'students' => StudentListClassA::class,
                'attendance' => AttendanceTableClassA::class,
            ],
            'Class_B' => [
                'students' => StudentListClassB::class,
                'attendance' => AttendanceTableClassB::class,
            ],
            'Class_C' => [
                'students' => StudentListClassC::class,
                'attendance' => AttendanceTableClassC::class,
            ],
        ];

        if (isset($models[$class])) {
            return $models[$class];
        }

        throw new \Exception("Invalid class: $class");
    }

    public function index(Request $request, $class)
    {
        // Validate the class
        if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
            abort(404, 'Invalid Class');
        }

        // Fetch the appropriate models for the class
        $models = $this->getModel($class);
        $studentModel = $models['students'];
        $attendanceModel = $models['attendance'];

        // Fetch students based on the class
        $students = $studentModel::all();

        // Count attendance status dynamically
        $statusCounts = $attendanceModel::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Fetch students for a specific status if requested
        $studentsForStatus = [];
        if ($request->has('status')) {
            $status = $request->query('status');
            $studentsForStatus = $attendanceModel::where('status', $status)
                ->get(['student_number', 'student_name']);
        }

        // Fetch total attendance and percentages for each student dynamically
        foreach ($students as $student) {
            $attendanceData = $attendanceModel::where('student_number', $student->student_number)
                ->selectRaw('SUM(CASE WHEN status = "Present" THEN 1 ELSE 0 END) as total_attended, COUNT(*) as total_classes')
                ->first();

            $student->total_classes_attended = $attendanceData->total_attended ?? 0;
            $student->total_percentage = ($attendanceData->total_classes > 0)
                ? ($attendanceData->total_attended / $attendanceData->total_classes) * 100
                : 0;
        }

        return view('attendance.index', [
            'class' => $class,
            'students' => $students, // Pass student list to the view
            'statusCounts' => $statusCounts,
            'studentsForStatus' => $studentsForStatus,
            'currentStatus' => $request->query('status', null), // Current status filter
        ]);
    }

    public function store(Request $request, $class)
    {
        // Fetch the appropriate models for the class
        $models = $this->getModel($class);
        $attendanceModel = $models['attendance'];

        // Validate the request
        $request->validate([
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.number' => 'required|string',
            'students.*.status' => 'required|in:Present,Absent,Sick,Not Allowed',
        ]);

        $data = $request->all();
        $totalClasses = $attendanceModel::distinct()->count('attendance_date') + 1;

        foreach ($data['students'] as $student) {
            $existingRecord = $attendanceModel::where('student_number', $student['number'])
                ->where('attendance_date', $data['date'])
                ->first();

            $totalClassesAttended = $attendanceModel::where('student_number', $student['number'])
                ->where('status', 'Present')
                ->count();

            if ($student['status'] == 'Present' && !$existingRecord) {
                $totalClassesAttended += 1;
            }

            $percentage = ($totalClasses > 0)
                ? ($totalClassesAttended / $totalClasses) * 100
                : 0;

            if ($existingRecord) {
                $existingRecord->update([
                    'status' => $student['status'],
                    'total_classes_attended' => $totalClassesAttended,
                    'total_classes' => $totalClasses,
                    'total_percentage' => $percentage,
                ]);
            } else {
                $attendanceModel::create([
                    'student_number' => $student['number'],
                    'attendance_date' => $data['date'],
                    'status' => $student['status'],
                    'total_classes_attended' => $totalClassesAttended,
                    'total_classes' => $totalClasses,
                    'total_percentage' => $percentage,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!');
    }


    // app/Http/Controllers/AttendanceController.php
public function getStudentAttendance($class, $student_number)
{
    // Validate the class
    if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
        return response()->json(['error' => 'Invalid Class'], 404);
    }

    // Fetch the appropriate models for the class
    $models = $this->getModel($class);
    $attendanceModel = $models['attendance'];

    // Fetch attendance data for the student
    $attendanceData = $attendanceModel::where('student_number', $student_number)
        ->select('attendance_date', 'status')
        ->get();

    // Calculate total attendance and percentage
    $totalClasses = $attendanceModel::distinct()->count('attendance_date');
    $totalAttended = $attendanceModel::where('student_number', $student_number)
        ->where('status', 'Present')
        ->count();
    $percentage = ($totalClasses > 0) ? ($totalAttended / $totalClasses) * 100 : 0;

    return response()->json([
        'student_number' => $student_number,
        'attendance' => $attendanceData,
        'total_classes' => $totalClasses,
        'total_attended' => $totalAttended,
        'percentage' => $percentage,
    ]);
}
}
