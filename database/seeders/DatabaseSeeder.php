<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    { 
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        $instructor = User::create([
            'name' => 'John Instructor',
            'email' => 'instructor@lms.com',
            'password' => Hash::make('123456'),
            'role' => 'instructor'
        ]);

        $student = User::create([
            'name' => 'Rahim Student',
            'email' => 'student@lms.com',
            'password' => Hash::make('123456'),
            'role' => 'student'
        ]);
 
        $course = Course::create([
            'title' => 'Laravel for Beginners',
            'description' => 'Learn the basics of Laravel 11/12 step by step.',
            'price' => 49.99,
            'level' => 'beginner',
            'instructor_id' => $instructor->id
        ]);
 
        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Introduction to MVC',
            'content' => 'https://youtube.com/sample-video-link',
            'order' => 1
        ]);

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Setting up Migrations',
            'content' => 'In this lesson we will learn about database migrations.',
            'order' => 2
        ]);
 
        $student->enrolledCourses()->attach($course->id, [
            'status' => 'active',
            'enrolled_at' => now()
        ]);
 
        Review::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'rating' => 5,
            'comment' => 'Excellent course for beginners!'
        ]);
    }
}