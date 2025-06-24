<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\NotificationLog;

class NotificationController extends Controller
{
    //
    public function status(Request $request)
{
    $class = $request->input('class');
    $examType = $request->input('exam_type');
    $month = $request->input('month');
    $academicYear = $request->input('academic_year');

    // Pata wanafunzi wote wa darasa husika
    $students = Students::where('class', $class)->get();

    $data = $students->map(function ($student) use ($examType, $month, $academicYear) {
        $notified = NotificationLog::where([
            'student_id' => $student->id,
            'exam_type' => $examType,
            'month' => $month,
            'academic_year' => $academicYear,
        ])->exists();

        return [
            'student_name' => $student->first_name . ' ' . $student->last_name,
            'parent_phone' => $student->parent_phone,
            'notified' => $notified,
        ];
    });

    return view('notifications.status', ['students' => $data]);
}

}
