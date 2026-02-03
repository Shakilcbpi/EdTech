<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Middleware\TokenAuthenticate;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LessonController;

//Login - Register 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
Route::post('/logout', [AuthController::class, 'logout']);



 

Route::middleware(TokenAuthenticate::class)->group(function () {
    //Courses
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::get('/courses/{id}', [CourseController::class, 'course_details']);
    Route::put('/courses/{id}', [CourseController::class, 'update']);
    Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
 
    //Courses enrollment
    Route::post('/courses/{courseId}/enroll', [StudentController::class, 'enroll']);
    Route::get('/my-courses', [StudentController::class, 'myCourses']);
    Route::post('/courses/{courseId}/review', [StudentController::class, 'addReview']);
    Route::get('/courses/{courseId}/review', [StudentController::class, 'reviewList']);

    
    //lesson 
    Route::post('/courses/{courseId}/lessons', [LessonController::class, 'store']);
    Route::get('/courses/{courseId}/lessons', [LessonController::class, 'getLessonsByCourse']);
    Route::put('/lessons/{id}', [LessonController::class, 'update']);
    Route::delete('/lessons/{id}', [LessonController::class, 'destroy']);

});
