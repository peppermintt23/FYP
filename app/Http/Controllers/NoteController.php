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
        $note = Note::findOrFail($id);
        return Storage::disk('public')->download( $note->file_note);
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);

        $path = storage_path('app/public/' . $note->file_note);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        $mime = \Illuminate\Support\Facades\File::mimeType($path);

        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }


    
    public function index()
    {
        $topics = Topic::with('notes')->get(); // load topics with related notes
        return view('viewNote', compact('topics'));
    }



}
