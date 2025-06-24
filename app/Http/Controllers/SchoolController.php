<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemUser;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function create()
    {
        return view('admin.schools');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'school_name' => 'required|string|max:255',
        'school_id' => 'required|integer|unique:schools,school_id',
        'region' => 'required|string',
        'district' => 'required|string',
        'school_type' => 'required|string',
        'number_of_students' => 'integer',
        'number_of_teachers' => 'integer',
    ]);

    // Process grades
    $grades = $this->processGrades($request);

    // Process subjects
    $subjects = [];
    if ($request->school_type === 'primary') {
        $subjects = $this->processPrimarySubjects($request);
    } elseif ($request->school_type === 'secondary') {
        $subjects = $this->processSecondarySubjects($request);
    } elseif ($request->school_type === 'advance') {
        $subjects = $this->processAdvanceCombinations($request);
    }

    // Process fees structure
    $feesStructure = $this->processFeesStructure($request);

    // Create the School with JSON encoded data
    School::create([
        'school_name' => $validated['school_name'],
        'school_id' => $validated['school_id'],
        'region' => $validated['region'],
        'district' => $validated['district'],
        'school_type' => $validated['school_type'],
        'fees_structure' => $feesStructure,
        'grades' => $grades,
        'subjects' => $subjects, // This will be automatically cast to JSON
        'number_of_students' => $validated['number_of_students'] ?? 0,
        'number_of_teachers' => $validated['number_of_teachers'] ?? 0,
    ]);

    return redirect()->route('schools.create')->with('success', 'School registered successfully!');
}
    private function processGrades(Request $request): array
    {
        if ($request->school_type === 'advance') {
            return [
                "A" => ["from" => $request->grade_A_from, "to" => $request->grade_A_to],
                "B" => ["from" => $request->grade_B_from, "to" => $request->grade_B_to],
                "C" => ["from" => $request->grade_C_from, "to" => $request->grade_C_to],
                "D" => ["from" => $request->grade_D_from, "to" => $request->grade_D_to],
                "E" => ["from" => $request->grade_E_from, "to" => $request->grade_E_to],
                "S" => ["from" => $request->grade_S_from, "to" => $request->grade_S_to],
                "F" => ["from" => $request->grade_F_from_advance, "to" => $request->grade_F_to_advance],
            ];
        }

        return [
            "A" => ["from" => $request->grade_A_from, "to" => $request->grade_A_to],
            "B" => ["from" => $request->grade_B_from, "to" => $request->grade_B_to],
            "C" => ["from" => $request->grade_C_from, "to" => $request->grade_C_to],
            "D" => ["from" => $request->grade_D_from, "to" => $request->grade_D_to],
            "F" => ["from" => $request->grade_F_from, "to" => $request->grade_F_to],
        ];
    }

    private function processPrimarySubjects(Request $request): array
    {
        $subjects = [];
        for ($std = 1; $std <= 7; $std++) {
            $subjects["Standard $std"] = [
                'English' => $request->has("primary_std{$std}_english"),
                'Mathematics' => $request->has("primary_std{$std}_mathematics"),
                'Science' => $request->has("primary_std{$std}_science"),
                'Civics' => $request->has("primary_std{$std}_civics"),
                'Kiswahili' => $request->has("primary_std{$std}_kiswahili"),
                'History' => $request->has("primary_std{$std}_History"),
                'Geography' => $request->has("primary_std{$std}_Geography"),
                'S/Work' => $request->has("primary_std{$std}_skazi"),
                'M/Jamii' => $request->has("primary_std{$std}_Maarifa"),
            ];
        }
        return $subjects;
    }

    private function processSecondarySubjects(Request $request): array
    {
        $subjects = [];
        for ($form = 1; $form <= 2; $form++) {
            $subjects["Form $form"] = [
                'Physics' => $request->has("secondary_form{$form}_physics"),
                'Chemistry' => $request->has("secondary_form{$form}_chemistry"),
                'Biology' => $request->has("secondary_form{$form}_biology"),
                'Geography' => $request->has("secondary_form{$form}_geography"),
                'History' => $request->has("secondary_form{$form}_history"),
                'Mathematics' => $request->has("secondary_form{$form}_mathematics"),
                'English' => $request->has("secondary_form{$form}_english"),
                'Kiswahili' => $request->has("secondary_form{$form}_kiswahili"),
                'Civics' => $request->has("secondary_form{$form}_civics"),
            ];
        }
        return $subjects;
    }

    private function processAdvanceCombinations(Request $request): array
    {
        $combinations = [];
        
        // Process selected combinations
        $selectedCombinations = $request->input('combinations', []);
        
        // Define all possible combinations
        $allCombinations = [
            'science' => [
                'PCM' => 'Physics, Chemistry, Mathematics',
                'PCB' => 'Physics, Chemistry, Biology',
                'PGM' => 'Physics, Geography, Mathematics',
                'PMCs' => 'Physics, Mathematics, Computer Science'
            ],
            'arts' => [
                'HGE' => 'History, Geography, Economics',
                'HKL' => 'History, Kiswahili, English',
                'HGAr' => 'History, Geography, Arabic',
                'HGL' => 'History, Geography, English'
            ],
            'business' => [
                'EBuAc' => 'Economics, Business Studies, Accountancy',
                'ECAc' => 'Economics, Commerce, Accountancy',
                'EGM' => 'Economics, Geography, Mathematics'
            ],
            'technical' => [
                'BNS' => 'Biology, Nutrition, Sports',
                'KLF' => 'Kiswahili, English, French',
                'KArCh' => 'Kiswahili, Arabic, Chinese'
            ]
        ];

        // Organize combinations by type and selection status
        foreach ($allCombinations as $type => $comboList) {
            foreach ($comboList as $code => $name) {
                if (in_array($code, $selectedCombinations)) {
                    $combinations[$type][] = [
                        'code' => $code,
                        'name' => $name,
                        'selected' => true
                    ];
                }
            }
        }

        return ['combinations' => $combinations];
    }

    private function processFeesStructure(Request $request): array
    {
        $feesStructure = [];
        
        if ($request->school_type === 'primary') {
            for ($std = 1; $std <= 7; $std++) {
                $feesStructure["Standard $std"] = [
                    'tuition_fee' => $request->input("tuition_fee_std{$std}"),
                    'other_fee' => $request->input("other_fee_std{$std}"),
                    'total_fee' => $request->input("total_fee_std{$std}"),
                ];
            }
        } elseif ($request->school_type === 'secondary') {
            for ($form = 1; $form <= 4; $form++) {
                $feesStructure["Form $form"] = [
                    'tuition_fee' => $request->input("tuition_fee_form{$form}"),
                    'other_fee' => $request->input("other_fee_form{$form}"),
                    'total_fee' => $request->input("total_fee_form{$form}"),
                ];
            }
        } elseif ($request->school_type === 'advance') {
            for ($form = 5; $form <= 6; $form++) {
                $feesStructure["Form $form"] = [
                    'tuition_fee' => $request->input("tuition_fee_form{$form}"),
                    'other_fee' => $request->input("other_fee_form{$form}"),
                    'total_fee' => $request->input("total_fee_form{$form}"),
                ];
            }
        }
        
        return $feesStructure;
    }


    // app/Http/Controllers/SchoolController.php
