<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Students;
use App\Models\School;
use App\Models\AttendanceRecord;
use App\Models\PaymentRecords;
use Intervention\Image\Facades\Image;
use App\Helpers\UserHelper;

class StudentController extends Controller
{
   public function index(Request $request)
{
    $user = UserHelper::getLoggedInUser();
    $schoolId = $user?->school_id;

    $class = $request->route('class');

    $validClasses = [
        'Standard_1', 'Standard_2', 'Standard_3', 'Standard_4', 'Standard_5', 'Standard_6', 'Standard_7',
        'Form_1', 'Form_2', 'Form_3', 'Form_4', 'Form_5', 'Form_6'
    ];

    if (!in_array($class, $validClasses)) {
        abort(404, 'Invalid class specified');
    }

    $students = Students::where('school_id', $schoolId)
        ->where('class', $class)
        ->orderBy('student_name')
        ->get();

    foreach ($students as $student) {
        $attendance = \DB::table('attendance_records')
            ->where('student_id', $student->student_id)
            ->where('school_id', $schoolId)
            ->value('total_percentage');

        $student->attendance = $attendance ?? 0;
    }

    return view('student.index', [
        'class' => $class,
        'students' => $students
    ]);
}

    public function create(Request $request)
{
    $user = UserHelper::getLoggedInUser();

    $school = School::where('school_id', $user?->school_id)->first();

    $schoolType = $school->school_type ?? '';

    return view('student_registration.register', [
        'schoolType' => $schoolType
    ]);
}

