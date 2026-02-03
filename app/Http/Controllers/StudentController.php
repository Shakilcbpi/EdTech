<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Helper\ResponseHelper;
use App\Models\Course;

class StudentController extends Controller
{

    public function EnrollPage()
    {
        $enrollments = Enrollment::with(['user', 'course'])->paginate(10);
        $courses = Course::all();
        return view('enroll.index', compact('enrollments', 'courses'));
    }

    public function myCourses(Request $request)
    {
        $user = $request->user();

        $enrollmentCourses = Enrollment::where('user_id', $user->id)->get();
        return ResponseHelper::Out('Success', $enrollmentCourses, 200);
    }

    //Enroll course
    public function enroll(Request $request, $courseId)
    {
        $user = $request->user();

        $exists = Enrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->first();

        if ($exists) {
            return ResponseHelper::Out('Success', 'You are already enrolled in this course', 400);
        }

        $enrollment = Enrollment::create([
            'user_id' =>  $user->id,
            'course_id' => $courseId,
            'status' => 'active',
            'enrolled_at' => now()
        ]);

        return ResponseHelper::Out('Success', $enrollment, 200);
    }

    public function reviewList($courseId)
    {
        $reviews = Review::where('course_id', $courseId)
            ->with(['user', 'course'])->get();
        return ResponseHelper::Out('Success', $reviews, 200);
    }

    //add review
    public function addReview(Request $request, $courseId)
    {
        $user = $request->user();

        $isEnrolled = User::find($user->id)->enrolledCourses()->where('course_id', $courseId)->exists();

        if (!$isEnrolled) {
            return ResponseHelper::Out('fail', 'You must enroll first to give review', 403);
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::updateOrCreate([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return response()->json(['message' => 'Review added successfully']);
        ResponseHelper::Out('Success', $review, 200);
    }
}
