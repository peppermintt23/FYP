<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;
class NoteController extends Controller
{
    public function store(Request $request, Topic $topic) {
        $request->validate(['file_note' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt,mp4|max:10240']);
        $file = $request->file('file_note');

        $original = $file->getClientOriginalName();

        $path = $file->storeAs(
        "notes/{$topic->id}",      // folder
        $original,                 // filename
        'public'                   // disk
        );

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

    public function show(Note $note)
    {
        $path = Storage::disk('public')->path($note->file_note);
        return response()->file($path);
    }

    
    public function index()
    {
        $topics = \App\Models\Topic::with('notes')->get(); // load topics with related notes
        return view('viewNote', compact('topics'));
    }



}
