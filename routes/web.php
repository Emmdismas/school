
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
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AuthController;


Route::get('/n', function () {
    return view('home');
})->name('home');
//ADMIN REGISTRATION 
Route::get('/admin/create', [AdminRegistrationController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [AdminRegistrationController::class, 'store'])->name('admin.store');


//CHATBOT ROUTES
// API.PHP
Route::get('/attendance/{class}/{student_id}', [AttendanceController::class, 'getStudentAttendance']);

//testing

//redirexct

Route::get('/', function () {
    return redirect()->route('login');
});
// Routes za login na logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes za kila role
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('admin.home'); // Ukurasa wa admin
    })->name('home');

    Route::get('/headmaster', function () {
        return view('headmaster.dashboard'); // Ukurasa wa headmaster
    })->name('headmaster');

    Route::get('/teacher', function () {
        return view('teacher.dashboard'); // Ukurasa wa teacher
    })->name('teacher');
});
//testinggggg


//CHATBOT ROUTE
Route::post('/webhook', [ChatbotController::class, 'handleWebhook']);

Route::get('/version', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

//HOME ROUTES

//SCHOOLS ROUTES

Route::get('/school', [SchoolController::class, 'create'])->name('schools.create');
Route::post('/school', [SchoolController::class, 'store'])->name('schools.store');


//STUDENT

//Register students

Route::post('/student_store', [StudentController::class, 'store'])->name('student.register');
Route::get('/student_register', [StudentlistController::class, 'create'])->name('register.create'); //student profile
Route::get('/students/edit/{student_id}', [StudentController::class, 'edit'])->name('students.edit');// Route for editing the student
Route::put('/students/update/{student_id}', [StudentController::class, 'update'])->name('students.update'); // Route for updating the student data


//view students
Route::get('/student_index/{class}', [StudentController::class, 'index'])->name('student.index');
Route::post('/student/{class}', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/form/{class}', [StudentController::class , 'create'])->name('student.create');
Route::get('/students/{student_id}/{school_id}/profile', [StudentController::class, 'fullProfile'])->name('students.fullProfile');

//STUDENT PROFILE 
//testing profile

Route::get('/student/{student_id}', [StudentController::class, 'showProfile'])->name('student.profile');
Route::get('/student/{student_id}/pdf', [StudentController::class, 'generatePDF'])->name('student.pdf');


//ATTENDANCE
Route::get('/attendance-summary/{class}/summary', [AttendanceController::class, 'summary'])->name('attendance.summary');
Route::get('/attendance/{class}', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/store/{class}', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/{class}/details/{date}', [AttendanceController::class, 'details'])->name('attendance.details');

//Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');



//MARKS
Route::post('/marks/{class}/store', [MarksController::class, 'store'])->name('marks.store');
Route::get('/marks/{class}/create', [MarksController::class, 'create'])->name('marks.create');
Route::get('/marks/{class}/view', [MarksController::class, 'show'])->name('marks.show');
Route::get('/marks/{class}/index', [MarksController::class, 'index'])->name('marks.index');


//PAYMENT
Route::post('/payment/{class}/store', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payment/{class}/index', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payment/{class}/create', [PaymentController::class, 'create'])->name('payments.create');
Route::get('/payment/{class}/receipt/{id}', [PaymentController::class, 'downloadReceipt'])->name('payment.download');

//ASSIGNMENT
Route::get('/assignments_index/{class}', [AssignmentController::class, 'index'])->name('assignments.index');
Route::post('/assignments/{class}', [AssignmentController::class, 'store'])->name('assignments.store');
Route::get('/assignments_create/{class}', [AssignmentController::class, 'create'])->name('assignments.create');
Route::get('/assignments/download/{class}/{id}', [AssignmentController::class, 'download'])->name('assignments.download');
Route::delete('/assignments/{class}/{id}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');


//TESTING
//login
Route::get('/login', function () {
    return view('loginn');
})->name('login');

Route::post('/loginn_system', [AuthController::class, 'login'])->name('logiin');



Route::get('/profile', function () {
    return view('student.profile');
});





// VIEW STUDENTS
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('home');
    })->name('home');
});

Route::middleware(['auth', 'role:headmaster'])->group(function () {
    Route::get('/headmaster', function () {
        return view('headmaster.dashboard');
    })->name('headmaster');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher', function () {
        return view('teacher.dashboard');
    })->name('teacher');

});

