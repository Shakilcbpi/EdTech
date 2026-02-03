<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\TokenAuthenticate;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth route
Route::get('/', [AuthController::class, 'LoginPage'])->name('loginPage');
Route::get('/registration-page', [AuthController::class, 'RegistrationPage'])->name('RegistrationPage');
Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard')->middleware(TokenAuthenticate::class);

//Course
Route::middleware(TokenAuthenticate::class)->group(function () {
    Route::get('/course-page', [CourseController::class, 'CoursePage'])->name('CoursePage');
    Route::get('/course-create', [CourseController::class, 'create'])->name('create');
    Route::get('/course-edit/{id}', [CourseController::class, 'edit'])->name('edit');
    Route::get('/course-delete/{id}', [CourseController::class, 'delete'])->name('delete');
    Route::get('/course-search', [CourseController::class, 'SearchCourse'])->name('course.search');
    Route::get('/course-details/{id}', [CourseController::class, 'course_details'])->name('details');

    //Enrollment
    Route::get('/enrollment-page', [StudentController::class, 'EnrollPage'])->name('EnrollPage');
});
