<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgressReportController extends Controller
{
    public function viewReport()
    {
        $lecturerId = auth()->id();

        // 1. All groupCourse/class under this lecturer
        $classes = \App\Models\CourseEnrollment::where('lecturer_id', $lecturerId)
            ->select('groupCourse')
            ->distinct()
            ->pluck('groupCourse')
            ->toArray();

        // 2. All topics with exercises and their full scores
        $topics = \App\Models\Topic::with(['exercises' => function ($q) {
            $q->select('id', 'topic_id', 'score');
        }])->orderBy('id')->get();

        // ============ CLASS TABLE ============

        $summary = [];
        foreach ($classes as $groupCourse) {
            $studentIds = \App\Models\CourseEnrollment::where('groupCourse', $groupCourse)
                ->pluck('student_id')
                ->toArray();

            $totalPassed = 0;
            $topicsAvg = [];

            foreach ($topics as $topic) {
                $exerciseIds = $topic->exercises->pluck('id')->toArray();
                $exerciseScores = $topic->exercises->pluck('score', 'id');

                // Answers for this topic and class
                $answers = \App\Models\Answer::whereIn('student_id', $studentIds)
                    ->whereIn('exercise_id', $exerciseIds)
                    ->get()
                    ->groupBy('student_id');

                $studentTopicPercents = [];

                foreach ($studentIds as $sid) {
                    $studentAnswers = $answers[$sid] ?? collect();

                    $studentTotalScore = 0;
                    $studentMaxScore = 0;

                    foreach ($studentAnswers as $ans) {
                        $max = $exerciseScores[$ans->exercise_id] ?? 0;
                        if ($max > 0) {
                            $studentTotalScore += $ans->student_score;
                            $studentMaxScore += $max;
                        }
                    }

                    if ($studentMaxScore > 0) {
                        $percent = ($studentTotalScore / $studentMaxScore) * 100;
                        $studentTopicPercents[] = $percent;

                        if ($percent >= 50) {
                            $totalPassed++;
                        }
                    }
                }

                $topicAvg = count($studentTopicPercents) > 0
                    ? round(array_sum($studentTopicPercents) / count($studentTopicPercents), 1)
                    : 0;

                $topicsAvg[$topic->id] = $topicAvg;
            }

            $summary[$groupCourse] = [
                'topics' => $topicsAvg,
                'students_count' => count($studentIds),
                'students_passed' => $totalPassed,
            ];
        }

        // ============ TOPIC TABLE ============

        $detailed = [];
        foreach ($topics as $topic) {
            $row = ['topic' => $topic->topic_title];
            $totalClassAvg = 0;
            $totalClassCount = 0;

            foreach ($classes as $groupCourse) {
                $studentIds = \App\Models\CourseEnrollment::where('groupCourse', $groupCourse)
                    ->pluck('student_id')
                    ->toArray();

                $exerciseIds = $topic->exercises->pluck('id')->toArray();
                $exerciseScores = $topic->exercises->pluck('score', 'id');

                $answers = \App\Models\Answer::whereIn('student_id', $studentIds)
                    ->whereIn('exercise_id', $exerciseIds)
                    ->get()
                    ->groupBy('student_id');

                $studentAttempt = 0;
                $studentTopicPercents = [];

                foreach ($studentIds as $sid) {
                    $studentAnswers = $answers[$sid] ?? collect();

                    if ($studentAnswers->count() > 0) $studentAttempt++;

                    $studentTotalScore = 0;
                    $studentMaxScore = 0;

                    foreach ($studentAnswers as $ans) {
                        $max = $exerciseScores[$ans->exercise_id] ?? 0;
                        if ($max > 0) {
                            $studentTotalScore += $ans->student_score;
                            $studentMaxScore += $max;
                        }
                    }

                    if ($studentMaxScore > 0) {
                        $percent = ($studentTotalScore / $studentMaxScore) * 100;
                        $studentTopicPercents[] = $percent;
                    }
                }

                $totalStudent = count($studentIds) ?: 1;
                $avg = count($studentTopicPercents) > 0
                    ? round(array_sum($studentTopicPercents) / count($studentTopicPercents), 1)
                    : 0;

                $row[$groupCourse] = [
                    'attempt_string' => "{$studentAttempt}/{$totalStudent}",
                    'avg' => $avg,
                ];

                $totalClassAvg += $avg;
                $totalClassCount++;
            }

            $row['avg_score'] = $totalClassCount > 0 ? round($totalClassAvg / $totalClassCount, 1) : 0;
            $detailed[] = $row;
        }

        return view('progressReport', [
            'classes' => $classes,
            'topics' => $topics,
            'summary' => $summary,
            'detailed' => $detailed,
        ]);
    }
}
