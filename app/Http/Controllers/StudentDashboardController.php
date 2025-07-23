<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $enrollment = CourseEnrollment::where('student_id', $studentId)->first();
        $courseId   = $enrollment ? $enrollment->course_id : null;

        // 2) Load topics with their exercises
        $topics = Topic::with(['exercises' => function($q) {
                $q->orderBy('id');
            }])
            ->where('course_id', $courseId)
            ->get();

        $answers = Answer::where('student_id', $studentId)
            ->orderByDesc('id')
            ->get()
            ->keyBy('exercise_id');

        // 3) Compute each topic’s progress and attach to the model
        foreach ($topics as $topic) {
            $exercises      = $topic->exercises;
            $totalExercises = $exercises->count();

            $completed = 0;
            foreach ($exercises as $exercise) {
                // Attach the latest answer for this exercise (if any)
                $exercise->student_answer = $answers->get($exercise->id);

                // Mark as completed if the answer exists and is STATUS_3
                $exercise->is_completed = $exercise->student_answer
                    && $exercise->student_answer->status === Answer::STATUS_3;

                if ($exercise->is_completed) {
                    $completed++;
                }
            }

            $topic->progress = $totalExercises > 0
                ? round(($completed / $totalExercises) * 100)
                : 0;
        }

        // 4) Build the percentages array from topic->progress
        $percentages = $topics->pluck('progress')->toArray();

        $allExercises = $topics->flatMap->exercises;

        // how many total vs. completed (status === Answer::STATUS_3)
        $totalAll     = $allExercises->count();
        $completedAll = $allExercises->where('is_completed', true)->count();

        // overall percent (0-100)
        $overall = $totalAll
        ? round($completedAll / $totalAll * 100)
        : 0;

        // static “planet” milestones on the curve
        $mapMilestones = [0, 25, 50, 75, 100];

        // 5) Pass both to the view
        return view('student-dashboard', [
            'topics'      => $topics,
            'percentages' => $percentages,
            'mapMilestones'=> $mapMilestones,
            'overall'      => $overall,
            'user'         => Auth::user(), 
        ]);
    }
}
