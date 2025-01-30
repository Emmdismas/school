<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentlistController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminRegistrationController;

//ADMIN REGISTRATION 
Route::get('/admin/create', [AdminRegistrationController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [AdminRegistrationController::class, 'store'])->name('admin.store');

//LOGIN SYSTEM
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});
//CHATBOT ROUTES
// API.PHP
Route::get('/attendance/{class}/{student_number}', [AttendanceController::class, 'getStudentAttendance']);

Route::get('/login', function () {
    return view('login.index');
});


//CHATBOT ROUTE
Route::post('/webhook', [ChatbotController::class, 'handleWebhook']);

Route::get('/version', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

//HOME ROUTES
Route::get('/', function (){
    return view ('home');
});

//STUDENT

//Register students

Route::post('/student_store', [StudentlistController::class, 'store'])->name('student.register');
Route::get('/student_register', [StudentlistController::class, 'create'])->name('register.create');


//view students
Route::get('/student_index/{class}', [StudentController::class, 'index'])->name('student.index');
Route::post('/student/{class}', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/form/{class}', [StudentController::class, 'create'])->name('student.create');

//ATTENDANCE
Route::get('/attendance/{class}', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/{class}', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/summary/{class}', [AttendanceReportController::class, 'index'])->name('attendance.summary');
Route::get('/attendance/show/{class}', [AttendanceReportController::class, 'show'])->name('attendance.show');


//Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');



//MARKS

Route::get('/marks/{examType}/{class}', [MarksController::class, 'create'])->name('marks.create'); // GET
Route::post('/marks/{examType}/{class}', [MarksController::class, 'store'])->name('marks.store'); // POST
Route::get('/marks/{examType}/{class}/view', [MarksController::class, 'show'])->name('marks.show'); // GET
Route::get('/marks/index/{examType}/{class}', [MarksController::class, 'index'])->name('marks.index');


//PAYMENT

Route::get('/payment/{class}', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payment/form/{class}', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payment/{class}', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payment/{class}/{id}', [PaymentController::class, 'downloadReceipt'])->name('payments.receipt');

//ASSIGNMENT
Route::get('/assignments_index/{type}/{class}', [AssignmentController::class, 'index'])->name('assignments.index');
Route::post('/assignments/{type}/{class}', [AssignmentController::class, 'store'])->name('assignments.store');
Route::get('/assignments_create/{type}/{class}', [AssignmentController::class, 'create'])->name('assignments.create');
Route::get('/assignments/{type}/{class}', [AssignmentController::class, 'download'])->name('assignments.download');
Route::get('/assignments/{type}/{class}/{id}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');




// ADMIN REGISTRATION
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/create', [AdminRegistrationController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminRegistrationController::class, 'store'])->name('admin.store');
});


// ATTENDANCE
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/attendance/{class}', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/{class}', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/summary/{class}', [AttendanceReportController::class, 'index'])->name('attendance.summary');
    Route::get('/attendance/show/{class}', [AttendanceReportController::class, 'show'])->name('attendance.show');
});



// VIEW STUDENTS
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student_index/{class}', [StudentController::class, 'index'])->name('student.index');
    Route::post('/student/{class}', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/form/{class}', [StudentController::class, 'create'])->name('student.create');
});
