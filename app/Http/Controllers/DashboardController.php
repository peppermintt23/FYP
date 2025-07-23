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

        // Get all groupCourse under this lecturer (no duplicate)
        $classes = CourseEnrollment::where('lecturer_id', $lecturer->id)
            ->select('groupCourse')
            ->distinct()
            ->get();

        $selectedGroup = $request->input('groupCourse');
        $selectedTopicId = $request->input('topic');
        $topics = \App\Models\Topic::all();

        $students = collect();
        $exercises = collect();
        $progressData = [];

        if ($selectedGroup && $selectedTopicId) {
            // Student bawah group
            $students = \App\Models\CourseEnrollment::with('student')
                ->where('groupCourse', $selectedGroup)
                ->where('lecturer_id', $lecturer->id)
                ->get()
                ->pluck('student')
                ->filter();

            $exercises = \App\Models\Exercise::where('topic_id', $selectedTopicId)->get();

            // For Chart.js
            foreach ($students as $student) {
                $exerciseStatuses = [];
                foreach ($exercises as $exercise) {
                    $answer = \App\Models\Answer::where('student_id', $student->id)
                        ->where('exercise_id', $exercise->id)
                        ->orderByDesc('updated_at')->first();

                    // 0: Not started, 1: STATUS_1, 2: STATUS_2, 3: STATUS_3
                    if ($answer) {
                        if ($answer->status == 'Completed Guideline') {
                            $exerciseStatuses[] = 1;
                        } elseif ($answer->status == 'Completed - Pending Feedback') {
                            $exerciseStatuses[] = 2;
                        } elseif ($answer->status == 'Completed - Submitted Feedback') {
                            $exerciseStatuses[] = 3;
                        } else {
                            $exerciseStatuses[] = 0;
                        }
                    } else {
                        $exerciseStatuses[] = 0;
                    }
                }
                $progressData[] = [
                    'student_name' => $student->name,
                    'statuses' => $exerciseStatuses,
                ];
            }
        }

        // For chart.js (easier to pass JSON)
        return view('dashboard', [
            'classes' => $classes,
            'topics' => $topics,
            'selectedGroup' => $selectedGroup,
            'selectedTopicId' => $selectedTopicId,
            'students' => $students,
            'exercises' => $exercises,
            'progressData' => $progressData,
        ]);
    }

}