    public function store(Request $request)
    {
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

        $request->validate([
            'student_id' => 'required|integer',
            'student_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required|string',
            'parent_name' => 'required|string|max:255',
            'parent_number' => 'required|integer',
            'parent_email' => 'required|email',
            'relationship' => 'required|string|max:100',
            'class' => 'required|string|in:' . implode(',', $validClasses),
            'stream' => 'nullable|string|in:science,arts,business',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Validate stream for Form 3-6
        $class = $request->class;
        if (str_starts_with($class, 'Form_')) {
            $formNumber = (int) str_replace('Form_', '', $class);
            if ($formNumber >= 3 && empty($request->stream)) {
                return back()->withErrors(['stream' => 'Stream is required for Form 3 and above']);
            }
        }

$school_id = UserHelper::getLoggedInUserSchoolId();
        // Handle photo upload
        if ($request->hasFile('photo')) {
            try {
                $photo = $request->file('photo');
                $photoPath = $photo->getRealPath();
                $photoBinary = file_get_contents($photoPath);

                if ($photoBinary === false) {
                    throw new \Exception('Could not read photo file');
                }
            } catch (\Exception $e) {
                return back()->withErrors(['photo' => 'Photo processing failed: ' . $e->getMessage()]);
            }
        } else {
            return back()->withErrors(['photo' => 'Photo is required']);
        }

        // Check if student already exists
        $existingStudent = Students::where('student_id', $request->student_id)
            ->where('school_id', $school_id)
            ->where('class', $request->class)
            ->first();

        if ($existingStudent) {
            return redirect()->route('register.create')->with([
                'error' => 'This student is already registered. Do you want to modify the student data?',
                'student_id' => $request->student_id,
                'student_name' => $request->student_name,
            ]);
        }

        // Create new student record
        Students::create([
            'school_id' => $school_id,
            'student_id' => $request->student_id,
            'class' => $request->class,
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'parent_name' => $request->parent_name,
            'parent_number' => $request->parent_number,
            'parent_email' => $request->parent_email,
            'relationship' => $request->relationship,
            'stream' => $request->stream,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'photo' => $photoBinary,
            'year_of_study' => date('Y'),
            'status' => 'Active',
        ]);

        $message = "Habari {$request->parent_name}, mwanao {$request->student_name} amesajiliwa. Username: {$request->name}, Password: {$request->password}. Tafadhali hifadhi taarifa hizi kwa matumizi ya mfumo.";

// Tuma notification (SMS au WhatsApp)
Http::post(env('APP_URL') . '/api/notify/sms', [
    'phone' => $request->parent_number,
    'message' => $message
]);

        return redirect()->route('register.create')->with('success', 'Student Registered Successfully!');
    }



    public function edit($student_id)
    {
        // Tafuta mwanafunzi kwa student_id badala ya id
        $student = Students::where('student_id', $student_id)->first();

        if (!$student) {
            return redirect()->route('register.create')->with('error', 'Student not found.');
        }

        return view('student.edit', compact('student'));
    }


    public function update(Request $request, $student_id)
{
    $student = Students::where('student_id', $student_id)->first();

    if (!$student) {
        return redirect()->route('students.create')->with('error', 'Student not found.');
    }

    $request->validate([
        'student_name' => 'nullable|string|max:255',
        'blood_group' => 'nullable|string',
        'gender' => 'nullable|string',
        'date_of_birth' => 'nullable|date',
        'parent_name' => 'nullable|string|max:255',
        'parent_number' => 'nullable|numeric',
        'parent_email' => 'nullable|email',
        'relationship' => 'nullable|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Start with existing data
    $data = [
        'student_name' => $request->student_name ?: $student->student_name,
        'blood_group' => $request->blood_group ?: $student->blood_group,
        'gender' => $request->gender ?: $student->gender,
        'date_of_birth' => $request->date_of_birth ?: $student->date_of_birth,
        'parent_name' => $request->parent_name ?: $student->parent_name,
        'parent_number' => $request->parent_number ?: $student->parent_number,
        'parent_email' => $request->parent_email ?: $student->parent_email,
        'relationship' => $request->relationship ?: $student->relationship,
    ];

    // If new photo is uploaded, process and include it
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $image = Image::make($photo)->resize(300, 300);
        $data['photo'] = (string) $image->encode('jpeg');
    }

    $student->update($data);

    return redirect()->route('students.show', $student_id)->with('success', 'Student data updated successfully!');
}


    public function fullProfile($student_id, $school_id)
    {
        // Fetch the student based on student_id and school_id
        $student = Students::where('student_id', $student_id)
            ->where('school_id', $school_id)
            ->first();

        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Ensure student photo is available
        if ($student->photo) {
            $student->photo_path = base64_encode($student->photo); // Encoding photo as base64
        }

        // Fetch attendance and payment data as per your requirement
        $attendances = AttendanceRecord::where('student_id', $student_id)->where('school_id', $school_id)->get();
        $payments = PaymentRecords::where('student_id', $student_id)->where('school_id', $school_id)->get();

        return view('student.full_profile', compact('student', 'attendances', 'payments'));
    }


    public function show($student_id)
    {
        $student = Students::where('student_id', $student_id)->first();

        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Convert the binary photo data into a base64 string for displaying
        $student->photo_base64 = $student->photo ? base64_encode($student->photo) : null;


        return view('student.full_profile', compact('student'));
    }



    public function generatePDF($student_id)
    {
        $schoolId = Auth::user()->school_id;
        $student = Students::where('student_id', $student_id)->where('school_id', $schoolId)->firstOrFail();
        $pdf = Pdf::loadView('student.pdf', compact('student'));
        return $pdf->download('student_profile_' . $student->student_id . '.pdf');
    }


    /**
     * Function ya kubadili darasa
     */
    public function updateClassYear()
    {
        $currentYear = date('Y');

        // Pata wanafunzi wote ambao wanahitaji kubadilisha darasa
        $students = Students::where('graduated', false)
            ->where('year_of_study', '<', $currentYear)
            ->get();

        foreach ($students as $student) {
            // Angalia kama mwanafunzi anapaswa kuhitimu
            if (in_array($student->class, ['Standard 7', 'Form 4', 'Form 6'])) {
                $student->class = 'Graduated';
                $student->graduated = true; // Wamehitimu
                $student->graduation_year = $currentYear; // Hifadhi mwaka wa kuhitimu
                $student->status = 'Graduated'; // Update status
            } else {
                // Wanafunzi wanapanda darasa
                $student->class = $this->getNextClass($student->class);
                $student->status = 'Active'; // Wanafunzi waliopo bado wako active
            }

            // Update mwaka wa masomo
            $student->year_of_study = $currentYear;
            $student->save();
        }

        return redirect()->route('students.index')->with('success', 'Students promoted or graduated successfully.');
    }

    /**
     * Function ya kubadili darasa
     */
    private function getNextClass($currentClass)
    {
        $classes = [
            'Standard 1' => 'Standard 2',
            'Standard 2' => 'Standard 3',
            'Standard 3' => 'Standard 4',
            'Standard 4' => 'Standard 5',
            'Standard 5' => 'Standard 6',
            'Standard 6' => 'Standard 7',
            'Standard 7' => 'Graduated', // Wanafunzi wa Standard 7 wanahitimu
            'Form 1' => 'Form 2',
            'Form 2' => 'Form 3',
            'Form 3' => 'Form 4',
            'Form 4' => 'Graduated', // Wanafunzi wa Form 4 wanahitimu
            'Form 5' => 'Form 6',
            'Form 6' => 'Graduated', // Wanafunzi wa Form 6 wanahitimu
        ];

        return $classes[$currentClass] ?? $currentClass;
    }


}
