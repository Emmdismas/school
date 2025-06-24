<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\AttendanceRecord;
use App\Helpers\UserHelper;

class AttendanceController extends Controller
{


    public function summary($class)
    {
        $user = UserHelper::getLoggedInUser();


        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }


        // Chukua school_id ya mtumiaji aliyepo sasa
        $schoolId = $user->school_id;

        $summary = AttendanceRecord::selectRaw(
            'attendance_date,
            class,
            SUM(CASE WHEN status = "Present" THEN 1 ELSE 0 END) as present,
            SUM(CASE WHEN status = "Absent" THEN 1 ELSE 0 END) as absent,
            SUM(CASE WHEN status = "Sick" THEN 1 ELSE 0 END) as sick,
            SUM(CASE WHEN status = "Not Allowed" THEN 1 ELSE 0 END) as not_allowed,
            COUNT(*) as total_students'
        )
            ->where('school_id', $schoolId) // ✅ Filter kwa school_id
            ->groupBy('attendance_date')
            ->groupBy('class')
            ->orderBy('attendance_date', 'desc')
            ->get();

        foreach ($summary as $record) {
            $record->percentage = ($record->total_students > 0) ? ($record->present / $record->total_students) * 100 : 0;
        }

        return view('attendance.summary', compact('summary', 'class'));
    }


    public function details($class, $date)
    {

        // Orodha ya madarasa yanayokubalika
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

        // Angalia kama darasa lililotumwa ni sahihi
        if (!in_array($class, $validClasses)) {
            abort(400, 'Invalid class selection.');
        }


        // Chukua mtumiaji aliyeingia kupitia helper
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;

        $presentStudents = AttendanceRecord::where('attendance_date', $date)
            ->where('class', $class)
            ->where('status', 'Present')
            ->where('school_id', $schoolId)
            ->get();

        $absentStudents = AttendanceRecord::where('attendance_date', $date)
            ->where('class', $class)
            ->where('status', 'Absent')
            ->where('school_id', $schoolId)
            ->get();

        $sickStudents = AttendanceRecord::where('attendance_date', $date)
            ->where('class', $class)
            ->where('status', 'Sick')
            ->where('school_id', $schoolId)
            ->get();

        $notAllowedStudents = AttendanceRecord::where('attendance_date', $date)
            ->where('class', $class)
            ->where('status', 'Not Allowed')
            ->where('school_id', $schoolId)
            ->get();

        return view('attendance.details', compact(
            'date',
            'class',
            'presentStudents',
            'absentStudents',
            'sickStudents',
            'notAllowedStudents'
        ));
    }



    public function calculateAttendancePercentage($studentId, $class)
    {

        // Orodha ya madarasa yanayokubalika
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

        // Angalia kama darasa lililotumwa ni sahihi
        if (!in_array($class, $validClasses)) {
            abort(400, 'Invalid class selection.');
        }


        $user = UserHelper::getLoggedInUser();
         $schoolId = $user->school_id;

        // Hesabu jumla ya siku ambazo attendance ilifanyika
        $totalClasses = AttendanceRecord::where('school_id', $schoolId)
            ->distinct()
            ->count('attendance_date');

        // Hesabu idadi ya siku mwanafunzi alikuwa "Present"
        $totalClassesAttended = AttendanceRecord::where('school_id', $schoolId)
            ->where('student_id', $studentId)
            ->where('status', 'Present')
            ->count();

        // Epuka kugawanya kwa 0
        $attendancePercentage = ($totalClasses > 0) ? ($totalClassesAttended / $totalClasses) * 100 : 0;

        return $attendancePercentage;
    }


    public function index(Request $request, $class)
    {
        // Validate the class
        if (
            !in_array($class, [
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
            ])
        ) {
            abort(404, 'Invalid Class');
        }

        // Chukua mtumiaji aliyeingia kupitia helper
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;

        // Fetch students based on the class and school_id
        $students = Students::where('school_id', $schoolId)
            ->where('class', $class)
            ->get();

        // Count attendance status dynamically for the specific school
        $statusCounts = AttendanceRecord::where('school_id', $schoolId)
            ->where('class', $class)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        logger('Status Counts:', $statusCounts);

        // Fetch students for a specific status if requested
        $studentsForStatus = [];
        if ($request->has('status')) {
            $status = $request->query('status');
            $studentsForStatus = AttendanceRecord::where('school_id', $schoolId)
                ->where('class', $class)
                ->where('status', $status)
                ->get(['student_id', 'student_name']);
            logger('Students for Status:', $studentsForStatus->toArray());
        }

        // Fetch total attendance and percentages for each student dynamically
        foreach ($students as $student) {
            $attendanceData = AttendanceRecord::where('school_id', $schoolId)
                ->where('student_id', $student->student_id)
                ->selectRaw('SUM(CASE WHEN status = "Present" THEN 1 ELSE 0 END) as total_attended, COUNT(*) as total_classes')
                ->first();

            $student->total_classes_attended = $attendanceData->total_attended ?? 0;
            $student->total_percentage = ($attendanceData->total_classes > 0)
                ? ($attendanceData->total_attended / $attendanceData->total_classes) * 100
                : 0;
        }


        return view('attendance.upload', [
            'class' => $class,
            'students' => $students, // Pass student list to the view
            'statusCounts' => $statusCounts,
            'studentsForStatus' => $studentsForStatus,
            'currentStatus' => $request->query('status', null), // Current status filter
        ]);
    }


    public function store(Request $request, $class)
    {

        // Orodha ya madarasa yanayokubalika
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

        // Angalia kama darasa lililotumwa ni sahihi
        if (!in_array($class, $validClasses)) {
            abort(400, 'Invalid class selection.');
        }

        // Chukua mtumiaji aliyeingia kupitia helper
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;

        $date = $request->input('date'); // Pata tarehe kutoka kwenye form

        if (!$date) {
            return back()->with('error', 'Attendance date is required.');
        }


        $request->validate([
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*.status' => 'required|in:Present,Absent,Sick,Not Allowed',
        ]);

        $data = $request->all();
        foreach ($data['students'] as $studentId => $student) {
            $statusToday = $student['status'];

            $existingRecord = AttendanceRecord::where('student_id', $studentId)
                ->where('attendance_date', $data['date'])
                ->first();

            // Total unique attendance dates (isipokuwa siku ya leo kama haipo bado)
            $totalClasses = AttendanceRecord::where('school_id', $schoolId)
                ->where('student_id', $studentId)
                ->distinct()
                ->count('attendance_date');

            // Kama hakuna rekodi ya leo, ongeza 1
            if (!$existingRecord) {
                $totalClasses += 1;
            }

            // Count previous "Present" days
            $totalClassesAttended = AttendanceRecord::where('school_id', $schoolId)
                ->where('student_id', $studentId)
                ->where('status', 'Present')
                ->count();

            // Kama leo mwanafunzi yupo Present na hakuna rekodi, tuongeze 1
            if ($statusToday === 'Present' && !$existingRecord) {
                $totalClassesAttended += 1;
            }

            $percentage = ($totalClasses > 0) ? ($totalClassesAttended / $totalClasses) * 100 : 0;

            $studentName = Students::where('student_id', $studentId)->value('student_name');

            if ($existingRecord) {
                $existingRecord->update([
                    'status' => $statusToday,
                    'total_classes_attended' => $totalClassesAttended,
                    'total_classes' => $totalClasses,
                    'total_percentage' => $percentage,
                ]);
            } else {
                AttendanceRecord::create([
                    'school_id' => $schoolId,
                    'student_id' => $studentId,
                    'student_name' => $studentName,
                    'class' => $class,
                    'attendance_date' => $data['date'],
                    'status' => $statusToday,
                    'total_classes_attended' => $totalClassesAttended,
                    'total_classes' => $totalClasses,
                    'total_percentage' => $percentage,
                ]);
            }
        }

        // Tafuta idadi ya wanafunzi kwa kila status kwenye siku husika
        $counts = AttendanceRecord::where('school_id', $schoolId)
            ->where('class', $class)
            ->where('attendance_date', $date)
            ->selectRaw("
                    SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) as Present,
                    SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) as Absent,
                    SUM(CASE WHEN status = 'Sick' THEN 1 ELSE 0 END) as Sick,
                    SUM(CASE WHEN status = 'Not Allowed' THEN 1 ELSE 0 END) as `Not Allowed`
                ")
            ->first();

        // Tumia {} kwa keys zenye nafasi ili kuepuka error
        $statusCounts = [
            'Present' => $counts->Present ?? 0,
            'Absent' => $counts->Absent ?? 0,
            'Sick' => $counts->Sick ?? 0,
            'Not Allowed' => $counts->{'Not Allowed'} ?? 0, // **Muhimu**
        ];

        return back()->with([
            'success' => 'Attendance recorded successfully!',
            'statusCounts' => $statusCounts,
            'date' => $date
        ]);

    }

    public function getStudentAttendance($class, $student_id)
    {
        // Validate class input
        if (
            !in_array($class, [
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
            ])
        ) {
            return back()->with('error', 'Invalid class selected.');
        }

        // Fetch attendance data for the student
        $attendanceData = AttendanceRecord::where('student_id', $student_id)
            ->where('class', $class)
            ->select('attendance_date', 'status')
            ->get();


        // Calculate total attendance and percentage
        $totalClasses = AttendanceRecord::where('class', $class)
            ->distinct()
            ->count('attendance_date');


        $totalAttended = AttendanceRecord::where('student_id', $student_id)
            ->where('class', $class)
            ->where('status', 'Present')
            ->count();


        $percentage = ($totalClasses > 0) ? ($totalAttended / $totalClasses) * 100 : 0;

        // Return the view with data
        return view('attendance.upload', compact('class', 'student_id', 'attendanceData', 'totalClasses', 'totalAttended', 'percentage'));
    }




}