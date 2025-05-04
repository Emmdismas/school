<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\PaymentRecords;
use App\Models\Students;

class PaymentController extends Controller
{
    public function index($class)
    {
        $school_id = auth()->user()->school_id;

        $payments  = PaymentRecords::where('class', $class)
        ->where('school_id', $school_id)
        ->get();

        return view('payment.view', compact('payments', 'class'));
    }

    public function create($class)
    {
        $school_id = auth()->user()->school_id;
        
        // Fetch students from class table
            $students = Students::where('class', $class)
            ->where('school_id', $school_id)
            ->get();

        if ($students->isEmpty()) {
            return back()->withErrors("No students found for {$class} in this school.");
        }

        return view('payment.upload', compact('students', 'class'));
    }

    public function store(Request $request, $class)
    {

            $validated = $request->validate([
                'student_id' => 'required|integer',
                'student_name' => 'required|string',
                'payment_type' => 'required|string',
                'amount' => 'required|numeric|min:1',
                'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'academic_year' => 'required|string',
            ]);

           
    
        $schoolId = Auth::user()->school_id ?? null;
        if (!$schoolId) {
            return back()->with('error', 'User does not belong to any school.');
        }

        $fileContent = file_get_contents($request->file('receipt')->getRealPath());
        $fileName = $request->file('receipt')->getClientOriginalName();


        PaymentRecords::create([
            'school_id' => $schoolId,
            'academic_year' => $validated['academic_year'],
            'class' => $class,
            'student_id' => $validated['student_id'],
            'student_name' => $validated['student_name'],
            'payment_type' => $validated['payment_type'],
            'amount' => $validated['amount'],
            'receipt_content' => $fileContent,
            'receipt_filename' => $fileName,
            
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }

    public function downloadReceipt($class, $id)
    {
        $school_id = auth()->user()->school_id;

        $payment = PaymentRecords::where('id', $id)
        ->where('class', $class)
        ->where('school_id', $school_id)
        ->firstOrFail();


        if (!$payment->receipt_content) {
            return abort(404, 'Receipt not found.');
        }

        $extension = pathinfo($payment->receipt_filename, PATHINFO_EXTENSION);
        $mimeType = match ($extension) {
            'pdf' => 'application/pdf',
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => 'application/octet-stream',
        };

        return Response::make($payment->receipt_content, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $payment->receipt_filename . '"',
        ]);
    }
}