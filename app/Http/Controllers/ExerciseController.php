<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Guideline;

class ExerciseController extends Controller
{
    // ExerciseController.php

    public function update_guideline(Request $request, Exercise $exercise, Guideline $guideline)
    {
        // Validate the guideline data
        $request->validate([
            'step_number' => 'required|integer',
            'step_description' => 'required|string',
            'expected_code' => 'required|string',
        ]);

        // Update the guideline with new data
        $guideline->update([
            'step_number' => $request->step_number,
            'step_description' => $request->step_description,
            'expected_code' => $request->expected_code,
        ]);

        return redirect()->route('exercises.edit', $exercise->id)->with('success', 'Guideline updated successfully.');
    }

    public function destroy_guideline(Exercise $exercise, Guideline $guideline)
    {
        // Delete the guideline
        $guideline->delete();

        return redirect()->route('exercises.edit', $exercise->id)->with('success', 'Guideline deleted successfully.');
    }

    // ExerciseController.php
    public function create_guideline(Request $request, Exercise $exercise)
    {
        // Validate guideline data
        $request->validate([
            'step_number' => 'required|integer',
            'step_description' => 'required|string',
            'expected_code' => 'required|string',
        ]);

        // Create the new guideline for the exercise
        $exercise->guidelines()->create([
            'step_number' => $request->step_number,
            'step_description' => $request->step_description,
            'expected_code' => $request->expected_code,
        ]);

        return redirect()->route('exercises.edit', $exercise->id)->with('success', 'Guideline added successfully.');
    }


    // Display the manage exercise page with topics and their exercises
    public function manageExercise()
    {
        $lecturerId = auth()->id();
        $groupCourses = \App\Models\CourseEnrollment::where('lecturer_id', $lecturerId)->pluck('groupCourse');
        $topics = Topic::whereIn('course_id', function($q) use ($groupCourses) {
            $q->select('course_id')
            ->from('course_enrollment')
            ->whereIn('groupCourse', $groupCourses);
        })->with('exercises')->get();

        return view('manageExercise', compact('topics'));
    }


    // Show form to create a new exercise under a specific topic
    public function create(Topic $topic)
    {
        return view('createExercise', compact('topic'));
    }

    // Store a new exercise
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'exercise_title' => 'required',
            'question' => 'required',
            'hint' => 'nullable',
            'score' => 'required|numeric|min:0',
            'has_guideline' => 'required',
        ]);
        //dd($request->input('has_guideline'));  // This will show the value of has_guideline being sent in the request

         // Find lecturer's current groupCourse for this topic
        $lecturerId = auth()->id();
        // Usually, lecturer chooses which class (groupCourse) this is for in a form dropdown.
        // For now, let's get all groupCourse(s) for this lecturer+course, or pick one:
        $enrollment = \App\Models\CourseEnrollment::where('lecturer_id', $lecturerId)
            ->where('course_id', $topic->course_id)
            ->first();

        // If you want to support selecting groupCourse in your form, replace below accordingly
        $groupCourse = $request->input('groupCourse', $enrollment ? $enrollment->groupCourse : null);


        // Create the exercise
        $exercise = $topic->exercises()->create([
            'exercise_title' => $request->exercise_title,
            'question' => $request->question,
            'hint' => $request->hint,
            'expected_output' => $request->hint,
            'score' => $request->score,
            'has_guideline' => $request->has_guideline,
            'groupCourse' => $groupCourse,
            'lecturer_id' => $lecturerId,
        ]);
        //dd($exercise); 

        // Create the guideline steps
        // foreach ($request->guidelines as $step) {
        //     $exercise->guidelines()->create([
        //         'step_number' => $step['step_number'],
        //         'step_description' => $step['step_description'],
        //         'expected_code' => $step['expected_code'],
        //     ]);
        // }

        //return redirect()->route('exercises.view')->with('success', 'Exercise created successfully.');
        return redirect()->route('exercises.edit', $exercise->id)->with('success', 'Exercise created successfully.');
    }

    // Show form to edit an existing exercise
    public function edit(Exercise $exercise)
    {
        $exercise->load('guidelines');
        return view('editExercise', compact('exercise'));
    }

    // Update exercise base info and steps
    public function update(Request $request, Exercise $exercise)
    {
        $exercise->exercise_title = $request->exercise_title;
        $exercise->question = $request->question;
        $exercise->hint = $request->hint;
        $exercise->score = $request->score;
        $exercise->expected_output = $request->expected_output;
        $exercise->has_guideline = $request->has_guideline === 'Yes' ? 'Yes' : 'No';

        // Force the model to be marked as "dirty" and trigger an update
        $exercise->forceFill([
            'exercise_title' => $request->exercise_title,
            'question' => $request->question,
            'hint' => $request->hint,
            'score' => $request->score,
            'expected_output' => $request->expected_output,
            'has_guideline' => $request->has_guideline === 'Yes' ? 'Yes' : 'No',
        ]);

        $exercise->save();  // Force the save to happen

        return back()->with('success', 'Exercise updated successfully.');
    }


    // View student answers
    public function answers(Exercise $exercise)
    {
        $answers = $exercise->answers()->with('student')->get();
        return view('exerciseAnswers', compact('exercise', 'answers'));
    }

    public function destroy(Exercise $exercise)
    {
        // Check if any student has answered this exercise
        $hasAnswer = $exercise->answers()->exists();

        if ($hasAnswer) {
            // Redirect back with error message
            return back()->with('error', 'This exercise has been answered already');
        }

        $exercise->delete();
        return back()->with('success', 'Exercise deleted successfully.');
    }

}
