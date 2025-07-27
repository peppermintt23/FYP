<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Exercise;
use App\Models\Answer;

class StudentLeaderboardController extends Controller
{
    public function personalLeaderboard()
    {
        $user = auth()->user();

        // Get all topics with exercises (ordered as you like)
        $topics = Topic::with(['exercises' => function ($q) {
            $q->orderBy('id');
        }])->orderBy('id')->get();

        // Get all answers by student, key by exercise_id for quick lookup
        $answers = Answer::where('student_id', $user->id)
            ->where('parent_answer_id', 0)
            ->orderBy('id', 'desc')
            ->get()
            ->unique('exercise_id') // keeps the first record per exercise_id (which is latest because of desc)
            ->keyBy('exercise_id');

        // Calculate total points
        $totalPoints = $answers->sum('student_score');

        return view('leaderboardPersonal', [
            'user'     => $user,
            'topics'      => $topics,
            'answers'     => $answers,
            'totalPoints' => $totalPoints,
        ]);
    }
    
    public function overall($exerciseId)
    {
        $user = Auth::user();

        // Get group
        $enrollment = \App\Models\CourseEnrollment::where('student_id', $user->id)->first();
        $myGroup = $enrollment?->groupCourse ?? null;

        // Only students in same group
        $studentIds = \App\Models\CourseEnrollment::where('groupCourse', $myGroup)->pluck('student_id');

        // Only answers for this exercise, completed
        $answers = Answer::with('student')
            ->where('exercise_id', $exerciseId)
            ->whereIn('student_id', $studentIds)
            ->whereIn('status', [
                'Completed - Submitted Feedback',
                'Completed - Pending Feedback'
            ])

            ->get();

        // Get exercise
        $exercise = Exercise::find($exerciseId);

        // Did current user answer?
        $userAnswered = $answers->where('student_id', $user->getAuthIdentifier())->isNotEmpty();

        $leaderboard = $answers
            ->sortBy(function($answer) {
                // negative score for descending, then time ascending
                return [-$answer->student_score, $answer->elapsed_time ?? PHP_INT_MAX];
            })
            ->values();

        return view('leaderboardOverall', [
            'leaderboard' => $leaderboard,
            'exercise'    => $exercise,
            'myGroup'     => $myGroup,
            'userAnswered'=> $userAnswered,
            'authUser'    => $user,
        ]);
    }


}

