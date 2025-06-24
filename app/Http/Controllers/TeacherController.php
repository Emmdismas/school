<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    // Fetch school subjects and classes depending on school type
    protected function getSchoolClassesAndSubjects($school)
    {
        $subjectsData = json_decode($school->subjects, true);

        if (!$subjectsData || !is_array($subjectsData)) {
            throw new \Exception('Subjects data haipo au haifai.');
        }

        $schoolType = strtolower($school->school_type); // primary, secondary, advance
        $subjects = [];
        $classes = [];

        if ($schoolType === 'advance') {
            // Advance: subjects na combinations
            if (isset($subjectsData['combinations']) && is_array($subjectsData['combinations'])) {
                foreach ($subjectsData['combinations'] as $group => $combinations) {
                    foreach ($combinations as $combo) {
                        if (isset($combo['selected']) && $combo['selected']) {
                            $classes[] = $combo['code'] ?? $combo['name'] ?? 'Unknown';

                            if (isset($combo['name'])) {
                                $comboSubjects = explode(',', $combo['name']);
                                foreach ($comboSubjects as $subj) {
                                    $subj = trim($subj);
                                    if (!in_array($subj, $subjects)) {
                                        $subjects[] = $subj;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            // Primary or Secondary
            foreach ($subjectsData as $className => $subjectList) {
                $classes[] = $className;
                if (is_array($subjectList)) {
                    foreach ($subjectList as $subject => $status) {
                        if ($status && !in_array($subject, $subjects)) {
                            $subjects[] = $subject;
                        }
                    }
                }
            }
        }

        return [
            'subjects' => $subjects,
            'classes' => $classes,
            'schoolType' => $schoolType,
        ];
    }

    // Show registration form

    public function create()
    {
        $school_id = auth()->user()->school_id;
        $school = DB::table('schools')->where('school_id', $school_id)->first();

        if (!$school) {
            abort(404, 'School haikupatikana.');
        }

        try {
            $data = $this->getSchoolClassesAndSubjects($school);
            $subjects = $data['subjects'];
            $classes = $data['classes'];
            $schoolType = $data['schoolType'];
        } catch (\Exception $e) {
            $subjects = [];
            $classes = [];
            $schoolType = '';
        }

        return view('teacher.register', compact('subjects', 'classes', 'schoolType'));
    }
    
    public function store(Request $request)
{
   
    $e = $request->validate([
    'username' => 'required|string|max:255',
    'password' => 'required|string|min:6|confirmed',
    'subjects' => 'nullable|array',
    'classes' => 'nullable|array',
    'full_name'=> 'required|string|max:255',
    'blood_group'=> 'required|string|max:10',
    'gender'=> 'required|string',
    'teacher_email'=> 'required|email',
    'phone_number'=> 'required|string|max:20',
    'nida_number'=> 'required|string|max:20',
    'address'=> 'required|string|max:60',
    'city'=> 'required|string|max:60',
    'district'=> 'required|string|max:60',
    'class_incharge' => 'nullable|string|max:255',
    'date_of_birth' => 'required|date',
    'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

]);
    $school_id = auth()->user()->school_id;
    $school = DB::table('schools')->where('school_id', $school_id)->first();

    if (!$school) {
        return back()->withErrors(['school' => 'School not found.']);
    }

    // Hapa tunarekebisha tu: subjects zitahifadhiwa kwa class
    $teachingData = $request->input('teaching', []);

    $selectedClasses = [];
    $structuredSubjects = [];

    foreach ($teachingData as $class => $subjects) {
        if (!empty($subjects)) {
            $selectedClasses[] = $class;

            foreach ($subjects as $subject) {
                $structuredSubjects[$class][$subject] = true;
            }
        }
    }

    $isClassTeacher = $request->has('is_class_teacher') ? 1 : 0;
    $classInCharge = $isClassTeacher ? $request->input('class_incharge') : null;


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


    // Hii ndiyo sehemu pekee iliyobadilika: tunahifadhi structure mpya ya subjects
    Teacher::create([
        'school_id' => $school->school_id,
        'school_name' => $school->school_name,
        'teacher_id' => uniqid('TCH-'),
        'full_name' => $request->full_name,
        'gender' => $request->gender,
        'date_of_birth' => $request->date_of_birth,
        'blood_group' => $request->blood_group,
        'phone_number' => $request->phone_number,
        'teacher_email' => $request->teacher_email,
        'nida_number'=> $request->nida_number,
        'city'=> $request->city,
        'district'=> $request->district,
        'address'=> $request->address,
        'name' => $request->username,
        'password' => bcrypt($request->password),
        'subjects' => json_encode($structuredSubjects),
        'classes' => json_encode($selectedClasses),
        'role' => 'teacher',
        'is_class_teacher' => $isClassTeacher,
        'class_incharge' => $classInCharge,
        'photo' => $photoBinary,
        
    ]);

    return redirect()->back()->with('success', 'Mwalimu amesajiliwa kikamilifu.');
}

}
