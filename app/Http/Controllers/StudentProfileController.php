<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studentprofile;

class StudentProfileController extends Controller
{
    // Function ya kuonyesha student list dynamically kwa class zote
    public function index(Request $request)
    {
        $class = $request->query('class');
        $students = $class ? Students::where('class', $class)->get() : collect([]);

        return view('student.list', compact('students', 'class'));
    }

    // Function ya kuonyesha full profile ya mwanafunzi
    public function showProfile($class, $student_id)
    {
        // Tafuta mwanafunzi kwa student_id na class husika
        $student = Students::with(['examResults', 'attendance', 'payment', 'homework'])
                          ->where('student_id', $student_id)
                          ->where('class', $class)
                          ->firstOrFail();

        // Encode picha ikiwa ni base64
        if ($student->photo) {
            $student->photo = base64_encode($student->photo);
        }

        return view('student.profile', compact('student', 'class'));
    }
}
