<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Exercise;
use App\Models\Answer;

class StudentLeaderboardController extends Controller
{
    public function personal()
    {
        $studentId = Auth::id();

        // Get all topics with their exercises
        $topics = Topic::with(['exercises' => function($q) {
            $q->orderBy('id');
        }])->orderBy('id')->get();

        // Get all answers by student, keyed by exercise_id
        $answers = Answer::where('student_id', $studentId)
            ->get()
            ->keyBy('exercise_id');

        // Calculate total points
        $totalPoints = $answers->sum('student_score');

        return view('leaderboardPersonal', [
            'topics'      => $topics,
            'answers'     => $answers,
            'totalPoints' => $totalPoints,
        ]);
    }

    public function personalData()
    {
        $studentId = Auth::id();
        $topics = Topic::with(['exercises' => function($q) {
            $q->orderBy('id');
        }])->orderBy('id')->get();
        $answers = Answer::where('student_id', $studentId)->get()->keyBy('exercise_id');
        $totalPoints = $answers->sum('student_score');
        
        // Return as JSON for frontend JS
        return response()->json([
            'topics'      => $topics,
            'answers'     => $answers,
            'totalPoints' => $totalPoints,
            'name'        => Auth::user()->name,
            'avatar'      => Auth::user()->avatar,
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
            ->where('status', 'Completed - Submitted Feedback') // or your completed status
            ->get();

        // Get exercise
        $exercise = Exercise::find($exerciseId);

        // Did current user answer?
        $userAnswered = $answers->where('student_id', $user->id)->isNotEmpty();

        // Sort by score DESC, then time ASC (if needed)
        $leaderboard = $answers->sortByDesc('student_score')->values();

        return view('leaderboardOverall', [
            'leaderboard' => $leaderboard,
            'exercise'    => $exercise,
            'myGroup'     => $myGroup,
            'userAnswered'=> $userAnswered,
            'authUser'    => $user,
        ]);
    }


}

