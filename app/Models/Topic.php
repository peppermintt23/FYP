<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['topic_title'];
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function showManageNotes()
    {
        $topics = Topic::with('notes')->get(); // eager load notes
        return view('manageNote', compact('topics'));
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
