<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentListClassA;
use App\Models\StudentListClassB;
use App\Nodels\StudentListClassC;
use App\Models\PaymentRecordClassA;
use App\Models\PaymentRecordClassB;
use App\Models\PaymentRecordClassC;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($class)
    {
        $payments = match ($class) {
            'Class_A' => PaymentRecordClassA::with('student')->get(),
            'Class_B' => PaymentRecordClassB::with('student')->get(),
            'Class_C' => PaymentRecordClassC::with('student')->get(),
            default => abort(404, 'Invalid class selected.'),
        };

        return view('payment.view', compact('payments', 'class'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $class)
    {
        $students = match ($class) {
            'Class_A' => StudentListClassA::all(),
            'Class_B' => StudentListClassB::all(),
            'Class_C' => StudentListClassC::all(),
            default => collect(),
        };

        if ($students->isEmpty()) {
            return back()->withErrors("No students found for {$class}");
        }

        return view('payment.upload', compact('students', 'class'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $class)
    {
        // Validate class
        $validClasses = ['Class_A', 'Class_B', 'Class_C'];

        if (!in_array($class, $validClasses)) {
            return abort(404, 'Invalid class selected.');
        }

        // Validate request data
        $validated = $request->validate([
            'student_id' => 'required|exists:' . strtolower($class) . ',id', // Ensure student exists in the table
            'payment_type' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Get the file content
        $fileContent = file_get_contents($request->file('receipt')->getRealPath());

        // Save payment dynamically to the respective class table
        match ($class) {
            'Class_A' => PaymentRecordClassA::create([
                'student_id' => $validated['student_id'],
                'student_name' => $validated['student_name'],
                'payment_type' => $validated['payment_type'],
                'amount' => $validated['amount'],
                'receipt_content' => $fileContent, // Store file as binary
            ]),
            'Class_B' => PaymentRecordClassB::create([
                'student_id' => $validated['student_id'],
                'student_name' => $validated['student_name'],
                'payment_type' => $validated['payment_type'],
                'amount' => $validated['amount'],
                'receipt_content' => $fileContent,
            ]),
            'Class_C' => PaymentRecordClassC::create([
                'student_id' => $validated['student_id'],
                'student_name' => $validated['student_name'],
                'payment_type' => $validated['payment_type'],
                'amount' => $validated['amount'],
                'receipt_content' => $fileContent,
            ]),
            default => abort(404, 'Invalid class selected.'),
        };

        // Redirect back with success message
        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }



    public function downloadReceipt($class, $id)
{
    $payment = match ($class) {
        'Class_A' => PaymentRecordClassA::findOrFail($id),
        'Class_B' => PaymentRecordClassB::findOrFail($id),
        'Class_C' => PaymentRecordClassC::findOrFail($id),
        default => abort(404, 'Invalid class selected.'),
    };

    if (!$payment->receipt_content) {
        return abort(404, 'Receipt not found.');
    }

    $fileName = 'receipt_' . $payment->id . '.pdf'; // Customize as needed
    $headers = [
        'Content-Type' => 'application/pdf', // Change MIME type based on actual file type
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ];

    return response($payment->receipt_content, 200, $headers);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
    public function destroy(string $id)
    {
        //
    }


    // app/Http/Controllers/PaymentController.php
public function getStudentPayments($class, $student_number)
{
    // Validate class
    if (!in_array($class, ['Class_A', 'Class_B', 'Class_C'])) {
        return response()->json(['error' => 'Invalid Class'], 404);
    }

    // Fetch payments for the student
    $payments = match ($class) {
        'Class_A' => PaymentRecordClassA::where('student_number', $student_number)->get(),
        'Class_B' => PaymentRecordClassB::where('student_number', $student_number)->get(),
        'Class_C' => PaymentRecordClassC::where('student_number', $student_number)->get(),
        default => collect(),
    };

    if ($payments->isEmpty()) {
        return response()->json(['error' => 'No payments found'], 404);
    }

    return response()->json($payments);
}
}
