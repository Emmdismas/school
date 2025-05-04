<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assignments;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $class)
{
    $type = $request->input('assignment_type'); // Fetch assignment type
    $validTypes = ['homework', 'homepackage'];
    $validClasses = [
        'Standard_1', 'Standard_2', 'Standard_3', 'Standard_4',
        'Standard_5', 'Standard_6', 'Standard_7',
        'Form_1', 'Form_2', 'Form_3', 'Form_4',
        'Form_5', 'Form_6'
    ];

    if (!in_array($class, $validClasses)) {
        return abort(404, 'Invalid assignment type or class.');
    }

    // Pata school_id ya mtumiaji aliyelogin
    $schoolId = Auth::user()->school_id ?? null;
    if (!$schoolId) {
        return abort(403, 'Unauthorized access.');
    }

    // Fetch assignments kwa school_id, class, na type
    $assignments = Assignments::where('school_id', $schoolId)
        ->where('class', $class)
        ->where('assignment_type', $type)
        ->get();

    $title = ucfirst($type) . ' Assignments for ' . str_replace('_', ' ', $class);
    $route = route('assignments.store', ['type' => $type, 'class' => $class]);

    return view('assignment.view', compact('assignments', 'type', 'class', 'title', 'route'));
}


    public function create(Request $request, $class)
    {
        $type = $request->input('assignment_type');
        
        $validTypes = ['homework', 'homepackage'];
        $validClasses = [  'Standard_1', 'Standard_2', 'Standard_3', 'Standard_4',
        'Standard_5', 'Standard_6', 'Standard_7',
        'Form_1', 'Form_2', 'Form_3', 'Form_4',
        'Form_5', 'Form_6'];

        if (!in_array($class, $validClasses)) {
            return abort(404, 'Invalid assignment class.');
        }


        $schoolId = Auth::user()->school_id ?? null;
        if (!$schoolId) {
            return abort(403, 'Unauthorized access.');
        }

        // Fetch assignments za school_id husika pekee
        $assignments = Assignments::where('school_id', $schoolId)
        ->where('class', $class)
        ->get();

        $title = ucfirst($type) . "Upload Assignment  for Class " . strtoupper($class);
      
        return view('assignment.upload', compact('title', 'type', 'class', 'assignments'));
    }

    public function store(Request $request, $class)
    {
        $type = $request->input('assignment_type');

        $validTypes = ['homework', 'homepackage'];
        $validClasses = [  'Standard_1', 'Standard_2', 'Standard_3', 'Standard_4',
        'Standard_5', 'Standard_6', 'Standard_7',
        'Form_1', 'Form_2', 'Form_3', 'Form_4',
        'Form_5', 'Form_6'];

        if (!in_array($type, $validTypes) || !in_array($class, $validClasses)) {
            return abort(404, 'Invalid assignment type or class.');
        }

        $request->validate([
            'assignment_name' => 'required|string|max:255',
            'subject_master' => 'required|string|max:255',
            'deadline' => 'required|date',
            'upload_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

 

        $schoolId = Auth::user()->school_id ?? null;
        if (!$schoolId) {
            return back()->with('error', 'User does not belong to any school.');
        }

        $fileContent = file_get_contents($request->file('upload_file')->getRealPath());
        $fileName = $request->file('upload_file')->getClientOriginalName();

        Assignments::create([
            'school_id' => $schoolId, 
            'class' => $class,
            'assignment_name' => $request->assignment_name,
            'assignment_type' => $type,
            'subject_master' => $request->subject_master,
            'deadline' => $request->deadline,
            'assignment_file' => $fileName,
            'file_content' => $fileContent,
        ]);

        return back()->with('success', 'Assignment uploaded successfully.');
    }

    public function download(Request $request, $class, $id)
    {
        $type = $request->input('assignment_type');
        $assignment = Assignments::find($id);

        if (!$assignment || $assignment->school_id !== Auth::user()->school_id) {
            abort(404, 'Assignment not found.');
        }

        return response($assignment->file_content)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', "attachment; filename=\"{$assignment->assignment_file}\"");
    }

    public function destroy(Request $request, $class, $id)
    {
        $type = $request->input('assignment_type');
        $validTypes = ['homework', 'homepackage'];
        $validClasses = [  'Standard_1', 'Standard_2', 'Standard_3', 'Standard_4',
        'Standard_5', 'Standard_6', 'Standard_7',
        'Form_1', 'Form_2', 'Form_3', 'Form_4',
        'Form_5', 'Form_6'];

        if (!in_array($class, $validClasses)) {
            return abort(404, 'Invalid assignment type or class.');
        }

        $assignment = Assignments::find($id);

        if (!$assignment || $assignment->school_id !== Auth::user()->school_id) {
            return abort(403, 'Unauthorized action.');
        }

        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }

   
}
