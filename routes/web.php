
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\StudentController;
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
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\SchoolEventController;
use App\Http\Controllers\NotificationController;
//testing

Route::get('/n', function () {
    return view('home');
})->name('home');




Route::get('/addteacher', [TeacherController::class, 'create'])
     ->middleware('auth')
     ->name('teacher.add');


//ADMIN REGISTRATION 
Route::get('/admin/create', [AdminRegistrationController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [AdminRegistrationController::class, 'store'])->name('admin.store');


//CHATBOT ROUTES
// API.PHP
Route::get('/attendance/{class}/{student_id}', [AttendanceController::class, 'getStudentAttendance']);

//testing

//redirect
Route::get('/', function () {
    return redirect()->route('login');
});

//redirect login
Route::get('/login', function () {
    return view('login');
})->name('login');



// Routes za kila role
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('admin.home'); // Ukurasa wa admin
    })->name('home');

    Route::get('/headmaster', function () {
        return view('headmaster.dashboard'); // Ukurasa wa headmaster
    })->name('headmaster');

    Route::get('/Accountant', function () {
        return view('accountant.dashboard'); // Ukurasa wa accountant
    })->name('accountant');

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
Route::get('/school/edit', [SchoolController::class, 'edit'])->name('school.edit');
Route::put('/school/update', [SchoolController::class, 'update'])->name('school.update');

//STUDENT

//Register students

Route::post('/student_store', [StudentController::class, 'store'])->name('student.register');
Route::get('/student_register', [StudentController::class, 'create'])->name('register.create'); //student registration
Route::get('/students/edit/{student_id}', [StudentController::class, 'edit'])->name('students.edit');// Route for editing the student
Route::put('/students/update/{student_id}', [StudentController::class, 'update'])->name('students.update'); // Route for updating the student data

//Teachers routes

Route::middleware('auth')->group(function () {
    Route::get('/teacher/register', [TeacherController::class, 'create'])->name('teacher.register');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
});

//Accountant

Route::middleware('auth')->group(function () {
    Route::get('/accountant/register', [AccountantController::class, 'create'])->name('accountant.register');
    Route::post('/accountant/store', [AccountantController::class, 'store'])->name('accountant.store');
});

//SMS ROUTES
Route::get('/notifications/status', [NotificationController::class, 'status'])->name('notifications.status');


//view students
Route::get('/student_index/{class}', [StudentController::class, 'index'])->name('student.index');
Route::post('/student/{class}', [StudentController::class, 'store'])->name('student.store');
Route::get('/student/form/{class}', [StudentController::class , 'create'])->name('student.create');
//Student Profile
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

//EVENTS
Route::get('/events', [SchoolEventController::class, 'index'])->name('school-events.index');
Route::post('/events', [SchoolEventController::class, 'store'])->name('school-events.store');
Route::post('/add/events', [SchoolEventController::class, 'create'])->name('school-events.add');



//MARKS
Route::post('/marks/{class}/store', [MarksController::class, 'store'])->name('marks.store');
Route::get('/marks/{class}/create', [MarksController::class, 'create'])->name('marks.create');
Route::get('/marks/{class}/view', [MarksController::class, 'show'])->name('marks.show');
Route::get('/marks/{class}/index', [MarksController::class, 'index'])->name('marks.index');
Route::get('/marks/{class}/edit', [MarksController::class, 'edit'])->name('marks.edit');
Route::post('/marks/{class}/update', [MarksController::class, 'update'])->name('marks.update');


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


//LOGIN ROUTES
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
