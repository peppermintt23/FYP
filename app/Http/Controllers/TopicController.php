<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index() {
        $topics = Topic::with('notes')->get();
        return view('manageNote', compact('topics'));
    }

    public function store(Request $request) {
        $request->validate(['topic_title' => 'required']);
        Topic::create(['topic_title' => $request->input('topic_title')]);
        return redirect()->back()->with('success', 'Topic added.');
    }

    public function manageNotes()
    {
        $topics = Topic::with('notes')->get(); // Eager-load notes
        return view('manageNote', compact('topics'));
    }

    public function manageExercises()
    {
        $topics = Topic::with('exercises')->get(); // Eager load exercises
        return view('manageExercise', compact('topics'));
    }

    public function destroy(Topic $topic)
    {
        foreach ($topic->exercises as $exercise) {
            if ($exercise->answers()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete topic. Exercise has been answered.');
            }
        }

        $topic->delete();
        return redirect()->back()->with('success', 'Topic deleted.');
    }






}