<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Answer;
use App\Models\Exercise;
use App\Models\StepAnswer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    public function submitFeedback(){

    }

    // for lecturer page: view studemt answer
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

        return view('studentAnswer', compact('answers', 'exercise', 'exerciseId', 'groupId'));
    }

    public function showCompiler(Exercise $exercise, Request $request)
    {
        // Eager load guidelines
        $exercise->load('guidelines');

        // Get student_id from request parameter, fallback to logged-in user
        $student_id = $request->input('student_id', auth()->id());
        dd($student_id);
        // Find existing answer
        $existingAnswer = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $student_id)
            ->where('category', 'Need-Compiler')
            ->first();//main answer sebab ada needcomplier

        return view('show', compact('exercise', 'existingAnswer'));
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

        $existingAnswer = Answer::where('exercise_id', $exercise->id)
            ->where('student_id', $studentId)
            ->first();

        return view('takeExercise', compact('exercise', 'existingAnswer', 'studentId'));
    }


    //for student page: submit exercise
    public function submitFinalExercise(Request $request, Exercise $exercise)
    {
        $category = $request->input('category');

        Answer::where('student_id', auth()->id())
            ->where('exercise_id', $exercise->id)
            ->where('category', $category)
            ->update(['status' => 'Submitted Answer ']);

        return redirect()->route('answer.show', ['exercise' => $exercise->id])
            ->with('info', 'Your compiler answer has been submitted!');
    }




    //for student page: submit exercise
    public function submitExercise(Request $request, Exercise $exercise)
    {
        $request->validate([
            'student_answer' => 'required|array',
            'student_answer.*' => 'required|string'
        ]);

        // Check if student already submitted an answer
        $existing = Answer::where('student_id', auth()->id())
            ->where('exercise_id', $exercise->id)
            ->first();

        if ($existing) {
            return redirect()->route('answer.feedback', ['exercise' => $exercise->id])
                ->with('info', 'You have already submitted this exercise.');
        }

        $mainAnswerThatNeedToAnswerAfterSubmitAnswerGuidelines = Answer::create([
                'category' => 'Need-Compiler',
                'exercise_id' => $exercise->id,
                'student_id' => auth()->id(),
                'step_number' => 100,
                'answer' => '',
                'parent_answer_id' => 0,
                'student_score' => 0
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
                'parent_answer_id' => $pa->id ,
                'student_score' => 0
            ]);
        }

        return redirect()->route('answer.show', ['exercise' => $exercise->id])
            ->with('info', 'Answer checked!');
    }


    public function feedback(Exercise $exercise)
    {
        $answer = $exercise->answers()->where('student_id', auth()->id())->first();

        if (!$answer) {
            return redirect()->route('answer.index')->with('error', 'Answer not found.');
        }

        return view('viewFeedback', compact('exercise', 'answer'));
    }
}
