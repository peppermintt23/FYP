<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentDashboardController extends Controller
{
    // app/Http/Controllers/StudentDashboardController.php

    public function index()
    {
        $studentId = Auth::id();
        $enrollment = \App\Models\CourseEnrollment::where('student_id', $studentId)->first();
        $courseId   = $enrollment->course_id ?? null;

        // Load topics and exercises
        $topics = \App\Models\Topic::with(['exercises' => function ($q) {
            $q->orderBy('id');
        }])->where('course_id', $courseId)->get();

        $answers = \App\Models\Answer::where('student_id', $studentId)
            ->orderByDesc('id')
            ->get()
            ->keyBy('exercise_id');

        // Calculate topic progress
        foreach ($topics as $topic) {
            $exercises      = $topic->exercises;
            $totalExercises = $exercises->count();
            $completed = 0;
            foreach ($exercises as $exercise) {
                $exercise->student_answer = $answers->get($exercise->id);
                $exercise->is_completed = $exercise->student_answer
                    && $exercise->student_answer->status === \App\Models\Answer::STATUS_3;
                if ($exercise->is_completed) {
                    $completed++;
                }
            }
            $topic->progress = $totalExercises > 0
                ? round(($completed / $totalExercises) * 100)
                : 0;
        }

        // Gather percentages for each topic
        $percentages = $topics->pluck('progress')->toArray();

        // Determine activeIdx: first incomplete, or last if all completed
        $activeIdx = collect($percentages)->search(fn($val) => $val < 100);
        if ($activeIdx === false) $activeIdx = count($percentages) - 1;


        return view('student-dashboard', [
            'topics'      => $topics,
            'percentages' => $percentages,
            'activeIdx'   => $activeIdx,
            'user'        => Auth::user(),
        ]);
    }



    public function overallJson($exerciseId)
    {
        // ...same leaderboard logic as in your 'overall' method...
        $user = Auth::user();
        $enrollment = \App\Models\CourseEnrollment::where('student_id', $user->id)->first();
        $myGroup = $enrollment?->groupCourse ?? null;
        $studentIds = \App\Models\CourseEnrollment::where('groupCourse', $myGroup)->pluck('student_id');
        $answers = Answer::with('student')
            ->where('exercise_id', $exerciseId)
            ->whereIn('student_id', $studentIds)
            ->whereIn('status', [
                'Completed - Submitted Feedback',
                'Completed - Pending Feedback'
            ])
            ->get();

        // Sort by score DESC, then time ASC
        $leaderboard = $answers->sortBy([
            ['student_score', 'desc'],
            ['elapsed_time', 'asc'],
        ])->values();

        return response()->json([
            'leaderboard' => $leaderboard->map(function ($entry) {
                return [
                    'name' => $entry->student->name,
                    'avatar' => $entry->student->avatar ?? 'default-avatar.png',
                    'student_score' => $entry->student_score,
                    'elapsed_time' => $entry->elapsed_time,
                ];
            }),
        ]);
    }
}
