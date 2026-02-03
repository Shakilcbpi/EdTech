<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class CourseController extends Controller
{
    public function CoursePage()
    {
        $courses = Course::with('instructor')->paginate(10);
        return view('course.index', compact('courses'));
    }

    public function index()
    {
        return Course::with('instructor')->get();
    }

    public function create()
    {
        return view('course.create');
    }

    public function edit($id)
    {
        $course = Course::where('id', $id)->first();
        return view('course.edit', compact('course'));
    }

    public function delete($id)
    {
        $course = Course::where('id', $id)->first();
        return view('course.delete', compact('course'));
    }

    public function SearchCourse(Request $request)
    {
        $searchTerm = $request->input('search');

        $courses = Course::with('instructor')
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->paginate(10);

        return view('course.index', compact('courses'));
    }


    //Course create
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role == 'student') {
            return  ResponseHelper::Out('Fail', 'Unauthorized', 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        $course = Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'level' => $validated['level'],
            'instructor_id' => $user->id,
        ]);

        return ResponseHelper::Out('Success', $course, 201);
    }


    // public function course_details($id)
    // {
    //     $course = Course::with(['instructor', 'lessons'])->findOrFail($id);

    //     return view('course.course-details', compact('course'));
    //    //return Course::where('id', $id)->with('instructor')->get();
    // }

    //Course details
    public function course_details(Request $request, $id)
    {
        $course = Course::with('instructor')->findOrFail($id);

        $searchTerm = $request->search;

        if ($searchTerm) {
            $lessons = $course->lessons()
                ->where('title', 'LIKE', "%$searchTerm%")
                ->orderBy('order', 'asc')
                ->paginate(5);
        } else {
            $lessons = $course->lessons()
                ->orderBy('order', 'asc')
                ->paginate(5);
        }
        return view('course.course-details', compact('course', 'lessons'));
    }


    //Course update
    public function update(Request $request, $id)
    {

        $user = $request->user();
        $courseQuery = Course::where('id', $id);

        if ($user->role != 'admin') {
            $courseQuery->where('instructor_id', $user->id);
        }
        $course = $courseQuery->first();

        if (!$course) {
            return  ResponseHelper::Out('Fail', 'Course not found or unauthorized', 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);
        $course->update($validated);
        return ResponseHelper::Out('Success', $course, 200);
    }

    //Course delete
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $userRole = $user->role;

        $course = Course::find($id);

        if (!$course) {
            return ResponseHelper::Out('Fail', 'Course not found', 404);
        }

        if ($userRole === 'admin' || ($userRole === 'instructor' && $course->instructor_id == $user->id)) {

            $course->delete();

            return ResponseHelper::Out('success', 'Course and its related data deleted successfully', 200);
        }

        return ResponseHelper::Out('Fail', 'Unauthorized! You are not the owner of this course.', 403);
    }
}
