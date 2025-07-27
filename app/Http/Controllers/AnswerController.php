<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Answer;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnswerController extends Controller
{
    // for lecturer page: view student answer
    public function studentAnswer($exerciseId, $groupId)
    {
        $lecturerId = auth()->id();

        $answers = Answer::with('student')
            ->where('exercise_id', $exerciseId)
            ->where('parent_answer_id', 0)
            ->whereHas('student', function ($query) use ($groupId, $lecturerId) {
                $query->where('role', 'student')
                    ->whereHas('courseEnrollments', function ($q) use ($groupId, $lecturerId) {
                        $q->where('groupCourse', $groupId)
                            ->where('lecturer_id', $lecturerId);
                    });
            })
            ->get();



        $exercise = Exercise::findOrFail($exerciseId);

        return view('studentAnswerList', compact('answers', 'exercise', 'exerciseId', 'groupId'));
    }


    //student view list of exercise
    public function index()
    {
        $topics = Topic::with(['exercises.answers' => function ($query) {
            $query->where('student_id', auth()->id());
        }])->get();

        return view('viewExercise', compact('topics'));
    }

    //for student page: view exercise answer
    public function show(Exercise $exercise, Request $request)
    {
        $exercise->load('guidelines');

        $studentId = $request->input('student_id', auth()->id());
        //dd($studentId);

        // find any existing record (just to maybe preload)
        $existingAnswer = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->first();
        //dd($existingAnswer->status);
        $submittedGuideline = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->where('status', operator: Answer::STATUS_1)
            ->first();

        $submittedCode = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->where('status', operator: Answer::STATUS_2)
            ->first();

        $submittedFeedback = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->where('status', operator: Answer::STATUS_3)
            ->first();
        //dd($existingAnswer->status);
        return view('takeExercise', compact('exercise', 'submittedFeedback', 'existingAnswer', 'submittedGuideline', 'submittedCode', 'studentId'));
    }



    public function submitFinalExercise(Request $request, Exercise $exercise)
    {
           //     dd($request->all());

        // 1) Validate the incoming timing fields
        $data = $request->validate([
            'category'      => 'required|string',
            'start_time'    => 'required|date_format:Y-m-d H:i:s',
            'end_time'      => 'required|date_format:Y-m-d H:i:s',
            'elapsed_time'  => 'required|integer',
        ]);

        $studentId = auth()->id();
        $elapsed   = $data['elapsed_time'];

        $answer = Answer::where('student_id', $studentId)
        ->where('exercise_id', $exercise->id)
        ->where('category', $data['category'])
        ->first();

        if (!$answer) {
            return back()->with('error', 'Answer not found.');
        }


        $rawScore = $answer->student_score ?? 0;

        // 2) Calculate your score
        $finalScore = ($elapsed <= 60 && $rawScore > 0)
        ? $rawScore * 2
        : $rawScore;

        // 3) Update the answer record
        Answer::where('student_id', auth()->id())
            ->where('exercise_id', $exercise->id)
            ->where('category', $data['category'])
            ->update([
                'status'        => Answer::STATUS_2,
                'student_score' => $finalScore,
                'start_time'    => Carbon::parse($data['start_time'])->toDateTimeString(),
                'end_time'      => Carbon::parse($data['end_time'])->toDateTimeString(),
                'elapsed_time'  => $elapsed,
            ]);

        // 4) Redirect back
        return redirect()
            ->route('answer.show', ['exercise' => $exercise->id])
            ->with('info', 'Your compiler answer has been submitted!'
                . ($elapsed <= 600 ? ' 🎉 Double Score Awarded!' : ''));
    }

    //for student page: submit exercise
    public function submitExercise(Request $request, Exercise $exercise)
    {
        $request->validate([
            'student_answer' => 'required|array',
            'student_answer.*' => 'required|string',
            'status' => Answer::STATUS_1

        ]);

        // Check if student already submitted an guidelines
        $alreadySubmitted = Answer::where('student_id', auth()->id())
            ->where('exercise_id', $exercise->id)
            ->where('status', Answer::STATUS_1)
            ->first();

        if ($alreadySubmitted) {
            return redirect()->route('answer.show', ['exercise' => $exercise->id])
                ->with('info', 'You have already submitted this exercise.');
        }

        $mainAnswerThatNeedToAnswerAfterSubmitAnswerGuidelines = Answer::create([
            'category' => 'Need-Compiler',
            'exercise_id' => $exercise->id,
            'student_id' => auth()->id(),
            'step_number' => 100,
            'answer' => '',
            'parent_answer_id' => 0,
            'student_score' => 0,
            'status' => Answer::STATUS_1
        ]);
        $pa = $mainAnswerThatNeedToAnswerAfterSubmitAnswerGuidelines;

        //optional if have guideline
        foreach ($request->student_answer as $step_number => $answer) {
            Answer::create([
                'category' => 'Non-Compiler',
                'exercise_id' => $exercise->id,
                'student_id' => auth()->id(),
                'step_number' => $step_number,
                'answer' => $answer,
                'parent_answer_id' => $pa->id,
                'student_score' => 0
            ]);
        }

        return redirect()->route('answer.show', ['exercise' => $exercise->id])
            ->with('info', 'Answer checked!');
    }

    public function feedback(Exercise $exercise)
    {
        $studentId = auth()->id();

        // Fetch all answer rows for this exercise & student, ordered by step number
        $answers = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->where('category', 'Non-Compiler')
            ->orderBy('step_number')
            ->get();

        // Get the parent answer (for feedback & overall score)
        $parentAnswer = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->where('parent_answer_id', 0)
            ->first();

        return view('viewFeedback', compact('exercise', 'answers', 'parentAnswer'));
    }


    public function studentAnswerDetail($exerciseId, $groupId, $studentId)
    {
        // get exercise info
        $exercise = Exercise::findOrFail($exerciseId);

        // get answers submitted by the student
        $answers = Answer::where('exercise_id', $exerciseId)
            ->where('student_id', $studentId)
            ->get();

        // optionally get parent to show compiler type too
        $parentAnswer = Answer::where('exercise_id', $exerciseId)
            ->where('student_id', $studentId)
            ->where('parent_answer_id', 0)
            ->first();

        return view('studentAnswerDetail', compact('exercise', 'answers', 'groupId', 'studentId', 'parentAnswer'));
    }

    public function giveScore(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answers,id',
            'score' => 'required|integer|min:0|max:100',
        ]);

        $answer = Answer::findOrFail($request->answer_id);
        $answer->student_score = $request->score;
        $answer->save();

        return back()->with('success', 'Score updated!');
    }
    public function giveFeedback(Request $request)
    {
        $request->validate([
            'answer_id' => 'required|exists:answers,id',
            'feedback' => 'required|string',
            //'score' => 'required|numeric|min:0|max:20'
        ]);

        $answer = Answer::findOrFail($request->answer_id);
        $answer->feedback = $request->feedback;
       // $answer->student_score = $request->score;
        $answer->status = Answer::STATUS_3;

        if (!$answer->save()) {
            return back()->with('error', 'Failed to save feedback. Please try again.');
        }
        return back()->with('success', 'Feedback saved!');
    }


    public function saveScoresAndFeedback(Request $request)
    {

        $exerciseId = $request->input('exercise_id');
        $groupId = $request->input('group_id');
        $studentId = $request->input('student_id');

        $request->validate([
            //'scores' => 'required|array',
           // 'scores.*' => 'nullable|integer|min:0|max:100',
            'feedback' => 'nullable|string',
            'exercise_id' => 'required|integer',
            'student_id' => 'required|integer'
        ]);

        // update each individual score
        // foreach ($request->scores as $answerId => $score) {
        //     $answer = Answer::find($answerId);
        //     if ($answer && $answer->student_id == $request->student_id) {
        //         $answer->student_score = $score;
        //         $answer->save();
        //     }
        // }

        // update feedback in parent answer
        $parentAnswer = Answer::where('exercise_id', $request->exercise_id)
            ->where('student_id', $request->student_id)
            ->where('parent_answer_id', 0)
            ->first();

        if ($parentAnswer) {
            $parentAnswer->feedback = $request->feedback;
            $parentAnswer->save();
        }

        return redirect()->route('studentAnswerDetail', [$exerciseId, $groupId, $studentId])
            ->with('success', 'Successfully saved feedback and scores for student!');

        // return back()->with('success', 'Successfully saved feedback and scores for student');

    }
}
