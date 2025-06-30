<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'exercise_id', 'step_number', 'answer','category',  'student_score','parent_answer_id'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exercise() {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

}
