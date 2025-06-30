<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollment;
use App\Models\Topic;
use App\Models\Exercise;
use App\Models\Answer;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $lecturer = auth()->user();

        // Fetch lecturer's classes (CourseEnrollment)
        $classes = CourseEnrollment::where('lecturer_id', $lecturer->id)->get();

        // All existing topics
        $topics = Topic::all();

        // Get selected values from dropdown
        $selectedClassId = $request->input('class');
        $selectedTopicId = $request->input('topic');

        $studentsProgress = [];

        if ($selectedClassId && $selectedTopicId) {
            $enrollment = CourseEnrollment::with('students')
                          ->where('id', $selectedClassId)
                          ->where('lecturer_id', $lecturer->id)
                          ->first();

            if ($enrollment) {
                foreach ($enrollment->students as $student) {
                    // Assume you have a pivot or submissions table that links students to exercises.
                    // E.g: count of completed exercises vs total
                    $totalExercises = Exercise::where('topic_id', $selectedTopicId)->count();
                    $completed = Answer::where('student_id', $student->id)
                        ->whereHas('exercise', function ($query) use ($selectedTopicId) {
                            $query->where('topic_id', $selectedTopicId);
                        })
                        ->distinct('exercise_id')
                        ->count('exercise_id');

                    $progress = $totalExercises ? round(($completed / $totalExercises) * 100) : 0;

                    $studentsProgress[] = [
                        'name' => $student->name,
                        'student_id' => $student->student_id,
                        'progress' => $progress,
                    ];
                }
            }
        }

        return view('dashboard', [
            'classes' => $classes,
            'topics' => $topics,
            'selectedClassId' => $selectedClassId,
            'selectedTopicId' => $selectedTopicId,
            'studentsProgress' => $studentsProgress,
        ]);
    }
}
