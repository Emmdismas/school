<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeworkTableClassA;
use App\Models\HomeworkTableClassB;
use App\Models\HomeworkTableClassC;
use App\Models\HomepackageTableClassA;
use App\Models\HomepackageTableClassB;
use App\Models\HomepackageTableClassC;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Index method to display assignments for a specific class and type
    public function index($type, $class)
    {
        // Validate type and class
        $validTypes = ['homework', 'homepackage'];
        $validClasses = ['Class_A', 'Class_B', 'Class_C'];

        if (!in_array($type, $validTypes) || !in_array($class, $validClasses)) {
            return abort(404, 'Invalid assignment type or class.');
        }

        // Get the appropriate model
        $model = $this->getModel($type, $class);

        // Fetch assignments using Eloquent
        $assignments = $model::all(); // Data now contains Eloquent objects

        // Prepare variables for the view
        $title = ucfirst($type) . ' Assignments for ' . str_replace('_', ' ', $class);
        $route = route('assignments.store', ['type' => $type, 'class' => $class]);

        // Return the view
        return view('assignment.view', compact('assignments', 'type', 'class', 'title', 'route'));

    }



    public function create($type, $class)
    {
        $title = ucfirst($type) . " for Class " . strtoupper($class);
        $route = route('assignments.store', ['type' => $type, 'class' => $class]);

        $model = $this->getModel($type, $class);
        $assignments = $model::all(); // Pata assignments zote kwa class na type

        return view('assignment.upload', compact('title', 'type', 'class', 'route', 'assignments'));
    }


    public function store(Request $request, $type, $class)
    {
        // Validate type and class
        $validTypes = ['homework', 'homepackage'];
        $validClasses = ['Class_A', 'Class_B', 'Class_C'];

        if (!in_array($type, $validTypes) || !in_array($class, $validClasses)) {
            return abort(404, 'Invalid assignment type or class.');
        }

        // Validate inputs
        $request->validate([
            'assignment_name' => 'required|string|max:255',
            'subject_matter' => 'required|string|max:255',
            'deadline' => 'required|date',
            'upload_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Get the appropriate model
        $model = $this->getModel($type, $class);

        // Store assignment content
        $fileContent = file_get_contents($request->file('upload_file')->getRealPath());
        $fileName = $request->file('upload_file')->getClientOriginalName();

        $model::create([
            'assignment_name' => $request->assignment_name,
            'subject_matter' => $request->subject_matter,
            'deadline' => $request->deadline,
            'assignment_file' => $fileName,
            'file_content' => $fileContent,
        ]);

        return back()->with('success', 'Assignment uploaded successfully.');
    }


    public function download($type, $class, $id)
    {
        $model = $this->getModel($type, $class);
        $assignment = $model::find($id);

        if (!$assignment) {
            abort(404, 'Assignment not found.');
        }

        $fileContent = $assignment->file_content;
        $fileName = $assignment->assignment_file;

        return response($fileContent)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
    }

    private function getModel($type, $class)
    {
        $modelMap = [
            'homework' => [
                'Class_A' => \App\Models\HomeworkTableClassA::class,
                'Class_B' => \App\Models\HomeworkTableClassB::class,
                'Class_C' => \App\Models\HomeworkTableClassC::class,
            ],
            'homepackage' => [
                'Class_A' => \App\Models\HomepackageTableClassA::class,
                'Class_B' => \App\Models\HomepackageTableClassB::class,
                'Class_C' => \App\Models\HomepackageTableClassC::class,
            ],
        ];

        if (isset($modelMap[$type][$class])) {
            return $modelMap[$type][$class];
        }

        throw new \Exception("Model not found for type: $type and class: $class");
    }


    // Method to view a specific assignment
    public function show()
    {

    }


    // Method to delete an assignment
    public function destroy($type, $class, $id)
    {
        // Validate type and class
        $validTypes = ['homework', 'homepackage'];
        $validClasses = ['Class_A', 'Class_B', 'Class_C'];

        if (!in_array($type, $validTypes) || !in_array($class, $validClasses)) {
            return abort(404, 'Invalid assignment type or class.');
        }

        $model = $this->getModel($type, $class);
        $assignment = $model::findOrFail($id);

        // Delete the file
        if (file_exists(storage_path('app/public/' . $assignment->assignment_file))) {
            unlink(storage_path('app/public/' . $assignment->assignment_file));
        }

        // Delete the record
        $assignment->delete();

        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }




    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
