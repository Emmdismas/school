<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\PaymentRecords;
use App\Models\Students;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Helpers\UserHelper;

class PaymentController extends Controller
{
    public function index($class)
{
    $user = UserHelper::getLoggedInUser();

    if (!$user || !$user->school_id) {
        abort(403, 'Unauthorized or school not assigned.');
    }

    $schoolId = $user->school_id;

    $payments = PaymentRecords::where('class', $class)
        ->where('school_id', $schoolId)
        ->get();

    $school = DB::table('schools')->where('school_id', $schoolId)->first();

    $feeStructure = json_decode($school->fees_structure, true);
    $normalizedClass = ucwords(str_replace('_', ' ', strtolower($class)));
    $classFees = $feeStructure[$normalizedClass] ?? ['total_fee' => 1];

    $totalFee = (int) ($classFees['total_fee'] ?? 1);

    return view('payment.view', compact('payments', 'class', 'totalFee'));
}

    public function create($class)
    {
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;

        // Fetch students from class table
        $students = Students::where('class', $class)
            ->where('school_id', $schoolId)
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
        'academic_year' => 'required|string',
    ]);

    $user = UserHelper::getLoggedInUser();

    if (!$user || !$user->school_id) {
        abort(403, 'Unauthorized or school not assigned.');
    }

    $schoolId = $user->school_id;

    // Fetch school from DB
    $school = DB::table('schools')->where('school_id', $schoolId)->first();

    if (!$school) {
        abort(404, 'School not found.');
    }

    // Decode the fees_structure JSON
   // Decode the fees_structure JSON
$feeStructure = json_decode($school->fees_structure, true);

// Normalize class name: Standard_1 => Standard 1
$normalizedClass = ucwords(str_replace('_', ' ', strtolower($class)));

if (!isset($feeStructure[$normalizedClass])) {
    abort(400, "Fee structure for class '$normalizedClass' not found.");
}

$classFees = $feeStructure[$normalizedClass];

    $totalFee = isset($classFees['total_fee']) ? (int)$classFees['total_fee'] : 1;

    // Fetch previous payments
    $previousTotal = PaymentRecords::where('student_id', $validated['student_id'])
        ->where('academic_year', $validated['academic_year'])
        ->where('school_id', $schoolId)
        ->sum('amount_paid');

    $amountPaid = $validated['amount'];
    $totalPaid = $previousTotal + $amountPaid;

    // Calculate percentage
    $totalPercentage = ($totalPaid / $totalFee) * 100;

    // Save record
    PaymentRecords::create([
        'school_id' => $schoolId,
        'academic_year' => $validated['academic_year'],
        'class' => $class,
        'student_id' => $validated['student_id'],
        'student_name' => $validated['student_name'],
        'payment_type' => $validated['payment_type'],
        'amount_paid' => $amountPaid,
        'total_paid' => $totalPaid,
        'total_percentage' => $totalPercentage,
    ]);
    // Tafuta mwanafunzi
$student = Students::where('student_id', $validated['student_id'])->first();

$message = "Habari {$student->parent_name}, ada ya mwanao {$student->student_name} imethibitishwa kiasi cha shilingi {$amountPaid}. Ahsante kwa ushirikiano.";

Http::post(env('APP_URL') . '/api/notify/sms', [
    'phone' => $student->parent_number,
    'message' => $message
]);


    return redirect()->back()->with('success', 'Payment recorded successfully!');
}


    public function downloadReceipt($class, $id)
    {
        $user = UserHelper::getLoggedInUser();

        // Ikiwa user hajapatikana au hana school_id, rudisha 403
        if (!$user || !$user->school_id) {
            abort(403, 'Unauthorized or school not assigned.');
        }

        $schoolId = $user->school_id;

        $payment = PaymentRecords::where('id', $id)
            ->where('class', $class)
            ->where('school_id', $schoolId)
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