<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceReportController extends Controller
{
    // Display attendance summary table
    public function index(Request $request)
    {
           // Get class from request
           $class = $request->route('class');

        // Fetch attendance summary from database
        $summary = DB::table('attendance_table_class_a')
            ->select(
                'attendance_date',
                DB::raw('COUNT(*) as total_students'),
                DB::raw('SUM(CASE WHEN status = "Present" THEN 1 ELSE 0 END) as present'),
                DB::raw('SUM(CASE WHEN status = "Absent" THEN 1 ELSE 0 END) as absent'),
                DB::raw('SUM(CASE WHEN status = "Sick" THEN 1 ELSE 0 END) as sick'),
                DB::raw('SUM(CASE WHEN status = "Not Allowed" THEN 1 ELSE 0 END) as not_allowed')
            )
            ->groupBy('attendance_date')
            ->orderBy('attendance_date', 'desc')
            ->get();

        // Calculate percentage for each record
        foreach ($summary as $record) {
            $record->percentage = ($record->total_students > 0)
                ? round(($record->present / $record->total_students) * 100, 2)
                : 0;
        }

        return view('attendance.summary', compact('summary', 'class'));
    }

    // Display details for a specific date
    public function show($class, $date)
    {
        $attendanceDetails = DB::table('attendance_table_class_a')
            ->where('attendance_date', $date)
            ->select('student_number', 'student_name', 'status', 'total_classes_attended', 'total_percentage')
            ->get();

        return view('attendance.detail', [
            'class' => $class,
            'date' => $date,
            'attendanceDetails' => $attendanceDetails
        ]);
    }
}
