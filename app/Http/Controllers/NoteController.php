<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;
class NoteController extends Controller
{
    public function store(Request $request, Topic $topic) {
        $request->validate(['file_note' => 'required|file|mimes:pdf']);
        $file = $request->file('file_note');
        $path = $file->store('notes', 'public');

        $topic->notes()->create([
            'file_note' => $path    
        ]);

        return redirect()->back()->with('success', 'Note uploaded.');
    }

    public function destroy(Note $note) {
        Storage::disk('public')->delete($note->file_note);
        $note->delete();
        return redirect()->back()->with('success', 'Note deleted.');
    }

    public function download($id)
    {
        $note = \App\Models\Note::findOrFail($id);
        return Storage::disk('public')->download( $note->file_note);
    }

    public function index()
{
    $topics = \App\Models\Topic::with('notes')->get(); // load topics with related notes
    return view('viewNote', compact('topics'));
}



}
