<?php

namespace App\Http\Controllers;
use Illuminate\Support\facades\DB;
use App\Models\Accountant;

use Illuminate\Http\Request;

class AccountantController extends Controller
{
    //

    protected function getSchoolInfo($school_id)
{
    $school = DB::table('schools')->where('school_id', $school_id)->first();

    if (!$school) {
        throw new \Exception('School haikupatikana.');
    }

    $schoolType = strtolower($school->school_type); // primary, secondary, advance

    return [
        'school_id' => $school_id,
        'schoolType' => $schoolType,
    ];
}
public function create()
{
    $school_id = auth()->user()->school_id;

    try {
        $data = $this->getSchoolInfo($school_id);
        $schoolType = $data['schoolType'];
    } catch (\Exception $e) {
        $schoolType = '';
    }

    return view('accountant.register', compact('schoolType', 'school_id'));
}
public function store(Request $request)
{
    $e = $request->validate([
    'username' => 'required|string|max:255',
    'password' => 'required|string|min:8|',
    'full_name'=> 'required|string|max:255',
    'blood_group'=> 'required|string|max:10',
    'gender'=> 'required|string',
    'accountant_email'=> 'required|email',
    'phone_number'=> 'required|string|max:20',
    'nida_number'=> 'required|string|max:20',
    'address'=> 'required|string|max:60',
    'city'=> 'required|string|max:60',
    'district'=> 'required|string|max:60',
    'photo' => 'required|image|max:2048', 
    'date_of_birth' => 'required|date',

]);

    $school_id = auth()->user()->school_id;
    $school = DB::table('schools')->where('school_id', $school_id)->first();

    if (!$school) {
        return back()->withErrors(['school' => 'School not found.']);
    }


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
    Accountant::create([
        'school_id' => $school->school_id,
        'school_name' => $school->school_name,
        'accountant_id' => uniqid('ACC-'),
        'full_name' => $request->full_name,
        'gender' => $request->gender,
        'date_of_birth' => $request->date_of_birth,
        'blood_group' => $request->blood_group,
        'phone_number' => $request->phone_number,
        'accountant_email' => $request->accountant_email,
        'nida_number'=> $request->nida_number,
        'city'=> $request->city,
        'district'=> $request->district,
        'address'=> $request->address,
        'name' => $request->username,
        'password' => bcrypt($request->password),
        'role' => 'accountant',
        'photo' => $photoBinary,
        
    ]);

    return redirect()->back()->with('success', 'Accountant registered successfully.');
}

}
