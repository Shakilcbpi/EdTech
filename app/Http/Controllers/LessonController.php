<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class LessonController extends Controller
{

    //Create lesson
    public function store(Request $request, $courseId)
    {
        $user = $request->user();
        $userRole = $user->role;

        if ($userRole === 'student') {
            return ResponseHelper::Out('Fail', 'Access Denied! Students cannot create lessons.', 403);
        }

        $course = Course::find($courseId);

        if (!$course) {
            return ResponseHelper::Out('Fail', 'Course not found.', 404);
        }

        if ($userRole !== 'admin' && $course->instructor_id != $user->id) {
            return ResponseHelper::Out('Fail', 'You are not authorized to add lessons to this course.', 403);
        }

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'order'   => 'required|integer|min:1',
        ]);

        $lesson = Lesson::create([
            'course_id' => $courseId,
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'order'     => $validated['order'],
        ]);

        return ResponseHelper::Out('Success', $lesson, 200);
    }


    //update lesson
    public function update(Request $request, $lessonId)
    {
        $user = $request->user();
        $userRole = $user->role;

        $lesson = Lesson::find($lessonId);

        if (!$lesson) {
            return ResponseHelper::Out('Fail', 'Lesson not found', 404);
        }

        $course = Course::find($lesson->course_id);

        if ($userRole === 'student') {
            return ResponseHelper::Out('Fail', 'Access Denied!', 403);
        }

        if ($userRole !== 'admin' && $course->instructor_id != $user->id) {
            return ResponseHelper::Out('Fail', 'Unauthorized: You are not the owner of this course!', 403);
        }

        $lesson->update([
            'title'   => $request->input('title', $lesson->title),
            'content' => $request->input('content', $lesson->content),
            'order'   => $request->input('order', $lesson->order),
        ]);

        return ResponseHelper::Out('success', $lesson, 200);
    }

    //delete lesson
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $userRole =  $user->role;

        $lesson = Lesson::find($id);

        if (!$lesson) {
            return ResponseHelper::Out('Fail', 'Lesson not found', 404);
        }

        $course = Course::find($lesson->course_id);

        if ($userRole === 'admin' || ($userRole === 'instructor' && $course->instructor_id == $user->id)) {

            $lesson->delete();

            return ResponseHelper::Out('success', 'Lesson deleted successfully', 200);
        }

        return ResponseHelper::Out('Fail', 'Unauthorized! You cannot delete this lesson.', 403);
    }


    public function getLessonsByCourse($courseId)
    {
        $lessons = Lesson::where('course_id', $courseId)->orderBy('order', 'asc')->get();
        return response()->json($lessons);
    }
}