public function edit()
{
    // 1. Pata school_id ya user aliyelogin
    $schoolId = Auth::user()->school_id;

    // 2. Tafuta shule kwenye database
    $school = School::where('school_id', $schoolId)->firstOrFail();

 

    // 3. Rudisha view na data za shule
    return view('admin.edit', compact('school'));
}

public function update(Request $request)
{
    // 1. Validate data
    $request->validate([
        'school_name' => 'required|string',
        'school_type' => 'required|in:primary,secondary,advance',
        'region' => 'required|string',
        'district' => 'required|string',
        'fees_structure' => 'nullable|array',
        'subjects' => 'nullable|array'
    ]);

    // 2. Pata school_id ya user
    $schoolId = Auth::user()->school_id;
    dd($schoolId); // itakatisha execution na kuonyesha school_id


    // 3. Update data kwenye database
    School::where('school_id', $schoolId)->update([
        'school_name' => $request->school_name,
        'school_type' => $request->school_type,
        'region' => $request->region,
        'district' => $request->district,
        'fees_structure' => $request->fees_structure,
        'subjects' => $request->subjects,
        'grades' => [
            'A' => ['from' => $request->grade_A_from, 'to' => $request->grade_A_to],
            'B' => ['from' => $request->grade_B_from, 'to' => $request->grade_B_to],
            // ... add other grades similarly
        ]
    ]);

    // 4. Rudisha kwa ukurasa huo kwa ujumbe wa mafanikio
    return back()->with('success', 'Data za shule zimebadilishwa kikamilifu!');
}
}